<h2 class="text-uppercase text-center">
    Reporte de cotizaciones
</h2>

<div class="card">
    <div class="card-body">

        <?php if ($_POST) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <form method="POST" action="?url=cotizaciones/exportar">

            <h5>Reporte</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tipo</label>
                    <select name="tipo_reporte" class="form-control">
                        <option value="emisiones" selected>Emisiones</option>
                        <option value="cotizaciones">Cotizaciones</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tipo de Cotización</label>
                    <select name="tipo_cotizacion" class="form-control">
                        <option value="Auto" selected>Auto</option>
                    </select>
                </div>
            </div>

            <br>

            <h5>Aseguradora</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nombre</label>
                    <select name="contrato_id" class="form-control" required>
                        <option value="" selected disabled>Selecciona una Aseguradora</option>
                        <?php
                        foreach ($contratos as $id => $nombre_aseguradora) {
                            echo '<option value="' . $id . '">' . $nombre_aseguradora . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <br>

            <h5>Fecha</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Desde</label>
                    <input type="date" class="form-control" name="desde" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Hasta</label>
                    <input type="date" class="form-control" name="hasta" required>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                    |
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                </div>
            </div>

        </form>
    </div>
</div>