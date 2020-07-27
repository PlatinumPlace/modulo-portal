<h2 class="mt-4 text-uppercase">
    Resumen <br>
    seguro vehículo de motor <br>
    <?= $trato->getFieldValue('Deal_Name') ?>
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>tratos/buscar">Tratos</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>tratos/detalles/auto/<?= $id ?>">No. <?= $trato->getFieldValue('No_Emisi_n') ?></a></li>
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
                <a href="<?= constant("url") ?>tratos/adjuntar/<?= $id ?>" class="btn btn-success">Adjuntar</a>
                <a href="<?= constant("url") ?>tratos/descargar/auto/<?= $id ?>" class="btn btn-secondary">Descargar</a>
            </div>
        </div>

        <div class="card-deck">

            <div class="card">
                <h5 class="card-header">Documentos para descargar</h5>
                <div class="card-body">
                    <a download="Condiciones del Vehículos.pdf" href="<?= constant("url") ?>public/files/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                    <a download="Formulario de Conocimiento.pdf" href="<?= constant("url") ?>public/files/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                    <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant("url") ?>public/files/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
                </div>
            </div>

            <div class="card">
                <h5 class="card-header">Documentos Adjuntos</h5>
                <div class="card-body">

                    <?php $documentos_aduntos = $api->lista_adjuntos("Deals", $id, $num_pagina, 2) ?>
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
                                <a class="page-link" href="<?= constant("url") ?>tratos/detalles/auto/<?= $id ?>/<?= $num_pagina - 1 ?>">Anterior</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="<?= constant("url") ?>tratos/detalles/auto/<?= $id ?>/<?= $num_pagina + 1 ?>">Siguente</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>

        </div>

        <br>
        <div class="card mb-4">
            <h5 class="card-header">Detalles</h5>
            <div class="card-body">

                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Tipo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $trato->getFieldValue('Type') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Estado</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $trato->getFieldValue('Stage') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Fecha de emisión</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $trato->getFieldValue('Fecha_de_emisi_n') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Fecha de cierre</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $trato->getFieldValue('Closing_Date') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Aseguradora</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $trato->getFieldValue('Aseguradora')->getLookupLabel() ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Valor Asegurado</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Comisión</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Comisi_n_Socio'), 2) ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Prima Neta</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Prima_Neta'), 2) ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>ISC</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('ISC'), 2) ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Prima Total</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Prima_Total'), 2) ?>">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Póliza</h5>
            <div class="card-body">

                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>No.</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $poliza->getFieldValue('Name') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Ramo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $poliza->getFieldValue('Ramo') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Tipo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $poliza->getFieldValue('Tipo') ?>">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Bien</h5>
            <div class="card-body">

                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Marca</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Marca') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Modelo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Modelo') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Tipo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Tipo_de_veh_culo') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Año</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('A_o') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Chasis</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Name') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Color</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Color') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Placa</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $bien->getFieldValue('Placa') ?>">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Cliente</h5>
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Nombre</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Nombre') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>RNC/Cédula</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Name')->getLookupLabel() ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Correo electronico</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Email') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Dirección</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Direcci_n') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Apellido</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Apellido') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Fecha de nacimiento</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Fecha_de_Nacimiento') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Teléfono</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Tel') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Tel. Residencia</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Tel_Residencia') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><strong>Tel. Trabajo</strong></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" value="<?= $cliente->getFieldValue('Tel_Trabajo') ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>