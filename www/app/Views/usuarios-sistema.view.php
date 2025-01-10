<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <?php
        if (!empty($usuarios)) {
            ?>
            <div class="card shadow mb-4">
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-6">
                        <h6 class="m-0 install font-weight-bold text-primary">
                            Usuarios</h6>
                    </div>
                    <div class="col-6">
                        <div class="m-0 font-weight-bold justify-content-end">
                            <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/new'; ?>"
                               class="btn btn-primary ml-1 float-right"> Nuevo
                                Usuario Sistema <i class="fas fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="card_table">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <table id="tabladatos" class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th>Nombre usuario</th>
                            <th>Email</th>
                            <th>Último acceso</th>
                            <th>Idioma</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($usuarios as $usuario) {
                            ?>
                            <tr class="<?php echo $usuario['baja'] ? 'table-danger' : ''; ?>">
                                <td><?php echo $usuario['nombre'] ?? '-'; ?></td>
                                <td><?php echo $usuario['email'] ?? '-'; ?></td>
                                <td><?php echo !empty($usuario['last_date']) ? (DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $usuario['last_date']))->format('d/m/Y H:i:s') : '-'; ?></td>
                                <td><?php echo $usuario['idioma'] ?? '-'; ?></td>
                                <td>
                                    <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/edit/' . $usuario['id_usuario']; ?>"
                                       class="btn btn-success ml-1" data-toggle="tooltip" data-placement="top"
                                       title="Editar usuario sitema"><i class="fas fa-edit"></i></a>
                                    <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/delete/' . $usuario['id_usuario']; ?>"
                                       class="btn btn-danger ml-1" data-toggle="tooltip" data-placement="top"
                                       title="Borrar usuario"
                                       onclick="return confirm('¿Desea borrar al usuario?') == true"><i
                                                class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                No hay usuarios que cumplan los requisitos seleccionados
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!--Fin HTML -->