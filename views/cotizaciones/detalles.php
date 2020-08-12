<h2 class="mt-4 text-uppercase">
    cotización

    <?php
    if ($cotizacion->getFieldValue("Tipo")) {
        echo "<br> seguro vehículo de motor <br>";
    }
    ?>

    <?= $cotizacion->getFieldValue('Subject') ?>
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (isset($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <div class="card mb-4">
            <div class="card-body">
                <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
                    <a href="<?= constant("url") ?>cotizaciones/emitir/<?= $id ?>" class="btn btn-success">Emitir</a>
                <?php else : ?>
                    <a href="<?= constant("url") ?>cotizaciones/documentos/<?= $id ?>" class="btn btn-primary">Documentos</a>
                    <a href="<?= constant("url") ?>cotizaciones/adjuntar/<?= $id ?>" class="btn btn-secondary">Adjuntar</a>
                <?php endif ?>
                <a href="<?= constant("url") ?>cotizaciones/descargar/<?= $id ?>" class="btn btn-info">Descargar</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">

                <h4>Detalles</h4>
                <hr>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Estado</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= $cotizacion->getFieldValue('Quote_Stage') ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Fecha de emisión</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= $cotizacion->getFieldValue('Fecha_emisi_n') ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Fecha de cierre</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= $cotizacion->getFieldValue('Valid_Till') ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Valor Asegurado</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Deudor</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Codeudor</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= (!empty($cotizacion->getFieldValue('Fecha_Nacimiento_Codeudor'))) ? "Si" : "No" ?>
                        </label>
                    </div>
                </div>

                <?php if ($cotizacion->getFieldValue('Tipo') == "Auto") : ?>

                    <br>
                    <h4>Vehículo</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('Marca')->getLookupLabel() ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('Modelo')->getLookupLabel() ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Año de fabricación</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('A_o_Fabricaci_n') ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('Tipo_Veh_culo') ?>
                            </label>
                        </div>
                    </div>

                <?php endif ?>

            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Aseguradora</th>
                                <th scope="col">Prima Neta</th>
                                <th scope="col">ISC</th>
                                <th scope="col">Prima Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $planes = $cotizacion->getLineItems() ?>
                            <?php foreach ($planes as $plan) : ?>
                                <tr>
                                    <td><?= $plan->getDescription() ?></td>
                                    <td>RD$<?= number_format($plan->getListPrice(), 2) ?></td>
                                    <td>RD$<?= number_format($plan->getTaxAmount(), 2) ?></td>
                                    <td>RD$<?= number_format($plan->getNetTotal(), 2) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>