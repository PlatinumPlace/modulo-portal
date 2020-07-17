<?php
$cotizaciones = new cotizaciones;
$url = obtener_url();

if (empty($url[0])) {
    require_once "pages/error.php";
    exit();
}

$detalles_resumen = $cotizaciones->detalles_resumen($url[0]);
$lista_cotizaciones = $cotizaciones->lista_cotizaciones_asosiadas($url[0]);

$alerta = (!is_numeric($url[1])) ? $url[1] : null;
$num_pagina = (isset($url[1])) ? $url[1] : 1;

if (empty($detalles_resumen)) {
    require_once "pages/error.php";
    exit();
}

if ($detalles_resumen->getFieldValue("Stage") == "Abandonada") {
    $alerta = "Cotización Abandonada";
}

require_once 'pages/layout/header_main.php';
?>
<h2 class="mt-4 text-uppercase text-center">
    seguro vehículo de motor plan <?= $detalles_resumen->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $url[0] ?>">No. <?= $detalles_resumen->getFieldValue('No_Cotizaci_n') ?></a></li>
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
                <?php if ($detalles_resumen->getFieldValue('Nombre') == null) : ?>
                    <a href="<?= constant("url") ?>auto/completar/<?= $url[0] ?>" class="btn btn-secondary">Completar</a>
                <?php else : ?>
                    <a href="<?= constant("url") ?>auto/emitir/<?= $url[0] ?>" class="btn btn-success">Emitir</a>
                    <a href="<?= constant("url") ?>auto/descargar/<?= $url[0] ?>" class="btn btn-primary">Descargar</a>
                <?php endif ?>
            </div>
        </div>
        <?php if (in_array($detalles_resumen->getFieldValue("Stage"), array("Emitido", "En trámite"))) : ?>
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
                            <ul class="list-group">
                                <?php $lista_adjuntos = $cotizaciones->lista_adjuntos($url[0], $num_pagina) ?>
                                <?php foreach ($lista_adjuntos as $documento) : ?>
                                    <li class="list-group-item"><?= $documento->getFileName() ?></li>
                                <?php endforeach ?>
                            </ul>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="<?= constant("url") ?>auto/detalles/<?= $url[0] ?>/<?= $num_pagina - 1 ?>">Anterior</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= constant("url") ?>auto/detalles/<?= $url[0] ?>/<?= $num_pagina + 1 ?>">Siguente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($detalles_resumen->getFieldValue('Nombre') != null) : ?>
            <div class="card mb-4">
                <h5 class="card-header">Cliente</h5>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">RNC/Cédula</label>
                                <br>
                                <label><?= $detalles_resumen->getFieldValue('RNC_Cedula') ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Nombre</label>
                                <br>
                                <label><?= $detalles_resumen->getFieldValue('Nombre') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Apellido</label>
                                <br>
                                <label><?= $detalles_resumen->getFieldValue('Apellidos') ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Dirección</label>
                                <br>
                                <label><?= $detalles_resumen->getFieldValue('Direcci_n') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Tel. Celular</label>
                            <br>
                            <label><?= $detalles_resumen->getFieldValue('Telefono') ?></label>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Tel. Trabajo</label>
                            <br>
                            <label><?= $detalles_resumen->getFieldValue('Tel_Trabajo') ?></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Tel. Residencial</label>
                            <br>
                            <label><?= $detalles_resumen->getFieldValue('Tel_Residencia') ?></label>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Correo Electrónico</label>
                            <br>
                            <label><?= $detalles_resumen->getFieldValue('Email') ?></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Fecha de Nacimiento</label>
                            <br>
                            <label><?= $detalles_resumen->getFieldValue('Fecha_de_Nacimiento') ?></label>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <div class="card mb-4">
            <h5 class="card-header">Vehículo</h5>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Marca</label>
                            <br>
                            <label><?= strtoupper($detalles_resumen->getFieldValue('Marca')->getLookupLabel()) ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Modelo</label>
                            <br>
                            <label><?= strtoupper($detalles_resumen->getFieldValue('Modelo')->getLookupLabel()) ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Año de fabricación</label>
                            <br>
                            <label><?= $detalles_resumen->getFieldValue('A_o_de_Fabricacion') ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Valor Asegurado</label>
                            <br>
                            <label>RD$<?= number_format($detalles_resumen->getFieldValue('Valor_Asegurado'), 2) ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Chasis</label>
                        <br>
                        <label><?= $detalles_resumen->getFieldValue('Chasis') ?></label>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Color</label>
                        <br>
                        <label><?= $detalles_resumen->getFieldValue('Color') ?></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Uso</label>
                        <br>
                        <label><?= $detalles_resumen->getFieldValue('Uso') ?></label>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Placa</label>
                        <br>
                        <label><?= $detalles_resumen->getFieldValue('Placa') ?></label>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Estado</label>
                        <br>
                        <label><?= ($detalles_resumen->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Tipo</label>
                        <br>
                        <label><?= $detalles_resumen->getFieldValue('Tipo_de_Veh_culo') ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <?php if (!empty($lista_cotizaciones)) : ?>
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
                                <?php foreach ($lista_cotizaciones as $cotizacion) : ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() ?>
                                        </th>
                                        <?php if ($cotizacion->getFieldValue('Grand_Total') == 0) : ?>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                        <?php else : ?>
                                            <?php $planes = $cotizacion->getLineItems() ?>
                                            <?php foreach ($planes as $plan) : ?>
                                                <td>RD$<?= number_format($plan->getListPrice(), 2) ?></td>
                                                <td>RD$<?= number_format($plan->getTaxAmount(), 2) ?></td>
                                                <td>RD$<?= number_format($plan->getNetTotal(), 2) ?></td>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="alert alert-primary" role="alert">
                        No existen cotizaciones.
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php require_once 'pages/layout/footer_main.php'; ?>