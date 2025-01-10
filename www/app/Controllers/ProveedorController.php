<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProveedorModel;

class ProveedorController extends BaseController
{

    private const ORDEN_DEFECTO = 1;
    public function proveedores()
    {
        $data = [
            'titulo' => 'Proveedores',
            'breadcrumb' => ['Listado', 'Proveedores']
        ];

        $filtros = [];

        if (!empty($_GET['cif'])) {
            $filtros['cif'] = "%" . $_GET['cif'] . "%";
        }
        if (!empty($_GET['codigo'])) {
            $filtros['codigo'] = "%" . $_GET['codigo'] . "%";
        }
        if(!empty($_GET['nombre'])){
            $filtros['nombre'] = "%" . $_GET['nombre'] . "%";
        }
        if(!empty($_GET['pais'])){
            $filtros['pais'] = "%" . $_GET['pais'] . "%";
        }
        if(!empty($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $filtros['email'] = "%" . $_GET['email'] . "%";
        }
        if(!empty($_GET['telefono'])){
            $filtros['telefono'] = "%" . $_GET['telefono'] . "%";
        }
        $order = $this->getOrderColumn();
        $data['order'] = $order;

        $copiaGet = $_GET;

        unset($copiaGet['page']);
        $data['queryStringNoPage'] = http_build_query($copiaGet);
        if(!empty($data['queryStringNoPage'])){
            $data['queryStringNoPage'] .= "&";
        }

        unset($copiaGet['order']);
        $data['queryString'] = http_build_query($copiaGet);
        if(!empty($data['queryString'])){
            $data['queryString'] .= "&";
        }

        $proveedorModel = new ProveedorModel();
        $registros = $proveedorModel->getCount($filtros);
        $page = (isset($_GET['page']) && filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT)) ?
            $this->getPage((int) $_GET['page'], $registros) : 1;
        $data['proveedores'] = $proveedorModel->getByFiltros($filtros, $order, $page);


        $data['input'] = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->view->showViews(
            array('templates/header.view.php', 'proveedores.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    private function checkForm(array $data)
    {
        $errors = [];

        if (empty($data['cif'])) {
            $errors['cif'] = "El nombre es requerido";
        } elseif (!preg_match('/^[A-Z][0-9]{7}[A-Z]$/', $data['cif'])) {
            $errors['cif'] = "El cif no es válido";
        }

        if (empty($data['codigo'])) {
            $errors['codigo'] = "El codigo es requerido";
        } elseif (mb_strlen($data['codigo'] > 10)) {
            $errors['codigo'] = "El codigo no puede tener más de 10 caracteres";
        }

        if (empty($data['nombre'])) {
            $errors['nombre'] = "El nombre es requerido";
        } elseif (mb_strlen($data['nombre']) > 255) {
            $errors['nombre'] = "El nombre no puede tener más de 255 caracteres";
        }

        if (empty($data['direccion'])) {
            $errors['direccion'] = "La dirección es requerido";
        } elseif (mb_strlen($data['nombre']) > 255) {
            $errors['direccion'] = "La dirección no puede tener más de 255 caracteres";
        }

        if (empty($data['website'])) {
            $errors['website'] = "La website es requerido";
        } elseif (!filter_var($data['website'], FILTER_VALIDATE_URL)) {
            $errors['website'] = "La website no es válida";
        } elseif (mb_strlen($data['nombre']) > 255) {
            $errors['website'] = "La website no puede tener más de 255 caracteres";
        }

        if (empty($data['pais'])) {
            $errors['pais'] = "El pais es requerido";
        } elseif (mb_strlen($data['pais']) > 100) {
            $errors['pais'] = "El pais no puede tener más de 100 caracteres";
        }

        if (empty($data['email'])) {
            $errors['email'] = "El email es requerido";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "El email es incorrecto";
        } elseif (mb_strlen($data['email']) > 255) {
            $errors['email'] = "El email no puede tener más de 255 caracteres";
        }

        if (empty($data['telefono'])) {
            $errors['telefono'] = "El teléfono es requerido";
        } elseif (!filter_var($data['telefono'], FILTER_VALIDATE_INT)) {
            $errors['telefono'] = "El teléfono es incorrecto";
        } elseif (!preg_match('/^[0-9]{9}$/', $data['telefono'])) {
            $errors['telefono'] = "El teléfono es incorrecto";
        }

        return $errors;
    }

    private function getOrderColumn()
    {
        if(isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if(abs((int)$_GET['order']) <= count(ProveedorModel::ORDER_COLUMNS)){
                return (int)$_GET['order'];
            }
        }
        return self::ORDEN_DEFECTO;
    }

    private function getPage($page, $registros, $pageSize = -1)
    {
        if($page < 1){
            $page = 1;
        }
        if($pageSize <= 0){
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        if($registros <= ProveedorModel::getOffSet($page, $pageSize)){
            $page = 1;
        }
        return $page;
    }
}