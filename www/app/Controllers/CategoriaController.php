<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
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
}