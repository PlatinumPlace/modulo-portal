<h2 class="text-uppercase text-center">
    <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
        cotización
    <?php else : ?>
        resumen coberturas
    <?php endif ?>
    <br>
    seguro vehículo de motor
    <br>
    plan <?= $resumen->getFieldValue('Plan') ?>
</h2>

<hr>

<?php if ($resumen->getFieldValue('Stage') == "Abandonado") : ?>
    <div class="alert alert-danger" role="alert">
        Cotización Abandonada
    </div>
    <br>
<?php endif ?>

<div class="card-deck">

    <div class="card">
        <h5 class="card-header">Opciones</h5>
        <div class="card-body">
            <?php if ($resumen->getFieldValue('Stage') != "Abandonado") : ?>
                <?php if ($resumen->getFieldValue('Nombre') == null) : ?>
                    <a href="<?= constant('url') ?>cotizaciones/completar_auto/<?= $resumen->getEntityId() ?>" class="btn btn-primary">Siguiente</a>
                <?php else : ?>
                    <a href="<?= constant('url') ?>cotizaciones/emitir/<?= $resumen->getEntityId() ?>" class="btn btn-success">Emitir</a>
                    <br><br>
                    <a href="<?= constant('url') ?>cotizaciones/descargar_auto/<?= $resumen->getEntityId() ?>" class="btn btn-info">Descargar</a>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>

    <?php if (in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
        <div class="card">
            <h5 class="card-header">Documentos</h5>
            <div class="card-body">
                <a download="Condiciones del Vehículos.pdf" href="<?= constant('url') ?>public/documents/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                <a download="Formulario de Conocimiento.pdf" href="<?= constant('url') ?>public/documents/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant('url') ?>public/documents/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Documentos Adjuntos</h5>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"></li>
                </ul>
            </div>
        </div>
    <?php endif ?>

</div>

<br>

<?php if ($resumen->getFieldValue('Nombre') != null) : ?>
    <div class="card my-8">
        <div class="card-header">
            <h5>Cliente</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula</label>
                <label class="col-sm-8 col-form-label"><?= $resumen->getFieldValue('RNC_Cedula') ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Nombre</label>
                <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Nombre') ?></label>
                <label class="col-sm-2 col-form-label font-weight-bold">Apellido</label>
                <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Apellido') ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Dirección</label>
                <label class="col-sm-10 col-form-label"><?= $resumen->getFieldValue('Direcci_n') ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Tel. Celular</label>
                <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Telefono') ?></label>
                <label class="col-sm-2 col-form-label font-weight-bold">Tel. Trabajo</label>
                <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Tel_Trabajo') ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Tel. Residencial</label>
                <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Tel_Residencia') ?></label>
                <label class="col-sm-2 col-form-label font-weight-bold">Correo Electrónico</label>
                <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Email') ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                <label class="col-sm-8 col-form-label"><?= $resumen->getFieldValue('Fecha_de_Nacimiento') ?></label>
            </div>
        </div>
    </div>
<?php endif ?>

<br>

<div class="card">
    <div class="card-header">
        <h5>Vehículo</h5>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Marca</label>
            <label class="col-sm-4 col-form-label"><?= strtoupper($resumen->getFieldValue('Marca')->getLookupLabel()) ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Modelo</label>
            <label class="col-sm-4 col-form-label"><?= strtoupper($resumen->getFieldValue('Modelo')->getLookupLabel()) ?></label>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Valor Asegurado</label>
            <label class="col-sm-4 col-form-label">RD$<?= number_format($resumen->getFieldValue('Valor_Asegurado'), 2) ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Año de fabricación</label>
            <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('A_o_de_Fabricacion') ?></label>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Chasis</label>
            <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Chasis') ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Color</label>
            <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Color') ?></label>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">Uso</label>
            <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Uso') ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Placa</label>
            <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Placa') ?></label>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label font-weight-bold">¿Es nuevo?</label>
            <label class="col-sm-4 col-form-label"><?= ($resumen->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
            <label class="col-sm-2 col-form-label font-weight-bold">Tipo</label>
            <label class="col-sm-4 col-form-label"><?= $resumen->getFieldValue('Tipo_de_veh_culo') ?></label>
        </div>
    </div>
</div>

<br>

<div class="card">
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
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
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
</div>