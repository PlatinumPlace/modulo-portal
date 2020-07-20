<h1 class="mt-4 text-uppercase">exportar cotizaciones</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item active">Reportes</li>
</ol>
<form class="row justify-content-center" method="POST" action="<?= constant("url") ?>cotizaciones/reportes">
    <div class="col-lg-10">
        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de reporte</label>
                            <select name="tipo_reporte" class="form-control">
                                <option value="cotizaciones" selected>Cotizaciones</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de cotización</label>
                            <select name="tipo_cotizacion" class="form-control">
                                <option value="auto" selected>Auto</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Desde</label>
                            <input type="date" class="form-control" name="desde" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Hasta</label>
                            <input type="date" class="form-control" name="hasta" required>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Aseguradora</label>
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
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                        |
                        <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                    </div>
                </div>
            </div>
        </div>
</form>