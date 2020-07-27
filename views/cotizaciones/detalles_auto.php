<h2 class="mt-4 text-uppercase">
    cotización <br>
    seguro vehículo de motor <br>
    <?= $cotizacion->getFieldValue('Subject') ?>
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/detalles_auto/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
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
                <?php if ($cotizacion->getFieldValue('Deal_Name') == null) : ?>
                    <a href="<?= constant("url") ?>cotizaciones/emitir_auto/<?= $id ?>" class="btn btn-primary">Emitir</a>
                <?php else : ?>
                    <a href="<?= constant("url") ?>tratos/detalles_auto/<?= $cotizacion->getFieldValue('Deal_Name')->getEntityId() ?>" class="btn btn-success">Ver Emisión</a>
                <?php endif ?>
                <a href="<?= constant("url") ?>cotizaciones/detalles_auto/<?= $id ?>/descargar" class="btn btn-secondary">Descargar</a>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Detalles</h5>
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Estado</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Quote_Stage') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Fecha de emisión</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Fecha_emisi_n') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Fecha de cierre</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Valid_Till') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Tipo de póliza</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Tipo_P_liza') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Valor Asegurado</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Vehículo</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Marca</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Marca')->getLookupLabel() ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Modelo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Modelo')->getLookupLabel() ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Año de fabricación</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('A_o_Fabricaci_n') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Tipo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Tipo_Veh_culo') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Uso</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Uso_Veh_culo') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Condiciones</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado"; ?>">
                            </div>
                        </div>
                    </div>
                </div>
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