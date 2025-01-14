<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CategoriaController;
use Com\Daw2\Controllers\PreferenciasController;
use Com\Daw2\Controllers\ProductosController;
use Com\Daw2\Controllers\ProveedorController;
use Com\Daw2\Controllers\UsuarioSistemaController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            Route::add(
                '/login',
                function () {
                    $controller = new UsuarioSistemaController();
                    $controller->showLogin();
                },
                'get'
            );
            Route::add(
                '/login',
                function () {
                    $controller = new UsuarioSistemaController();
                    $controller->doLogin();
                },
                'post'
            );
            Route::add(
                '/login-with-google',
                function () {
                    $controller = new UsuarioSistemaController();
                    $controller->doGoogleLogin();
                },
                'get'
            );
            Route::add(
                '/register',
                function () {
                    $controller = new UsuarioSistemaController();
                    $controller->showRegister();
                },
                'get'
            );
            Route::add(
                '/register',
                function () {
                    $controller = new UsuarioSistemaController();
                    $controller->doRegister();
                },
                'post'
            );
            Route::add(
                '/register-with-google',
                function () {
                    $controller = new UsuarioSistemaController();
                    $controller->doGoogleRegister();
                },
                'get'
            );

            Route::pathNotFound(
                function () {
                    header('Location: /login');
                }
            );

        } else {
            Route::add(
                '/logout',
                function () {
                    session_destroy();
                    header('Location: ' . $_ENV['base.url']);
                },
                'get'
            );

            if ($_SESSION['permisos']['usuarios']->isRead()) {
                Route::add(
                    '/usuarios-filtro',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->usuariosFiltro();
                    },
                    'get'
                );
            }
            if ($_SESSION['permisos']['usuarios-sistema']->isRead()) {
                Route::add(
                    '/usuarios-sistema',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->index();
                    },
                    'get'
                );
            }
            if ($_SESSION['permisos']['usuarios-sistema']->isWrite()) {
                Route::add(
                    '/usuarios-sistema/new',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->showNewUsuarioSistema();
                    },
                    'get'
                );

                Route::add(
                    '/usuarios-sistema/new',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->doNewUsuario();
                    },
                    'post'
                );
                Route::add(
                    '/usuarios-sistema/edit/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->showEdit((int)$id);
                    },
                    'get'
                );

                Route::add(
                    '/usuarios-sistema/edit/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->doEdit((int)$id);
                    },
                    'post'
                );
            }
            if ($_SESSION['permisos']['usuarios-sistema']->isDelete()) {
                Route::add(
                    '/usuarios-sistema/delete/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->deleteUsuario((int)$id);
                    },
                    'get'
                );
            }
            if ($_SESSION['permisos']['usuarios']->isWrite()) {
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
            }
            if ($_SESSION['permisos']['usuarios']->isDelete()) {
                Route::add(
                    '/usuarios/delete/(\p{L}[\p{L}_\p{N}]{2,49})',
                    function ($usuario) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->deleteUsuario($usuario);
                    },
                    'get'
                );
            }
            if ($_SESSION['permisos']['csv']->isRead()) {
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
            }
            if ($_SESSION['permisos']['csv']->isWrite()) {
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
            }

            if (isset($_SESSION['permisos']['categorias'])) {
                Route::add(
                    '/categorias',
                    function () {
                        $controlador = new CategoriaController();
                        $controlador->categorias();
                    },
                    'get'
                );
            }
            if (isset($_SESSION['permisos']['productos'])) {
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
            }
            if (isset($_SESSION['permisos']['proveedores'])) {
                Route::add(
                    '/proveedores',
                    function () {
                        $controlador = new ProveedorController();
                        $controlador->proveedores();
                    },
                    'get'
                );
            }
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
                '/',
                function () {
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->index();
                },
                'get'
            );
            if (isset($_SESSION['permisos']['demo-proveedores'])) {
                Route::add(
                    '/demo-proveedores',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->demo();
                    },
                    'get'
                );
            }
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
        }
        Route::run();
    }
}
