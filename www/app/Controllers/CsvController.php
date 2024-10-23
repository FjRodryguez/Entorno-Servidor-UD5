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
        $data = array('titulo' => 'Datos población Pontevedra',
            'breadcrumb' => ['Csv', 'Población Pontevedra'],
            'csv_div_titulo' => 'Datos del csv'
        );
        $csvModel = new CSVModel(self::DATA_FOLDER . 'poblacion_pontevedra.csv');
        $data["data"] = $csvModel->loadData();
        if (count($data['data']) > 1) {
            $minMax = $this->getMaxMinPob($data['data']);
            $data = array_merge($data, $minMax);
        }
        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    private function getMaxMinPob(array $data): array
    {
        $min = $data[1];
        $max = $data[1];
        $min [3] = $this->cleanPoblacion($min[3]);
        $max [3] = $this->cleanPoblacion($max[3]);
        for ($i = 1; $i < count($data); $i++) {
            $actual = $data[$i];
            if (filter_var($actual[3], FILTER_VALIDATE_INT)) {
                $poblacionActual = $this->cleanPoblacion($actual[3]);
                if ($poblacionActual > $max [3]) {
                    $max = $actual;
                }
                if ($poblacionActual < $min [3]) {
                    $min = $actual;
                }
            }
        }
        $resultado = [];
        $resultado['min'] = $min;
        $resultado['max'] = $max;
        return $resultado;
    }

    private function cleanPoblacion(string $poblacion): int
    {
        return (int)str_replace(".", "", $poblacion);
    }

    public function showPoblacionGruposEdad(): void
    {
        $data = [
            'titulo' => 'Población Grupos Edad',
            'breadcrumb' => ['Csv', 'Población Grupos Edad'],
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
            'csv_div_titulo' => 'Datos del csv'
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_pontevedra_2020_totales.csv');
        $data['data'] = $model->loadData();
        if (count($data['data']) > 1) {
            $minMax = $this->getMaxMinPob($data['data']);
            array_merge($data, $minMax);
        }

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $data);
    }

    public function showFormularioAñadir()
    {
        $data = [
            'titulo' => 'Formulario población Pontevedra',
            'breadcrumb' => ['Formulario', 'Población Pontevedra'],
        ];
        $model = new CsvModel(self::DATA_FOLDER . 'poblacion_pontevedra.csv');
        $data['data'] = $model->loadData();

        $this->view->showViews(array('templates/header.view.php', 'formulario.view.php', 'templates/footer.view.php'), $data);
    }

    public function doFormularioAñadir()
    {
        $data = [
            'titulo' => 'Formulario población Pontevedra',
            'breadcrumb' => ['Formulario', 'Población Pontevedra'],
        ];
        $data['input'] = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $data['errors'] = $this->checkFormularioAñadirErrors($_POST);
        if (empty($data['errors'])) {
            $resource = fopen("poblacion_pontevedra.csv", "a");
            fputcsv($resource, $data['input'], ";");
            fclose($resource);
        }
        $this->view->showViews(array('templates/header.view.php', 'formulario.view.php', 'templates/footer.view.php'), $data);
    }

    private function checkFormularioAñadirErrors(array $data)
    {
        $errors = [];
        if(!empty($data['municipio']) && !empty($data['total'])){
            if(!preg_match('/^36(\d{3})? [A-Za-z]+$/', $data['municipio'])){
                $errors[] = "La sintaxis del municipio no es correcta";
            }
            if($data['total'] < 0 || !is_numeric($data['total'])){
                $errors[] = "El campo total debe ser numérico y superior a 0.";
            }
        }else{
            $errors[] = "Debes rellenar todos los campos";
        }
        return $errors;
    }
}