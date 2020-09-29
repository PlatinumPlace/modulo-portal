<?php
$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$trato = detalles("Deals", $id);

if (empty($trato)) {
    require_once "views/portal/error.php";
    exit();
}

if ($trato->getFieldValue("P_liza") != null) {
    header("Location:" . constant("url") . "emisiones/detalles?tipo=vida&id=$id");
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">No <?= $trato->getFieldValue('No') ?></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="<?= constant("url") ?>cotizaciones/emitir?tipo=vida&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">
                Emitir
            </a>

            <a href="<?= constant("url") ?>cotizaciones/descargar?tipo=vida&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">
                Descargar
            </a>
        </div>
    </div>

</div>

<div class="row">
    <div class="mx-auto col-10" style="width: 200px;">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre del cliente</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Nombre') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plan</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Plan') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurado</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Suma_asegurada'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Edad del deudor</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Edad_deudor') ?>">
            </div>
        </div>

        <?php if ($trato->getFieldValue('Edad_codeudor') != null) : ?>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Edad del codeudor</label>

                <div class="col-sm-8">
                    <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Edad_codeudor') ?>">
                </div>
            </div>
        <?php endif ?>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plazo en meses</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Plazo') ?>">
            </div>
        </div>

        <?php if ($trato->getFieldValue('Cuota') != null) : ?>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Cuota Mensual</label>

                <div class="col-sm-8">
                    <input readonly type="text" class="form-control-plaintext" value="<?= number_format($trato->getFieldValue('Cuota'), 2) ?>">
                </div>
            </div>
        <?php endif ?>

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
                $criteria = "Deal_Name:equals:" . $trato->getEntityId();
                $cotizaciones = listaPorCriterio("Quotes", $criteria);
                foreach ($cotizaciones as $cotizacion) {
                    echo "<tr>";
                    echo "<td>" . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";

                    $planes = $cotizacion->getLineItems();
                    foreach ($planes as $plan) {
                        echo "<td>RD$" . number_format($plan->getListPrice(), 2) . "</td>";
                        echo "<td>RD$" . number_format($plan->getTaxAmount(), 2) . "</td>";
                        echo "<td>RD$" . number_format($plan->getNetTotal(), 2) . "</td>";
                    }

                    $adjuntos = listaAdjuntos("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
                    foreach ($adjuntos as $adjunto) {
                        echo '<td><a href="' . constant("url") . 'cotizaciones/detalles?tipo=auto&id=' . $id . '&contratoid=' . $cotizacion->getFieldValue('Contrato')->getEntityId() . '&adjuntoid=' . $adjunto->getId() . '" class="btn btn-link">Descargar</a></td>';
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>

        </table>
    </div>
</div>