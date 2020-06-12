<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>

    <br>
<?php endif ?>

<?php if (in_array($oferta->getFieldValue("Stage"), $emitida)) : ?>
    <div class="card-deck">
        <div class="card">
            <h5 class="card-header">Documentos</h5>
            <div class="card-body">
                <a download="Condiciones del Vehículos.pdf" href="<?= constant("url") ?>public/files/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                <a download="Formulario de Conocimiento.pdf" href="<?= constant("url") ?>public/files/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant("url") ?>public/files/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">Documentos Adjuntos</h5>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    if (!empty($documentos_adjuntos)) {
                        foreach ($documentos_adjuntos as $documento) {
                            echo '<li class="list-group-item">' . $documento->getFileName() . '</li>';
                        }
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

        <?php if ($oferta->getFieldValue('Email') != null) : ?>
            <h5>Cliente</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">RNC/Cédula</label>
                    <br>
                    <label><?= $oferta->getFieldValue('RNC_Cedula') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nombre</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Nombre') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Apellido</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Apellido') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Dirección</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Direcci_n') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tel. Celular</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Telefono') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tel. Trabajo</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Tel_Trabajo') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tel. Residencial</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Tel_Residencia') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Correo Electrónico</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Email') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Fecha de Nacimiento</label>
                    <br>
                    <label><?= $oferta->getFieldValue('Fecha_de_Nacimiento') ?></label>
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
                <label><?= strtoupper($oferta->getFieldValue('Marca')->getLookupLabel()) ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Modelo</label>
                <br>
                <label><?= strtoupper($oferta->getFieldValue('Modelo')->getLookupLabel()) ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Año de fabricación</label>
                <br>
                <label><?= $oferta->getFieldValue('A_o_de_Fabricacion') ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Valor Asegurado</label>
                <br>
                <label>RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Chasis</label>
                <br>
                <label><?= $oferta->getFieldValue('Chasis') ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Color</label>
                <br>
                <label><?= $oferta->getFieldValue('Color') ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Uso</label>
                <br>
                <label><?= $oferta->getFieldValue('Uso') ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Placa</label>
                <br>
                <label><?= $oferta->getFieldValue('Placa') ?></label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Estado</label>
                <br>
                <label><?= ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
            </div>

            <div class="form-group col-md-6">
                <label class="font-weight-bold">Tipo</label>
                <br>
                <label><?= $oferta->getFieldValue('Tipo_de_veh_culo') ?></label>
            </div>
        </div>

    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <?php if (!empty($cotizaciones)) : ?>
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
        <?php else : ?>
            <h4>Ha ocurrido un error,verifica los datos y intentelo de nuevo.</h4>
        <?php endif ?>
    </div>
</div>