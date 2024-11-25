<?php

declare(strict_types=1);
?>
<div class="card shadow mb-4">
    <form method="post" action="">
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Cambiar tema</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dark_mode" name="dark_mode" <?php echo isset($_COOKIE['dark_mode']) && $_COOKIE['dark_mode'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="dark_mode">Usar tema oscuro</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <input type="submit" value="Guardar cambios" class="btn btn-primary ml-2"/>
            </div>
        </div>
    </form>
</div>