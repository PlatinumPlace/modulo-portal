<form class="row" enctype="multipart/form-data" method="POST" action="<?= constant('url') ?>reporte/index">
    <div class="col-12">
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
                    <label class="col-sm-2 col-form-label">Usuario</label>
                    <div class="col-sm-4">
                        <select name="usuario" class="form-control" required>
                            <option value="1" selected><?= $_SESSION['usuario_nombre'] ?></option>
                            <option value="">Todos</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Aseguradora</label>
                    <div class="col-sm-4">
                        <select name="contrato_id" class="form-control" required>
                            <?php
                            foreach ($contratos as $contrato) {
                                echo '<option value="' . $contrato->getEntityId() . '">' . $contrato->getFieldValue("Aseguradora")->getLookupLabel()  . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Tipo</label>
                    <div class="col-sm-4">
                        <select name="tipo" class="form-control" required>
                            <option value="Auto" selected>Auto</option>
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
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-10">
        &nbsp;
    </div>
    <div class="col-2">
        <button type="submit" name="submit" class="btn btn-success">Exportar en csv</button>
    </div>
</form>