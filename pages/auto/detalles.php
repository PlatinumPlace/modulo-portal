<?php

$api = new api;

$url = rtrim($_GET['url'], "/");
$url = explode('/', $url);
$id = $url[2];

$resumen = $api->getRecord("Deals", $id);
$criterio = "Deal_Name:equals:" . $id;
$detalles =$api->searchRecordsByCriteria("Quotes", $criterio);

$emitida = array("Emitido", "En trámite");

if (empty($resumen)) {
    header("Location:" . constant("url") . "cotizaciones/error");
    exit();
}

if (in_array($resumen->getFieldValue("Stage"), $emitida)) {
    $documentos_adjuntos = $api->getAttachments("Deals", $id);
}

if ($resumen->getFieldValue("Stage") == "Abandonada") {
    $alerta = 'Cotización Abandonada';
}

if (isset($_GET["alert"])) {
    $alerta = $_GET["alert"];
}

require_once("pages/template/header_auto.php");

?>
<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>

    <br>
<?php endif ?>

<?php if (in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
    <div class="card-deck">
        <div class="card">
            <h5 class="card-header">Documentos</h5>
            <div class="card-body">
                <a download="Condiciones del Vehículos.pdf" href="<?= constant("url") ?>files/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                <a download="Formulario de Conocimiento.pdf" href="<?= constant("url") ?>files/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant("url") ?>files/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">Documentos Adjuntos</h5>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    foreach ($documentos_adjuntos as $documento) {
                        echo '<li class="list-group-item">' . $documento->getFileName() . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <br>
<?php endif ?>

<div class="card">
    <div class="card-body">

        <?php if ($resumen->getFieldValue('Email') != null) : ?>
            <h5>Cliente</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">RNC/Cédula</label>
                    <br>
                    <label><?= $resumen->getFieldValue('RNC_Cedula') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nombre</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Nombre') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Apellido</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Apellido') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Dirección</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Direcci_n') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tel. Celular</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Telefono') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tel. Trabajo</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Tel_Trabajo') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tel. Residencial</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Tel_Residencia') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Correo Electrónico</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Email') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Fecha de Nacimiento</label>
                    <br>
                    <label><?= $resumen->getFieldValue('Fecha_de_Nacimiento') ?></label>
                </div>
            </div>

            <br>
        <?php endif ?>

        <h5>Vehículo</h5>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Marca</label>
                <br>
                <label><?= strtoupper($resumen->getFieldValue('Marca')->getLookupLabel()) ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Modelo</label>
                <br>
                <label><?= strtoupper($resumen->getFieldValue('Modelo')->getLookupLabel()) ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Año de fabricación</label>
                <br>
                <label><?= $resumen->getFieldValue('A_o_de_Fabricacion') ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Valor Asegurado</label>
                <br>
                <label>RD$<?= number_format($resumen->getFieldValue('Valor_Asegurado'), 2) ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Chasis</label>
                <br>
                <label><?= $resumen->getFieldValue('Chasis') ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Color</label>
                <br>
                <label><?= $resumen->getFieldValue('Color') ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Uso</label>
                <br>
                <label><?= $resumen->getFieldValue('Uso') ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Placa</label>
                <br>
                <label><?= $resumen->getFieldValue('Placa') ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Estado</label>
                <br>
                <label><?= ($resumen->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Tipo</label>
                <br>
                <label><?= $resumen->getFieldValue('Tipo_de_veh_culo') ?></label>
            </div>
        </div>

    </div>
</div>

<br>

<div class="card">
    <div class="card-body">

        <?php if (!empty($detalles)) : ?>
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
                        <?php foreach ($detalles as $info) : ?>
                            <tr>
                                <th scope="row">
                                    <?= $info->getFieldValue('Aseguradora')->getLookupLabel() ?>
                                </th>
                                <?php if ($info->getFieldValue('Grand_Total') == 0) : ?>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                <?php else : ?>
                                    <?php $planes = $info->getLineItems() ?>
                                    <?php foreach ($planes as $plan) : ?>
                                        <td>RD$<?= number_format($plan->getTotalAfterDiscount(), 2) ?></td>
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
            <h4>Ha ocurrido un error,verifica los datos y crea otra cotización</h4>
        <?php endif ?>
    </div>
</div>