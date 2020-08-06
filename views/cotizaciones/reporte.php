<h1 class="mt-4 text-uppercase">reporte de cotizaciones</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>cotizaciones/reporte">Reporte</a></li>
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
                <form method="POST" action="<?= constant("url") ?>cotizaciones/reporte">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tipo de cotización</label>
                        <div class="col-sm-9">
                            <select name="tipo_cotizacion" class="form-control">
                                <option value="Auto" selected>Auto</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Estado de la cotización</label>
                        <div class="col-sm-9">
                            <select name="estado_cotizacion" class="form-control">
                                <option value="pendientes" selected>Pendientes</option>
                                <option value="emitidos">Emitidos</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Desde</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="desde" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Hasta</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="hasta" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Aseguradora</label>
                        <div class="col-sm-9">
                            <select name="aseguradora" class="form-control">
                                <option value="" selected>Todas</option>
                                <?php
                                $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                $lista_contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);
                                foreach ($lista_contratos as $contrato) {
                                    echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <br>
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>

                </form>
            </div>
        </div>
    </div>
</div>