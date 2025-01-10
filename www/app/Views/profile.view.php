<?php

declare(strict_types=1);
?>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Información de usuario</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="alias">Email:</label>
                            <input type="text" class="form-control" name="alias" id="alias" value="<?php echo $_SESSION['google_email']; ?>" readonly/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Nombre completo:</label>
                            <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" value="<?php echo $_SESSION['google_name']; ?>" readonly/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-12 text-right">
                    <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                    <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                </div>
            </div>

        </div>
    </div>
</div>
