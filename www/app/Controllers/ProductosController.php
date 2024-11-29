<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProveedorModel;
use Decimal\Decimal;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductosModel;

class ProductosController extends BaseController
{

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
        if(!empty($_GET['codigo'])){
            $filtros['codigo'] = "%".$_GET['codigo']."%";
        }
        if(!empty($_GET['nombre'])){
            $filtros['nombre'] = "%".$_GET['nombre']."%";
        }
        if(!empty($_GET['categoria'])){
            $filtros['categoria'] = $_GET['categoria'];
        }
        if(!empty($_GET['proveedor'])){
            $filtros['proveedor'] = $_GET['proveedor'];
        }
        if(!empty($_GET['stock_min'])){
            $filtros['stock_min'] = new Decimal($_GET['stock_min']);
        }
        if(!empty($_GET['stock_max'])){
            $filtros['stock_max'] = new Decimal($_GET['stock_max']);
        }
        if(!empty($_GET['pvp_min'])){
            $filtros['pvp_min'] = new Decimal($_GET['pvp_min']);
        }
        if(!empty($_GET['pvp_max'])){
            $filtros['pvp_max'] = new Decimal($_GET['pvp_max']);
        }

        $productosModel = new ProductosModel();
        $productos = $productosModel->filtrarProductos($filtros);

        $data['productos'] = $this->calcularPvp($productos);


        $data['input'] = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        $this->view->showViews(
            array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'),
            $data);
    }

    public function calcularPvp(array $productos): array
    {
        foreach ($productos as &$producto) {
            $coste = new Decimal($producto['coste']);
            $margen = new Decimal($producto['margen']);
            $iva = new Decimal($producto['iva']);
            $pvp = $coste * $margen * ((100 + $iva) / new Decimal('100', 2));
            $producto['pvp'] = $pvp->toFixed(2, true, Decimal::ROUND_HALF_UP);
        }
        return $productos;
    }
}