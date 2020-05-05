<form enctype="multipart/form-data" method="POST" action="<?= constant('url') ?>reportes/index">


    <?php if (isset($_POST['submit'])) : ?>
        <div class="alert alert-primary" role="alert">
            <?= $alerta ?>
        </div>
    <?php endif ?>


    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tipo de reporte</label>
                <div class="col-sm-4">
                    <select name="reporte_tipo" class="form-control" required>
                        <option value="polizas" selected>Pólizas emitidas</option>
                        <option value="comisiones">Comisiones</option>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Tipo de Póliza</label>
                <div class="col-sm-4">
                    <select name="tipo" class="form-control" required>
                        <option value="Auto" selected>Auto</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Aseguradora</label>
                <div class="col-sm-4">
                    <select name="contrato_id" class="form-control" required>
                        <?php foreach ($contratos as $contrato) : ?>
                            <option value="<?= $contrato->getEntityId() ?>"><?= $contrato->getFieldValue("Aseguradora")->getLookupLabel() ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fecha de inicio</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="inicio" required>
                </div>
                <label class="col-sm-2 col-form-label">Fecha de fin</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="fin" required>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-md-7">
            &nbsp;
        </div>

        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header">Opciones</h5>
                <div class="card-body">
                    <button type="submit" name="excel" class="btn btn-success">Exportar a excel</button>
                    |
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                </div>
            </div>
        </div>

    </div>

</form>