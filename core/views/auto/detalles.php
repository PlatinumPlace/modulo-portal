<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<?php if (in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
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

                <br>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="<?= constant("url") ?>auto/detalles/<?= $resumen_id ?>?page=<?= $num_pagina - 1 ?>">Anterior</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?= constant("url") ?>auto/detalles/<?= $resumen_id ?>?page=<?= $num_pagina + 1 ?>">Siguente</a>
                        </li>
                    </ul>
                </nav>
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
        <?php endif ?>
    </div>
</div>