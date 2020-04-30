<div class="row">

    <div class="col-lg-8">

        <h1 class="mt-4 text-uppercase">
            <?php if (!in_array($oferta->getFieldValue("Stage"), $emitida)) : ?>
                cotización
            <?php else : ?>
                resumen coberturas
            <?php endif ?>
            <br>
            seguro vehículo de motor<br>
            plan <?= $oferta->getFieldValue('Plan') ?>
        </h1>

        <hr>

        <?php if ($oferta->getFieldValue('Stage') == "Abandonado") : ?>
            <div class="alert alert-danger" role="alert">
                Cotización Abandonada
            </div>
            <br>
        <?php endif ?>
        <?php if ($oferta->getFieldValue('Nombre') != null) : ?>
            <div class="card my-8">
                <div class="card-header">
                    <h5>Datos del Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula</label>
                        <label class="col-sm-8 col-form-label"><?= $oferta->getFieldValue('RNC_Cedula') ?></label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Nombre</label>
                        <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Nombre') ?></label>
                        <label class="col-sm-2 col-form-label font-weight-bold">Apellido</label>
                        <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Apellido') ?></label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Dirección</label>
                        <label class="col-sm-10 col-form-label"><?= $oferta->getFieldValue('Direcci_n') ?></label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Tel. Celular</label>
                        <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Telefono') ?></label>
                        <label class="col-sm-2 col-form-label font-weight-bold">Tel. Trabajo</label>
                        <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Tel_Trabajo') ?></label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Tel. Residencial</label>
                        <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Tel_Residencia') ?></label>
                        <label class="col-sm-2 col-form-label font-weight-bold">Correo Electrónico</label>
                        <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Email') ?></label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                        <label class="col-sm-8 col-form-label"><?= $oferta->getFieldValue('Fecha_de_Nacimiento') ?></label>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <br>

        <div class="card my-8">
            <div class="card-header">
                <h5>Datos de Vehículo</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Marca</label>
                    <label class="col-sm-4 col-form-label"><?= strtoupper($oferta->getFieldValue('Marca')->getLookupLabel()) ?></label>
                    <label class="col-sm-2 col-form-label font-weight-bold">Modelo</label>
                    <label class="col-sm-4 col-form-label"><?= strtoupper($oferta->getFieldValue('Modelo')->getLookupLabel()) ?></label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Valor Asegurado</label>
                    <label class="col-sm-4 col-form-label">RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?></label>
                    <label class="col-sm-2 col-form-label font-weight-bold">Año de fabricación</label>
                    <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('A_o_de_Fabricacion') ?></label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Chasis</label>
                    <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Chasis') ?></label>
                    <label class="col-sm-2 col-form-label font-weight-bold">Color</label>
                    <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Color') ?></label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Uso</label>
                    <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Uso') ?></label>
                    <label class="col-sm-2 col-form-label font-weight-bold">Placa</label>
                    <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Placa') ?></label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">¿Es nuevo?</label>
                    <label class="col-sm-4 col-form-label"><?= ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
                    <label class="col-sm-2 col-form-label font-weight-bold">Tipo</label>
                    <label class="col-sm-4 col-form-label"><?= $oferta->getFieldValue('Tipo_de_veh_culo') ?></label>
                </div>
            </div>
        </div>

        <br>

        <div class="card my-8">
            <div class="card-header">
                <h5>Coberturas</h5>
            </div>
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
                                        <td>No esta disponible</td>
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

    </div>

    <div class="col-md-4">

        <div class="card my-4">
            <h5 class="card-header">Opciones</h5>
            <div class="card-body">
                <?php if ($oferta->getFieldValue('Stage') != "Abandonado") : ?>
                    <?php if ($oferta->getFieldValue('Nombre') == null) : ?>
                        <a href="<?= constant('url') ?>auto/completar/<?= $oferta->getEntityId() ?>" class="btn btn-primary">Siguiente</a>
                    <?php else : ?>
                        <a href="<?= constant('url') ?>auto/emitir/<?= $oferta->getEntityId() ?>" class="btn btn-success"><?= (!in_array($oferta->getFieldValue("Stage"), $emitida)) ? "Emitir" : "Completar"; ?></a>
                        <a href="<?= constant('url') ?>auto/descargar/<?= $oferta->getEntityId() ?>" class="btn btn-info">Descargar</a>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>

        <?php if (in_array($oferta->getFieldValue("Stage"), $emitida)) : ?>
            <div class="card my-4">
                <h5 class="card-header">Documentos</h5>
                <div class="card-body">
                    <a download="Condiciones del Vehículos.pdf" href="<?= constant('url') ?>public/documents/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                    <a download="Formulario de Conocimiento.pdf" href="<?= constant('url') ?>public/documents/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                    <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant('url') ?>public/documents/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
                </div>
            </div>
        <?php endif ?>

    </div>

</div>