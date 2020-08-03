<h2 class="mt-4 text-uppercase">
    <?php
    if ($cotizacion->getFieldValue('Deal_Name') == null) {
        echo "cotización";
    } else {
        echo "resumen";
    }
    ?>
    <br>
    seguro vehículo de motor <br>
    <?= $cotizacion->getFieldValue('Subject') ?>
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
                <a href="<?= constant("url") ?>auto/emitir/<?= $id ?>" class="btn btn-primary">Emitir</a>
                <a href="<?= constant("url") ?>auto/descargar/<?= $id ?>" class="btn btn-secondary">Descargar</a>
            </div>
        </div>

        <?php if ($cotizacion->getFieldValue("Deal_Name") != null) : ?>
            <div class="card-deck">

                <div class="card">
                    <h5 class="card-header">Documentos para descargar</h5>
                    <div class="card-body">
                        <a download="Condiciones del Vehículos.pdf" href="<?= constant("url") ?>public/files/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                        <a download="Formulario de Conocimiento.pdf" href="<?= constant("url") ?>public/files/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                        <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant("url") ?>public/files/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
                        <a href="<?= constant("url") ?>auto/extracto/<?= $id ?>" class="btn btn-link">Extracto de las Principales Condiciones</a>
                    </div>
                </div>

                <div class="card">
                    <h5 class="card-header">Documentos Adjuntos</h5>
                    <div class="card-body">

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
            <br>
        <?php endif ?>

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

        <?php if ($cotizacion->getFieldValue("Deal_Name") != null) : ?>

            <div class="card mb-4">
                <h5 class="card-header">Cliente</h5>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Nombre</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('First_Name') . " " . $cliente->getFieldValue('Last_Name') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Dirección</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Mailing_Street') ?>">
                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Correo electronico</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Email') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('RNC_C_dula') ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Fecha de nacimiento</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Date_of_Birth') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Celular</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Mobile') ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Residencial</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Phone') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Trabajo</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Tel_Trabajo') ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header">Póliza</h5>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">No.</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="<?= $poliza->getFieldValue('Name') ?>">
                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Ramo</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $poliza->getFieldValue('Ramo') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $poliza->getFieldValue('Tipo') ?>">
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
                                <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Marca')->getLookupLabel() ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Modelo')->getLookupLabel() ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Año de fabricación</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('A_o_Fabricaci_n') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Tipo_Veh_culo') ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Uso</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Uso_Veh_culo') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Condiciones</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado"; ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Color</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Color') ?>">
                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Chasis</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Name') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Placa</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Placa')  ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


        <?php else : ?>
            <div class="card mb-4">
                <h5 class="card-header">Vehículo</h5>
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Marca')->getLookupLabel() ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Modelo')->getLookupLabel() ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Año de fabricación</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('A_o_Fabricaci_n') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Tipo_Veh_culo') ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Uso</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Uso_Veh_culo') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label font-weight-bold">Condiciones</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" value="<?= ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado"; ?>">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        <?php endif ?>


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