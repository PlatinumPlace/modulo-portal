<h1 class="mt-4 text-uppercase">reporte de emisiones</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>tratos/buscar">Tratos</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>tratos/reporte">Reporte</a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>tratos/reporte">

                    <div class="form-group row">
                        <label for="tipo_reporte" class="col-sm-3 col-form-label font-weight-bold">Tipo de emision</label>
                        <div class="col-sm-9">
                            <select name="tipo_reporte" id="tipo_reporte" class="form-control">
                                <option value="auto" selected>Auto</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 font-weight-bold">¿Incluir comisión?</div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="comision">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="desde" class="col-sm-3 col-form-label font-weight-bold">Desde</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="desde" id="desde" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="hasta" class="col-sm-3 col-form-label font-weight-bold">Hasta</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="hasta" id="hasta" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="aseguradora_id" class="col-sm-3 col-form-label font-weight-bold">Aseguradora</label>
                        <div class="col-sm-9">
                            <select name="aseguradora_id" id="aseguradora_id" class="form-control">
                                <option value="" selected>Todas</option>
                                <?php
                                $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                $lista_contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);
                                foreach ($lista_contratos as $contrato) {
                                    echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getEntityId() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <br>
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                    |
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>

                </form>
            </div>
        </div>
    </div>
</div>