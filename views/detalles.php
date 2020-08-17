<?php
$api = new api();
$url = obtener_url();
$alerta = (isset($url[2]) and!is_numeric($url[2])) ? $url[2] : null;
$num_pagina = (isset($url[2]) and is_numeric($url[2])) ? $url[2] : 1;
$id = (isset($url[1])) ? $url[1] : null;
$cotizacion = $api->getRecord("Quotes", $id);

if (empty($cotizacion)) {
    require_once "views/error.php";
    exit();
}

if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
    $alerta = "Cotización Vencida.";
}

require_once 'views/layout/header.php';
?>
<h2 class="mt-4 text-uppercase text-center">
    <?= $cotizacion->getFieldValue('Subject') ?>
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
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
                <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
                    <a href="<?= constant("url") ?>emitir/<?= $id ?>" class="btn btn-success">Emitir</a>
                <?php else : ?>
                    <a href="<?= constant("url") ?>documentos/<?= $id ?>" class="btn btn-primary">Documentos</a>
                    <a href="<?= constant("url") ?>adjuntar/<?= $id ?>" class="btn btn-secondary">Adjuntar</a>
                <?php endif ?>
                <a href="<?= constant("url") ?>descargar/<?= $id ?>" class="btn btn-info">Descargar</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">

                <h4>Detalles</h4>
                <hr>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Estado</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= $cotizacion->getFieldValue('Quote_Stage') ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Emisión</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= date("d-m-Y", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Cierre</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= date("d-m-Y", strtotime($cotizacion->getFieldValue("Valid_Till"))) ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Valor Asegurado</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label font-weight-bold">Deudor</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">
                            <?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?>
                        </label>
                    </div>
                </div>

                <?php if ($cotizacion->getFieldValue('Tipo') == "Auto") : ?>
                    <br>
                    <h4>Vehículo</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('Marca')->getLookupLabel() ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('Modelo')->getLookupLabel() ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Año de fabricación</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('A_o_Fabricaci_n') ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>
                        <div class="col-sm-8">
                            <label class="col-form-label">
                                <?= $cotizacion->getFieldValue('Tipo_Veh_culo') ?>
                            </label>
                        </div>
                    </div>
                <?php endif ?>

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
                            <?php
                            $planes = $cotizacion->getLineItems();
                            foreach ($planes as $plan) {
                                echo "<tr>";
                                echo "<td>" . $plan->getDescription() . "</td>";
                                echo "<td>RD$" . number_format($plan->getListPrice(), 2) . "</td>";
                                echo "<td>RD$" . number_format($plan->getTaxAmount(), 2) . "</td>";
                                echo "<td>RD$" . number_format($plan->getNetTotal(), 2) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>