<h2 class="text-uppercase text-center">
    <?php if (!in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>
        cotización
    <?php else : ?>
        resumen
    <?php endif ?>
    coberturas
    <br>
    seguro vehículo de motor
    <br>
    plan <?= $cotizacion->getFieldValue('Plan') ?>
</h2>

<hr>

<?php if ($cotizacion->getFieldValue('Stage') == "Abandonado") : ?>

    <div class="alert alert-danger" role="alert">Cotización Abandonada</div>

    <br>

<?php endif ?>

<div class="card-deck">

    <div class="card">
        <h5 class="card-header">Opciones</h5>
        <div class="card-body">

            <?php if ($cotizacion->getFieldValue('Nombre') == null) : ?>
                <a href="<?= constant('completar_cotizacion_') ?><?= strtolower($cotizacion->getFieldValue('Type')) ?>&value=<?= $cotizacion->getEntityId() ?>" class="btn btn-primary">Siguiente</a>
            <?php else : ?>
                <a href="<?= constant('emiti_cotizacion') ?><?= strtolower($cotizacion->getFieldValue('Type')) ?>&value=<?= $cotizacion->getEntityId() ?>" class="btn btn-success">Emitir</a>
                <a href="<?= constant('descargar_cotizacion_') ?><?= strtolower($cotizacion->getFieldValue('Type')) ?>&value=<?= $cotizacion->getEntityId() ?>" class="btn btn-info">Descargar</a>
            <?php endif ?>

        </div>
    </div>

    <?php if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>

        <div class="card">
            <h5 class="card-header">Documentos</h5>
            <div class="card-body">

                <a download="Condiciones del Vehículos.pdf" href="public/files/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                <a download="Formulario de Conocimiento.pdf" href="public/files/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                <a download="Formulario de Inspección de Vehículos.pdf" href="public/files/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>

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

    <?php endif ?>

</div>

<br>

<?php if ($cotizacion->getFieldValue('Nombre') != null) : ?>

    <div class="card my-8">
        <h5 class="card-header">Cliente</h5>
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula</label>
                <label class="col-sm-8 col-form-label"><?= $cotizacion->getFieldValue('RNC_Cedula') ?></label>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Nombre</label>
                <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Nombre') ?></label>
                <label class="col-sm-2 col-form-label font-weight-bold">Apellido</label>
                <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Apellido') ?></label>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Dirección</label>
                <label class="col-sm-10 col-form-label"><?= $cotizacion->getFieldValue('Direcci_n') ?></label>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Tel. Celular</label>
                <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Telefono') ?></label>
                <label class="col-sm-2 col-form-label font-weight-bold">Tel. Trabajo</label>
                <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Tel_Trabajo') ?></label>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Tel. Residencial</label>
                <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Tel_Residencia') ?></label>
                <label class="col-sm-2 col-form-label font-weight-bold">Correo Electrónico</label>
                <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Email') ?></label>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                <label class="col-sm-8 col-form-label"><?= $cotizacion->getFieldValue('Fecha_de_Nacimiento') ?></label>
            </div>

        </div>
    </div>

<?php endif ?>

<br>

<div class="card">
    <h5 class="card-header">Vehículo</h5>
    <div class="card-body">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Marca</label>
            <label class="col-sm-4 col-form-label"><?= strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel()) ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Modelo</label>
            <label class="col-sm-4 col-form-label"><?= strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel()) ?></label>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Valor Asegurado</label>
            <label class="col-sm-4 col-form-label">RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Año de fabricación</label>
            <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('A_o_de_Fabricacion') ?></label>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Chasis</label>
            <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Chasis') ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Color</label>
            <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Color') ?></label>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Uso</label>
            <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Uso') ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Placa</label>
            <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Placa') ?></label>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">¿Es nuevo?</label>
            <label class="col-sm-4 col-form-label"><?= ($cotizacion->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Tipo</label>
            <label class="col-sm-4 col-form-label"><?= $cotizacion->getFieldValue('Tipo_de_veh_culo') ?></label>
        </div>

    </div>
</div>

<br>

<div class="card">
    <div class="card-body">

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
                <?php foreach ($detalles as $resumen) : ?>
                    <tr>
                        <th scope="row">
                            <?= $resumen->getFieldValue('Aseguradora')->getLookupLabel() ?>
                        </th>
                        <?php if ($resumen->getFieldValue('Grand_Total') == 0) : ?>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                        <?php else : ?>
                            <?php $planes = $resumen->getLineItems() ?>
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
</div>