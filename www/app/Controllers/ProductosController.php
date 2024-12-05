<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProveedorModel;
use Com\Daw2\Models\UsuarioModel;
use Decimal\Decimal;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductosModel;

class ProductosController extends BaseController
{

    public const ORDER_DEFECTO = 1;

    public function productos()
    {
        $data = [
            'titulo' => 'Productos',
            'breadcrumb' => ['Listado', 'Productos']
        ];

        $categoriaModel = new CategoriaModel();
        $data['categorias'] = $categoriaModel->getAllCategorias();

        $proveedorModel = new ProveedorModel();
        $data['proveedores'] = $proveedorModel->getAll();

        $filtros = [];
        if (!empty($_GET['codigo'])) {
            $filtros['codigo'] = "%" . $_GET['codigo'] . "%";
        }
        if (!empty($_GET['nombre'])) {
            $filtros['nombre'] = "%" . $_GET['nombre'] . "%";
        }
        if (!empty($_GET['categoria'])) {
            $filtros['categoria'] = $_GET['categoria'];
        }
        if (!empty($_GET['proveedor'])) {
            $filtros['proveedor'] = $_GET['proveedor'];
        }
        if (!empty($_GET['stock_min']) && filter_var($_GET['stock_min'], FILTER_VALIDATE_INT)) {
            $filtros['stock_min'] = new Decimal($_GET['stock_min']);
        }
        if (!empty($_GET['stock_max']) && filter_var($_GET['stock_max'], FILTER_VALIDATE_INT)) {
            $filtros['stock_max'] = new Decimal($_GET['stock_max']);
        }
        if (!empty($_GET['pvp_min']) && filter_var($_GET['pvp_min'], FILTER_VALIDATE_FLOAT)) {
            $filtros['pvp_min'] = new Decimal($_GET['pvp_min']);
        }
        if (!empty($_GET['pvp_max']) && filter_var($_GET['pvp_max'], FILTER_VALIDATE_FLOAT)) {
            $filtros['pvp_max'] = new Decimal($_GET['pvp_max']);
        }

        $order = $this->getOrderColumn();
        $data['order'] = $order;

        $copia_GET = $_GET;
        unset($copia_GET['page']);
        $data['queryStringNoPage'] = http_build_query($copia_GET);
        if (!empty($copia_GET)) {
            $data['queryStringNoPage'] .= '&';
        }

        unset($copia_GET['order']);
        $data['queryString'] = http_build_query($copia_GET);
        if (!empty($copia_GET)) {
            $data['queryString'] .= '&';
        }

        $productosModel = new ProductosModel();
        $registros = $productosModel->countProductos($filtros);
        $page = isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT) ?
            $this->getPage((int)$_GET['page'], $registros) : 1;
        $data['page'] = $page;
        $data['maxPage'] = $this->getMaxPage($registros);
        $productos = $productosModel->filtrarProductos($filtros, $order, $page);

        $data['productos'] = $productos;

        $data['input'] = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $this->view->showViews(
            array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'),
            $data);
    }

    private function getOrderColumn(): int
    {
        if (isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(ProductosModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }
        return self::ORDER_DEFECTO;
    }

    private function getPage(int $page, int $registros, int $pageSize = -1): int
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($pageSize <= 0) {
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        if (ProductosModel::getOffset($page, $pageSize) >= $registros) {
            $page = 1;
        }
        return $page;
    }

    private function getMaxPage(int $registros, int $pageSize = -1): int
    {
        if ($pageSize <= 0) {
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        return (int)ceil($registros / $pageSize);
    }

    public function showNewProducto()
    {
        $data = [
            'titulo' => 'Inserción producto',
            'breadcrumb' => ['Formulario', 'Ingresar producto']
        ];

        $proveedorModel = new ProveedorModel();
        $data['proveedores'] = $proveedorModel->getAll();
        $categoriaModel = new CategoriaModel();
        $data['categorias'] = $categoriaModel->getAllCategorias();

        $this->view->showViews(
            array('templates/header.view.php', 'productos.form.view.php', 'templates/footer.view.php'),
            $data);
    }

    public function doNewUsuario()
    {
        $data = [
            'titulo' => 'Inserción producto',
            'breadcrumb' => ['Formulario', 'Ingresar producto']
        ];

        $errors = $this->checkForm($_POST);

        if (empty($errors)) {

        } else {
            $data['errors'] = $errors;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->view->showViews(
                array('templates/header.view.php', 'productos.form.view.php', 'templates/footer.view.php'),
                $data);
        }
    }

    private function checkForm($data): array
    {
        $errors = [];

        if (empty($data['codigo'])) {
            $errors['codigo'] = "El codigo es obligatorio";
        } elseif (!preg_match('/^[a-zA-Z]{3}\d{7}$/', $data['codigo'])) {
            $errors['codigo'] = "El código debe estar formado por 3 letras y 7 números sin espacios";
        }

        if (empty($data['nombre'])) {
            $errors['nombre'] = "El nombre es obligatorio";
        } elseif (mb_strlen($data['nombre']) > 255) {
            $errors['nombre'] = "El nombre no puede tener mas 255 caracteres";
        } elseif (!preg_match('/^\w+ - \w+$/', $data['nombre'])) {
            $errors['nombre'] = "El nombre debe estar formado por abc - abc, donde abc pueden ser números o letras";
        }

        return $errors;
    }
}