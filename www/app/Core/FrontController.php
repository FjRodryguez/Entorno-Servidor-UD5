<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CategoriaController;
use Com\Daw2\Controllers\EjerciciosController;
use Com\Daw2\Controllers\PreferenciasController;
use Com\Daw2\Controllers\ProductosController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        session_start();
        Route::add(
            '/usuarios-filtro',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->usuariosFiltro();
            },
            'get'
        );

        Route::add(
            '/usuarios',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->getAllUsuarios();
            },
            'get'
        );

        Route::add(
            '/usuarios-order-by-salar',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->getAllUsuariosOrderBySalar();
            },
            'get'
        );

        Route::add(
            '/usuarios-estandar',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->getUsuariosStandard();
            },
            'get'
        );

        Route::add(
            '/usuarios-carlos',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->getUsuariosCarlos();
            },
            'get'
        );

        Route::add(
            '/usuarios/new',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->showNewUsuario();
            },
            'get'
        );
        Route::add(
            '/usuarios/new',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->doNewUsuario();
            },
            'post'
        );
        Route::add(
            '/usuarios/edit/(\p{L}[\p{L}_\p{N}]{2,49})',
            function ($usuario) {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->showEditUsuario($usuario);
            },
            'get'
        );
        Route::add(
            '/usuarios/edit/(\p{L}[\p{L}_\p{N}]{2,49})',
            function ($usuario) {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->doEditUsuario($usuario);
            },
            'post'
        );
        Route::add(
            '/usuarios/delete/(\p{L}[\p{L}_\p{N}]{2,49})',
            function ($usuario) {
                $controlador = new \Com\Daw2\Controllers\UsuarioController();
                $controlador->deleteUsuario($usuario);
            },
            'get'
        );

        Route::add(
            '/preferencias',
            function () {
                $controlador = new PreferenciasController();
                $controlador->showPreferencias();
            },
            'get'
        );

        Route::add(
            '/preferencias',
            function () {
                $controlador = new PreferenciasController();
                $controlador->doPreferencias();
            },
            'post'
        );

        Route::add(
            '/categorias',
            function () {
                $controlador = new CategoriaController();
                $controlador->categorias();
            },
            'get'
        );

        Route::add(
            '/productos',
            function () {
                $controlador = new ProductosController();
                $controlador->productos();
            },
            'get'
        );

        Route::add(
            '/productos/new',
            function () {
                $controlador = new ProductosController();
                $controlador->showNewProducto();
            },
            'get'
        );

        Route::add(
            '/productos/new',
            function () {
                $controlador = new ProductosController();
                $controlador->doNewProducto();
            },
            'post'
        );

        Route::add(
            '/productos/edit/([a-zA-Z]{3}\d{7})',
            function ($producto) {
                $controlador = new ProductosController();
                $controlador->showEditProducto($producto);
            },
            'get'
        );

        Route::add(
            '/productos/edit/([a-zA-Z]{3}\d{7})',
            function ($producto) {
                $controlador = new ProductosController();
                $controlador->doEditProducto($producto);
            },
            'post'
        );

        Route::add(
            '/productos/delete/([a-zA-Z]{3}\d{7})',
            function ($producto) {
                $controlador = new ProductosController();
                $controlador->doDeleteProducto($producto);
            },
            'get'
        );

        Route::add(
            '/',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->index();
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
            '/poblacion-pontevedra/new',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->showAltaPoblacionPontevedra();
            },
            'get'
        );
        Route::add(
            '/poblacion-pontevedra/new',
            function () {
                $controlador = new \Com\Daw2\Controllers\CsvController();
                $controlador->doAltaPoblacionPontevedra();
            },
            'post'
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
            '/demo-proveedores',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->demo();
            },
            'get'
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
