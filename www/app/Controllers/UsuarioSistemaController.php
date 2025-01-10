<?php
declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\GoogleOAuth;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Libraries\RemoteImageDownloader;
use Com\Daw2\Models\RolModel;
use Com\Daw2\Models\UsuarioSistemaModel;

class UsuarioSistemaController extends BaseController
{
    const IDIOMAS = ['es', 'en'];

    public const ROL_PUBLIC = 3;

    public function index(): void
    {
        $data = [
            'titulo' => 'Listado usuarios sistema',
            'breadcrumb' => ['Usuarios', 'Listado usuarios sistema']
        ];

        $model = new UsuarioSistemaModel();
        $data['usuarios'] = $model->getAll();
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function showProfile(): void
    {
        $this->view->showViews(
            array(
                'templates/header.view.php',
                'profile.view.php',
                'templates/footer.view.php')
        );
    }

    public function showRegister()
    {
        $this->view->show('register.view.php');
    }

    public function showLogin()
    {
        $this->view->show('login.view.php');
    }

    public function doRegister()
    {
        $errors = $this->checkErrors($_POST, true);
        if ($errors === []) {
            $model = new UsuarioSistemaModel();
            $ok = $model->insertUsuarioSistema(
                [
                    'nombre' => $_POST['nombre'],
                    'email' => $_POST['email'],
                    'pass' => $_POST['password'],
                    'id_rol' => self::ROL_PUBLIC,
                    'idioma' => self::IDIOMAS[0],
                    'baja' => 0
                ]
            );
            if ($ok) {
                $this->addFlashMessage(new Mensaje('Usuario registrado correctamente', Mensaje::SUCCESS, 'Éxito'));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha podido insertar al usuario', Mensaje::ERROR, 'Error'));
            }
            header('Location: /login');
        } else {
            $input = filter_input_array(INPUT_POST);
            $this->view->show('register.view.php', compact('errors', 'input'));
        }
    }

    public function showNewUsuarioSistema(array $input = [], array $errors = []): void
    {
        $data = [
            'titulo' => 'Alta usuario del sistema',
            'breadcrumb' => ['Usuarios', 'Usuarios sistema', 'Alta usuarios sistema'],
            'input' => $input,
            'errors' => $errors
        ];
        $rolModel = new RolModel();
        $data['roles'] = $rolModel->getAll();
        $data['idiomas'] = self::IDIOMAS;
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios-sistema.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function doNewUsuario(): void
    {
        $errors = $this->checkErrors($_POST);
        if ($errors === []) {
            $model = new UsuarioSistemaModel();
            $ok = $model->insertUsuarioSistema(
                [
                    'nombre' => $_POST['nombre'],
                    'email' => $_POST['email'],
                    'pass' => $_POST['password'],
                    'id_rol' => $_POST['id_rol'],
                    'idioma' => $_POST['idioma'],
                    'baja' => (isset($_POST['baja']) ? 1 : 0)
                ]
            );
            if ($ok) {
                $this->addFlashMessage(new Mensaje('Usuario registrado correctamente', Mensaje::SUCCESS, 'Éxito'));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha podido insertar al usuario', Mensaje::ERROR, 'Error'));
            }
            header('Location: ' . $_ENV['host.folder'] . 'usuarios-sistema');
        } else {
            $input = filter_input_array(INPUT_POST);
            $this->showNewUsuarioSistema($input, $errors);
        }
    }

    public function showEdit(int $idUsuarioSistema): void
    {
        $model = new UsuarioSistemaModel();
        $row = $model->find($idUsuarioSistema);
        if (is_null($row)) {
            $this->addFlashMessage(new Mensaje('Usuario no disponible', Mensaje::ERROR, 'Error'));
            header('Location: ' . $_ENV['host.folder'] . 'usuarios-sistema');
        } else {
            $this->editView($row, []);
        }
    }

    private function editView(array $input, array $errors): void
    {
        $data = [
            'titulo' => 'Editar usuario del sistema',
            'breadcrumb' => ['Usuarios', 'Usuarios sistema', 'Editar usuarios sistema'],
            'input' => $input,
            'errors' => $errors
        ];
        $rolModel = new RolModel();
        $data['roles'] = $rolModel->getAll();
        $data['idiomas'] = self::IDIOMAS;
        $this->view->showViews(
            array('templates/header.view.php', 'usuarios-sistema.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function doEdit(int $idUsuarioSistema): void
    {
        $model = new UsuarioSistemaModel();
        $row = $model->find($idUsuarioSistema);
        if (is_null($row)) {
            $this->addFlashMessage(new Mensaje('Usuario no disponible', Mensaje::ERROR, 'Error'));
            header('Location: ' . $_ENV['host.folder'] . 'usuarios-sistema');
        } else {
            $errors = $this->checkErrors($_POST, oldEmail: $row['email']);
            if ($errors === []) {
                $_POST['baja'] = isset($_POST['baja']) ? 1 : 0;
                unset($_POST['password2']);
                $ok = $model->editUsuario($idUsuarioSistema, $_POST);
                if ($ok) {
                    $this->addFlashMessage(new Mensaje('Usuario editado correctamente', Mensaje::SUCCESS, 'Éxito'));
                } else {
                    $this->addFlashMessage(new Mensaje('No se ha podido editar al usuario', Mensaje::ERROR, 'Error'));
                }
                header('Location: ' . $_ENV['host.folder'] . 'usuarios-sistema');
            } else {
                $input = filter_input_array(INPUT_POST);
                $this->editView($input, $errors);
            }
        }
    }

    private function checkErrors(array $data, bool $fromPublic = false, string $oldEmail = ''): array
    {
        $errors = [];
        if (!preg_match('/^\p{L}[ \p{L}]{2,253}\p{L}/iu', $data['nombre'])) {
            $errors['nombre'] = 'El nombre debe empezar y finalizar por una letra y estar formado por letras y espacios. Longitud máxima: 255';
        }

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Inserte un email válido';
        } else {
            if ($data['email'] !== $oldEmail) {
                $usuarioSistemaModel = new UsuarioSistemaModel();
                $row = $usuarioSistemaModel->getByEmail($data['email']);
                if (!is_null($row)) {
                    $errors['email'] = 'El email seleccionado ya existe en el sistema';
                }
            }
        }
        /*
        * El password debe contener:
        * * Una letra mayúscula
        * * Una letra minúscula
        * * Un número
        * * Longitud mínima: 8
        */
        if (!preg_match('/^(?=.*\p{Ll})(?=.*\p{Lu})(?=.*\d).{8,}$/u', $data['password'])) {
            $errors['password'] = 'El password debe tener una longitud mínima de 8 y contener una mayúscula, una minúscula y un número';
        }

        if ($data['password'] !== $data['password2']) {
            $errors['password'] = 'Los passwords no coinciden';
        }

        if (!$fromPublic && !in_array($data['idioma'], self::IDIOMAS)) {
            $errors['idioma'] = 'Idioma no válido';
        }

        $rolModel = new RolModel();
        if (!$fromPublic && is_null($rolModel->find((int)$data['id_rol']))) {
            $errors['id_rol'] = 'El rol seleccionado no es válido';
        }

        if ($fromPublic && !isset($data['terms'])) {
            $errors['terms'] = 'Debe aceptar los términos y condiciones';
        }

        return $errors;
    }

    public function doLogin(): void
    {
        $data = [];
        $model = new UsuarioSistemaModel();
        $usuario = $model->login($_POST['email'], $_POST['password']);
        if (is_null($usuario)) {
            $data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['error'] = true;
            $this->view->show('login.view.php', $data);
        } else {
            $this->startSession($usuario, 'local');
        }
    }

    public function deleteUsuario(int $id): void
    {
        if (isset($_SESSION['usuario']['id_usuario']) && (int)$_SESSION['usuario']['id_usuario'] === $id) {
            $this->addFlashMessage(new Mensaje('No puede borrarse a si mismo', Mensaje::WARNING));
        } else {
            $model = new UsuarioSistemaModel();
            if ($model->deleteUsuario($id)) {
                $this->addFlashMessage(new Mensaje('Usuario eliminado con éxito', Mensaje::SUCCESS));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha borrado al usuario', Mensaje::WARNING));
            }
        }
        header('Location: ' . $_ENV['host.folder'] . 'usuarios-sistema');
    }

    public function getPermission(int $rol): array
    {
        $permisos = [];
        if ($rol == 1) {
            $permisos['demo-proveedores'] = 'rwd';
            $permisos['csv'] = 'rwd';
            $permisos['usuarios'] = 'rwd';
            $permisos['productos'] = 'rwd';
            $permisos['categorias'] = 'rwd';
            $permisos['proveedores'] = 'rwd';
            $permisos['usuarios-sistema'] = 'rwd';
        }
        if ($rol == 2) {
            $permisos['csv'] = 'rw';
            $permisos['usuarios'] = 'rw';
            $permisos['productos'] = 'rw';
            $permisos['categorias'] = 'rw';
            $permisos['proveedores'] = 'rw';
        }
        if ($rol == 3) {
            $permisos['csv'] = 'r';
            $permisos['usuarios'] = 'r';
            $permisos['productos'] = 'r';
        }
        return $permisos;
    }

    public function doGoogleLogin()
    {
        try {
            $userInfo = GoogleOAuth::getInstance($_ENV['base.url'] . '/login-with-google')->getUserInfo();
            $usuarioModel = new UsuarioSistemaModel();
            $usuario = $usuarioModel->getByEmail($userInfo->email);
            if (is_null($usuario)) {
                $this->addFlashMessage(
                    new Mensaje(
                        'Es necesario registrarse primero para poder acceder al sistema.',
                        Mensaje::WARNING,
                        'Regístrese'
                    )
                );
                header('Location: ' . $_ENV['host.folder'] . 'register');
            } else {
                $this->startSession($usuario, 'google');
            }
        } catch (\OAuthException $ex) {
            $this->addFlashMessage(
                new Mensaje(
                    'No se ha podido hacer el login. ' . $ex->getMessage(),
                    Mensaje::WARNING,
                    'Inténtelo de nuevo'
                )
            );
            header('Location: ' . $_ENV['host.folder'] . 'login');
        }
    }

    private function startSession(array $usuario, string $method)
    {
        unset($usuario['password']);
        session_regenerate_id();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['permisos'] = $this->getPermission((int)$usuario['id_rol']);
        $_SESSION['usuario']['methodLogin'] = $method;
        $model = new UsuarioSistemaModel();
        $model->setLastDate((int)$usuario['id_usuario']);
        header('Location: ' . $_ENV['base.url']);
    }

    public function doGoogleRegister()
    {
        $userInfo = GoogleOAuth::getInstance($_ENV['base.url'] . '/register-with-google')->getUserInfo();
        $model = new UsuarioSistemaModel();
        $user = $model->getByEmail($userInfo->email);
        if (is_null($user)) {
            $ok = $model->insertUsuarioSistema(
                [
                    'nombre' => $userInfo->name,
                    'email' => $userInfo->email,
                    'pass' => $pwd = bin2hex(openssl_random_pseudo_bytes(8)),
                    'id_rol' => self::ROL_PUBLIC,
                    'idioma' => self::IDIOMAS[0],
                    'baja' => 0
                ]
            );
            if ($ok !== false) {
                $imageDownloader = new RemoteImageDownloader();
                $imageDownloader->downloadFromUri($userInfo->picture, $model->expectedUserImage($ok));
                $this->addFlashMessage(new Mensaje('Usuario registrado correctamente', Mensaje::SUCCESS, 'Éxito'));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha podido insertar al usuario', Mensaje::ERROR, 'Error'));
            }
            header('Location: ' . $_ENV['host.folder'] . 'login');
        } else {
            $this->addFlashMessage(new Mensaje('El usuario ya existe en el sistema.', Mensaje::WARNING, 'No es necesario registro'));
            header('Location: ' . $_ENV['host.folder'] . 'login');
        }
    }
}
