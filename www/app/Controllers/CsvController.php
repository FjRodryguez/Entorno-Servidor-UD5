<?php
declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CSVModel;

class CsvController extends BaseController
{

    private const DATA_FOLDER = '../app/Data/';

    public function showPoblacionPontevedra()
    {
        $_vars = array('titulo' => 'Datos población Pontevedra',
            'breadcumb' => array('Inicio'),
            'seccion' => '/poblacion-pontevedra',
            'csv_div_titulo' => 'Datos del csv',
        );
        $csvModel = new CSVModel(self::DATA_FOLDER . 'poblacion_pontevedra.csv');
        $_vars["data"] = $csvModel->loadData();
        $_vars["poblacionMax"] = $this->poblacionMax($_vars["data"]);
        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $_vars);
    }

    public function showPoblacionGruposEdad(): void
    {
        $data = [
            'titulo' => 'Población Grupos Edad',
            'breadcrumb' => ['Csv', 'Población Grupos Edad'],
            'seccion' => '/poblacion-grupos-edad',
            'csv_div_titulo' => 'Datos del csv'
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_grupos_edad.csv');
        $data['data'] = $model->loadData();

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    public function showPoblacionPontevedra2020(): void
    {
        $data = [
            'titulo' => 'Población Pontevedra 2020',
            'breadcrumb' => ['Csv', 'Población Pontevedra 2020'],
            'seccion' => '/poblacion-pontevedra-2020',
            'csv_div_titulo' => 'Datos del csv'
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_pontevedra_2020_totales.csv');
        $data['data'] = $model->loadData();

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    public function poblacionMax($data)
    {
        $poblacion = [];
        $max = 0;
        for ($i = 1; $i < count($data); $i++) {
            $int_val = (int) str_replace('.', '', $data[$i][3]);
            if($int_val > $max) {
                $max = $int_val;
                $poblacion = $data[$i];
            }
        }
        $poblacion[1] = $poblacion[2];
        $poblacion[2] = 'MAX';
        return $poblacion;
    }
}