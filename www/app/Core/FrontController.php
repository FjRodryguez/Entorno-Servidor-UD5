<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\EjerciciosController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        Route::add(
            '/',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/test',
            function () {
                $controlador = new EjerciciosController();
                $controlador->showFormularioNombre();
            },
            'get'
        );

        Route::add(
            '/test',
            function () {
                $controlador = new EjerciciosController();
                $controlador->doFormularioNombre();
            },
            'post'
        );

        Route::add(
            '/anagrama',
            function () {
                $controlador = new EjerciciosController();
                $controlador->showAnagrama();
            },
            'get'
        );

        Route::add(
            '/anagrama',
            function () {
                $controlador = new EjerciciosController();
                $controlador->doAnagrama();
            },
            'post'
        );

        Route::add(
            '/mismas-letras',
            function () {
                $controlador = new EjerciciosController();
                $controlador->showMismasLetras();
            },
            'get'
        );

        Route::add(
            '/mismas-letras',
            function () {
                $controlador = new EjerciciosController();
                $controlador->doMismasLetras();
            },
            'post'
        );

        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->demo();
            },
            'get'
        );

        Route::add(
            '/poblacion-pontevedra',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showPoblacionPontevedra();
            },
            'get'
        );

        Route::add(
            '/poblacion-grupos-edad',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showPoblacionGruposEdad();
            },
            'get'
        );

        Route::add(
            '/poblacion-pontevedra-2020',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showPoblacionPontevedra2020();
            },
            'get'
        );

        Route::add(
            '/formulario-poblacion-pontevedra',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showFormularioAñadir();
            },
            'get'
        );

        Route::add(
            '/formulario-poblacion-pontevedra',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->doFormularioAñadir();
            },
            'post'
        );

        Route::pathNotFound(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );

        Route::methodNotAllowed(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        Route::run();
    }
}
