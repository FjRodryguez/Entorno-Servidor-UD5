<?php

declare(strict_types=1);

?>
<div class="card shadow mb-4">
    <form method="post" action="">
        <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nombre">Nombre<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control"
                               name="nombre" id="nombre"
                               value="<?php
                               echo $input['nombre'] ?? ''; ?>"
                               maxlength="255"
                               placeholder="Nombre de la persona usuaria"
                               required/>
                        <p class="text-danger small">
                            <?php
                            echo $errors['nombre'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="email">Email<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control"
                               name="email" id="email"
                               value="<?php
                               echo $input['email'] ?? ''; ?>"
                               maxlength="255"
                               placeholder="user@email.ext"
                               required/>
                        <p class="text-danger small">
                            <?php
                            echo $errors['email'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="id_rol">Rol<span class="text-danger">*</span>:</label>
                        <select name="id_rol" id="id_rol" class="form-control">
                            <option value="">-</option>
                            <?php foreach ($roles as $role) {
                                ?>
                                <option value="<?php echo $role['id_rol'] ?>" <?php echo (isset($input['id_rol']) && $role['id_rol'] == $input['id_rol']) ? 'selected' : ''; ?>><?php echo ucfirst($role['rol']); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <p class="text-danger small"><?php echo $errors['id_rol'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="idioma">Idioma:</label>
                        <select name="idioma" id="idioma" class="form-control">
                            <option value="">-</option>
                            <?php foreach ($idiomas as $idioma) {
                                ?>
                                <option value="<?php echo $idioma; ?>" <?php echo (isset($input['idioma']) && $idioma == $input['idioma']) ? 'selected' : ''; ?>><?php echo ucfirst($idioma); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <p class="text-danger small"><?php echo $errors['idioma'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="password">Contraseña<span class="text-danger">*</span>:</label>
                        <input type="password" class="form-control"
                               name="password" id="password"
                               value="<?php
                               echo $input['password'] ?? ''; ?>"
                               maxlength="100"
                               placeholder="M1_P4ssw0rD"
                               required/>
                        <p class="text-danger small">
                            <?php
                            echo $errors['password'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="password2">Repetir password<span class="text-danger">*</span>:</label>
                        <input type="password" class="form-control"
                               name="password2" id="password2"
                               value="<?php
                               echo $input['password2'] ?? ''; ?>"
                               maxlength="100"
                               placeholder="M1_P4ssw0rD"
                               required/>
                        <p class="text-danger small">
                            <?php
                            echo $errors['password2'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-check">
                        <input
                                type="checkbox"
                                class="form-check-input"
                                id="baja"
                                name="baja"
                            <?php echo !empty($input['baja']) ? 'checked' : ''; ?>
                        />
                        <label class="form-check-label" for="baja">Dar de baja</label>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <a href="<?php echo $_ENV['host.folder'] . 'usuarios-filtro'; ?>" class="btn btn-danger">Cancelar</a>
                <input type="submit" value="Guardar cambios" class="btn btn-primary ml-2"/>
            </div>
        </div>
    </form>
</div>
