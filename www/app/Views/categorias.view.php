<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <?php
        if (!empty($categorias)) {
            ?>
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-9"><h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6></div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="card_table">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <table id="tabladatos" class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Padre</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($categorias as $categoria) {
                            ?>
                            <tr>
                                <td><?php echo $categoria['id_categoria'] ?></td>
                                <td><?php echo $categoria['nombre_categoria'] ?></td>
                                <td><?php echo $categoria['nombre_completo'] ?></td>
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
                No hay categorias que cumplan los requisitos seleccionados
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!--Fin HTML -->