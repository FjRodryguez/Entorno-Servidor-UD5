<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo $_ENV['host.folder']; ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DWES | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>DWES</b>UD6</a>
    </div>
    <?php
    include $_ENV['folder.views'] . '/templates/flash-messages.php';
    ?>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Registro de usuario</p>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" value="<?php echo $input['nombre'] ?? ''; ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <p class="small text-danger"><?php echo $errors['nombre'] ?? ''; ?></p>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="my_mail@mail.org" value="<?php echo $input['email'] ?? ''; ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <p class="small text-danger"><?php echo $errors['email'] ?? ''; ?></p>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <p class="small text-danger"><?php echo $errors['password'] ?? '';?></p>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password2" placeholder="Reescribir password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <p class="small text-danger"><?php echo $errors['password2'] ?? ''; ?></p>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                Aceptar términos
                            </label>
                        </div>
                        <p class="small text-danger"><?php echo $errors['terms'] ?? ''; ?></p>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="<?php echo $_ENV['host.folder'];?>register-with-google" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i>
                    Registrarse con Google
                </a>
            </div>

            <a href="<?php echo $_ENV['host.folder'];?>login" class="text-center">Ya tengo una cuenta</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

