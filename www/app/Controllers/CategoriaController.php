<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\CategoriaModel;

class CategoriaController extends BaseController
{

    function categorias()
    {
        $data = [
            'titulo' => 'Categorias',
            'breadcrumbs' => ['Listado', 'Categorias']
        ];

        $model = new CategoriaModel();
        $categorias = $model->getAllCategorias();

        $data['categorias'] = $categorias;
        $this->view->showViews(
            array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function listadoAPI(): void
    {
        try {
            $model = new CategoriaModel();
            $data = $model->get(['nombre_categoria' => $_GET['nombre_categoria'] ?? '']);
            $respuesta = new Respuesta(200, $data);
        } catch (\Exception $e) {
            $respuesta = new Respuesta(500);
        } finally {
            $this->view->show('json.view.php', ['respuesta' => $respuesta]);
        }
    }
}