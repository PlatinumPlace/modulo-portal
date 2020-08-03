<h2 class="mt-4 text-uppercase">
    cotización <br>
    seguro vida
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>vida/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
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
                <a href="<?= constant("url") ?>vida/emitir/<?= $id ?>" class="btn btn-primary">Emitir</a>
                <a href="<?= constant("url") ?>vida/descargar/<?= $id ?>" class="btn btn-secondary">Descargar</a>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Detalles</h5>
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Valor Asegurado</label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" value="RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>">
                    </div>
                </div>

                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Estado</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Quote_Stage') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Tipo de póliza</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Tipo_P_liza') ?>">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Fecha de emisión</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Fecha_emisi_n') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Fecha de cierre</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Valid_Till') ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Deudor (es)</h5>
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Fecha de nacimiento Deudor</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Fecha_Nacimiento_Deudor') ?>">
                                <?php echo "(" . calcular_edad($cotizacion->getFieldValue('Fecha_Nacimiento_Deudor')) . " Años)"; ?>
                            </div>
                        </div>

                        <?php if (!empty($cotizacion->getFieldValue('Fecha_Nacimiento_Codeudor'))) : ?>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Fecha de nacimiento Codeudor</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Fecha_Nacimiento_Codeudor') ?>">
                                    <?php echo "(" . calcular_edad($cotizacion->getFieldValue('Fecha_Nacimiento_Codeudor')) . " Años)"; ?>
                                </div>
                            </div>
                        <?php endif ?>

                    </div>
                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Plazo en Meses</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Plazo') ?>">
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