<h2 class="mt-4 text-uppercase text-center">
    seguro vehículo de motor plan <?= $cotizacion->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
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
                <?php if ($cotizacion->getFieldValue('Quote_Stage') == "Negociación") : ?>
                    <a href="<?= constant("url") ?>auto/emitir/<?= $id ?>" class="btn btn-primary">Emitir</a>
                <?php endif ?>
                <a href="<?= constant("url") ?>auto/adjuntar/<?= $id ?>" class="btn btn-success">Adjuntar</a>
                <a href="<?= constant("url") ?>auto/descargar/<?= $id ?>" class="btn btn-secondary">Descargar</a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <h5 class="card-header">Documentos para descargar</h5>
                    <div class="card-body">
                        <a download="Condiciones del Vehículos.pdf" href="<?= constant("url") ?>public/files/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                        <a download="Formulario de Conocimiento.pdf" href="<?= constant("url") ?>public/files/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                        <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant("url") ?>public/files/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-4">
                    <h5 class="card-header">Documentos Adjuntos</h5>
                    <div class="card-body">
                        <?php $documentos_aduntos = $api->lista_adjuntos("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId(), $num_pagina, 2) ?>
                        <?php if (!empty($documentos_aduntos)) : ?>
                            <ul class="list-group">
                                <?php foreach ($documentos_aduntos as $documento) : ?>
                                    <li class="list-group-item"><?= $documento->getFileName() ?></li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                        <br>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item">
                                    <a class="page-link" href="<?= constant("url") ?>auto/detalles/<?= $id ?>/<?= $num_pagina - 1 ?>">Anterior</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?= constant("url") ?>auto/detalles/<?= $id ?>/<?= $num_pagina + 1 ?>">Siguente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <h5 class="card-header">Vehículo</h5>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Marca</label>
                            <br>
                            <label><?= strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel()) ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Modelo</label>
                            <br>
                            <label><?= strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel()) ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Año de fabricación</label>
                            <br>
                            <label><?= $cotizacion->getFieldValue('A_o_Fabricaci_n') ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Valor Asegurado</label>
                            <br>
                            <label>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Tipo de Póliza</label>
                            <br>
                            <label><?= $cotizacion->getFieldValue('Tipo_P_liza') ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Tipo</label>
                            <br>
                            <label><?= $cotizacion->getFieldValue('Tipo_Veh_culo') ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Uso</label>
                            <br>
                            <label><?= $cotizacion->getFieldValue('Uso_Veh_culo') ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Estado</label>
                            <br>
                            <label><?= ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
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