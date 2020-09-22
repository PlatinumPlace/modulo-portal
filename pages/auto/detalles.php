<?php
$api = new api;
$detalles = $api->detalles("Deals", $_GET["id"]);
if (empty($detalles)) {
    require_once "error.php";
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">No <?= $detalles->getFieldValue('No') ?></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">

            <?php if (date("Y-m-d", strtotime($detalles->getFieldValue("Closing_Date"))) > date('Y-m-d')) : ?>

                <?php if ($detalles->getFieldValue("Aseguradora") == null) : ?>
                    <a href="index.php?page=emitirAuto&id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Emitir</a>
                <?php else : ?>
                    <a href="index.php?page=adjuntar&id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Adjuntar</a>
                <?php endif ?>

                <?php if ($detalles->getFieldValue("Aseguradora") == null) : ?>
                    <a href="index.php?page=descargarCotizacionAuto&id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
                <?php else : ?>
                    <a href="index.php?page=descargarEmisionAuto&id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
                <?php endif ?>

            <?php endif ?>
        </div>
    </div>

</div>

<div class="row">
    <div class="mx-auto col-10" style="width: 200px;">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre del cliente</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Nombre') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plan</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Plan') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurado</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($detalles->getFieldValue('Suma_asegurada'), 2) ?>">
            </div>
        </div>

        <br>
        <h5>Vehí­culo</h5>
        <hr>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Marca')->getLookupLabel() ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Modelo')->getLookupLabel() ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Año</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('A_o_veh_culo') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Tipo_veh_culo') ?>">
            </div>
        </div>

        <br>
        <table class="table">

            <thead class="thead-dark">
                <tr>
                    <th scope="col">Aseguradora</th>
                    <th scope="col">Prima Neta</th>
                    <th scope="col">ISC</th>
                    <th scope="col">Prima Total</th>
                    <th scope="col">Requisitos</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $criteria = "Deal_Name:equals:" . $detalles->getEntityId();
                $cotizaciones = $api->listaFiltrada("Quotes", $criteria);
                foreach ($cotizaciones as $cotizacion) {
                    $adjuntos = $api->listaAdjuntos("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
                    $planes = $cotizacion->getLineItems();
                    foreach ($planes as $plan) {
                        echo "<tr>";
                        echo "<td>" . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";
                        echo "<td>RD$" . number_format($plan->getListPrice(), 2) . "</td>";
                        echo "<td>RD$" . number_format($plan->getTaxAmount(), 2) . "</td>";
                        echo "<td>RD$" . number_format($plan->getNetTotal(), 2) . "</td>";
                        foreach ($adjuntos as $adjunto) {
                            echo '<td><a href="index.php?page=detallesAuto&id=' . $_GET["id"] . '&attachment_id=' . $adjunto->getId() . '&contrato_id=' . $cotizacion->getFieldValue('Contrato')->getEntityId() . '" class="btn btn-link">Descargar</a></td>';
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>

        </table>
    </div>
</div>

<br><br>