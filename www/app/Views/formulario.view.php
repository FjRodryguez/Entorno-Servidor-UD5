<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <label for="municipio">Municipio</label>
                    <input type="text" name="municipio">
                    <label for="sexo">Sexo</label>
                    <select name="sexo">
                        <option value="Total">Total</option>
                        <option value="Hombres">Hombres</option>
                        <option value="Mujeres">Mujeres</option>
                    </select>
                    <label for="total">Total</label>
                    <input type="number" name="total" min="0">
                    <input type="submit" value="Registrar">
                </form>
                <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                        echo $error;
                    }
                } ?>
            </div>
        </div>
    </div>
</div>
<!--<script src="./vendor/jquery/jquery.min.js"></script>-->