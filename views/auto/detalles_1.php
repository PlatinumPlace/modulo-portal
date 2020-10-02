<?php
$auto = new auto;
$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$trato = $auto->getRecord("Deals", $id);

if (empty($trato)) {
    require_once "views/error.php";
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    &nbsp;

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="?pagina=emitirAuto&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">Emitir</a>
            <a href="?pagina=descargarAuto_1&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
        </div>
    </div>

</div>

<div class="row">
    <div class="mx-auto col-10" style="width: 200px;">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre del cliente</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Deal_Name') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plan</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Plan') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurada</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Suma_asegurada'), 2) ?>">
            </div>
        </div>

        <br>
        <h5>Vehí­culo</h5>
        <hr>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Marca') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Modelo') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Año</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('A_o_veh_culo') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Tipo_veh_culo') ?>">
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
                    <th scope="col">Documentos</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $criteria = "Deal_Name:equals:" . $trato->getEntityId();
                $cotizaciones = $auto->searchRecordsByCriteria("Quotes", $criteria);
                foreach ($cotizaciones as $cotizacion) {
                    echo "<tr>";
                    echo "<td>" . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";

                    $planes = $cotizacion->getLineItems();
                    foreach ($planes as $plan) {
                        echo "<td>RD$" . number_format($plan->getListPrice(), 2) . "</td>";
                        echo "<td>RD$" . number_format($plan->getTaxAmount(), 2) . "</td>";
                        echo "<td>RD$" . number_format($plan->getNetTotal(), 2) . "</td>";
                    }

                    $adjuntos = $auto->getAttachments("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
                    foreach ($adjuntos as $adjunto) {
                        echo '<td><a href="?pagina=detallesAuto&id=' . $id . '&contratoid=' . $cotizacion->getFieldValue('Contrato')->getEntityId() . '&adjuntoid=' . $adjunto->getId() . '" class="btn btn-link">Descargar</a></td>';
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>

        </table>
    </div>
</div>