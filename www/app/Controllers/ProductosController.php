<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProveedorModel;
use Com\Daw2\Models\UsuarioModel;
use Decimal\Decimal;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductosModel;
use http\Encoding\Stream\Debrotli;

class ProductosController extends BaseController
{
    public const ORDER_DEFECTO = 1;

    public function productos()
    {
        $data = [
            'titulo' => 'Productos',
            'breadcrumb' => ['Listado', 'Productos']
        ];

        if (isset($_SESSION['flash']['message'])) {
            $data['message'] = $_SESSION['flash']['message'];
            $data['message_type'] = $_SESSION['flash']['message_type'] ?? 'info';
            unset($_SESSION['flash']);
        }

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

        $_copiaGET = $_GET;
        unset($_copiaGET['page']);
        $data['queryStringNoPage'] = http_build_query($_copiaGET);
        if (!empty($data['queryStringNoPage'])) {
            $data['queryStringNoPage'] .= '&';
        }

        unset($_copiaGET['order']);
        $data['queryString'] = http_build_query($_copiaGET);
        if (!empty($data['queryString'])) {
            $data['queryString'] .= '&';
        }

        $productosModel = new ProductosModel();
        $registros = $productosModel->countProductos($filtros);
        $page = isset($_GET['page']) && filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?
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

    public function showNewProducto($input = [], $errors = [])
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Inserción producto',
            'breadcrumb' => ['Formulario', 'Ingresar producto']
        ];

        $data['input'] = $input;
        $data['errors'] = $errors;
        $this->view->showViews(
            array('templates/header.view.php', 'productos.form.view.php', 'templates/footer.view.php'),
            $data);
    }

    public function doNewProducto()
    {
        $errors = $this->checkForm($_POST);

        if (empty($errors)) {
            $insertData = $_POST;
            foreach ($insertData as $key => $value) {
                if ($value === '') {
                    $insertData[$key] = null;
                }
            }
            $productoModel = new ProductosModel();
            if ($productoModel->addProducto($insertData)) {
                $mensaje = new Mensaje('Producto creado correctamente', Mensaje::SUCCESS, 'Éxito');
                $this->addFlashMessage($mensaje);
                header('Location: /productos');
            } else {
                $mensaje = new Mensaje('No se ha podido crear el producto', Mensaje::SUCCESS, 'Éxito');
                $this->addFlashMessage($mensaje);
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showNewProducto($input, $errors);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showNewProducto($input, $errors);
        }
    }

    public function showEditProducto(string $producto, array $input = [], array $errors = [])
    {
        $productoModel = new ProductosModel();
        $productoData = $productoModel->findByCodigo($producto);
        echo $producto;
        if (is_null($productoData)) {
            header('Location: /productos');
        }
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Editar producto',
            'breadcrumb' => ['Formulario', 'Editar producto'],
        ];

        $data['input'] = ($input === []) ? $productoData : $input;

        $data['errors'] = $errors;

        $this->view->showViews(
            array('templates/header.view.php', 'productos.form.view.php', 'templates/footer.view.php'),
            $data);
    }

    public function doEditProducto(string $producto)
    {
        $productoModel = new ProductosModel();
        $productoData = $productoModel->findByCodigo($producto);
        if (is_null($productoData)) {
            header('Location: /productos');
        }
        $errors = $this->checkForm($_POST, $producto);
        if (empty($errors)) {
            $insertData = $_POST;
            foreach ($insertData as $key => $value) {
                if ($value === '') {
                    $insertData[$key] = null;
                }
                if ($productoModel->editProducto($insertData, $producto)) {
                    $mensaje = new Mensaje('Producto modificado correctamente', Mensaje::SUCCESS, 'Éxito');
                    $this->addFlashMessage($mensaje);
                    header('Location: /productos');
                } else {
                    $mensaje = new Mensaje('No se ha podido modificar el producto', Mensaje::SUCCESS, 'Éxito');
                    $this->addFlashMessage($mensaje);
                    $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $this->showEditProducto($producto, $input, $errors);
                }
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showEditProducto($producto, $input, $errors);
        }
    }

    public function doDeleteProducto($producto)
    {
        $productoModel = new ProductosModel();
        if ($productoModel->deleteProducto($producto)) {
            $mensaje = new Mensaje('Producto eliminado correctamente', Mensaje::SUCCESS, 'Éxito');
        } else {
            $mensaje = new Mensaje('No se ha podido eliminar el producto', Mensaje::ERROR, 'Error');
        }
        $this->addFlashMessage($mensaje);
        header('Location: /productos');
    }

    private function checkForm($data, $oldCodigo = ''): array
    {
        $errors = [];

        if ($oldCodigo === '' || $oldCodigo != $data['codigo']) {
            if (empty($data['codigo'])) {
                $errors['codigo'] = "El codigo es obligatorio";
            } elseif (!preg_match('/^[a-zA-Z]{3}\d{7}$/', $data['codigo'])) {
                $errors['codigo'] = "El código debe estar formado por 3 letras y 7 números sin espacios";
            }
            $productoModel = new ProductosModel();
            if (!is_null($productoModel->findByCodigo($data['codigo']))) {
                $errors['codigo'] = "El codigo ya existe";
            }
        }

        if (empty($data['nombre'])) {
            $errors['nombre'] = "El nombre es obligatorio";
        } elseif (mb_strlen($data['nombre']) > 255) {
            $errors['nombre'] = "El nombre no puede tener mas 255 caracteres";
        } elseif (!preg_match('/^\w+ - \w+$/', $data['nombre'])) {
            $errors['nombre'] = "El nombre debe estar formado por abc - abc, donde abc pueden ser números o letras";
        }

        if (empty($data['descripcion'])) {
            $errors['descripcion'] = "La descripcion es obligatoria";
        } elseif (mb_strlen($data['descripcion']) > 255) {
            $errors['descripcion'] = "La descripcion no puede tener mas 255 caracteres";
        }

        if (isset($data['id_categoria']) && filter_var($data['id_categoria'], FILTER_VALIDATE_INT) === false) {
            $errors['id_categoria'] = "La categoría no es válida";
        } else {
            $categoriaModel = new CategoriaModel();
            $categoria = $categoriaModel->getCategoria((int)$data['id_categoria']);
            if (is_null($categoria)) {
                $errors['id_categoria'] = "La categoria no es válida";
            }
        }

        if (empty($data['proveedor'])) {
            $errors['proveedor'] = "El proveedor es obligatorio";
        } elseif (!preg_match('/^[A-Z][0-9]{7}[A-Z]$/', $data['proveedor'])) {
            $errors['proveedor'] = "Proveedor no válido";
        } else {
            $proveedorModel = new ProveedorModel();
            $proveedor = $proveedorModel->findByCif($data['proveedor']);
            if (is_null($proveedor)) {
                $errors['proveedor'] = "El proveedor no es válido";
            }
        }

        if (empty($data['coste'])) {
            $errors['coste'] = "El coste es obligatorio";
        } elseif (filter_var($data['coste'], FILTER_VALIDATE_INT) === false) {
            $errors['coste'] = "El coste no es válido";
        }

        if (empty($data['margen'])) {
            $errors['margen'] = "El margen es obligatorio";
        } elseif (filter_var($data['margen'], FILTER_VALIDATE_INT) === false) {
            $errors ['margen'] = "El margen debe ser un número entero";
        }

        if ($data['stock'] === '') {
            $errors['stock'] = "El stock es obligatorio";
        } elseif (filter_var($data['stock'], FILTER_VALIDATE_INT) === false) {
            $errors['stock'] = "El stock debe ser un número entero";
        }

        if (empty($data['iva'])) {
            $errors['iva'] = "El iva es obligatorio";
        } elseif (filter_var($data['iva'], FILTER_VALIDATE_INT) === false) {
            $errors['iva'] = "El iva debe ser un número entero";
        } elseif ($data['iva'] > 100) {
            $errors['iva'] = "El iva no puede ser mayor a 100";
        }
        return $errors;
    }

    private function getCommonData(): array
    {
        $proveedorModel = new ProveedorModel();
        $data['proveedores'] = $proveedorModel->getAll();
        $categoriaModel = new CategoriaModel();
        $data['categorias'] = $categoriaModel->getAllCategorias();
        return $data;
    }
}