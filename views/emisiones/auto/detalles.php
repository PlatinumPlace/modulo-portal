<?php
$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$trato = detalles("Deals", $id);

if (empty($trato)) {
    require_once "views/portal/error.php";
    exit();
}

if ($trato->getFieldValue("P_liza") == null) {
    header("Location:" . constant("url") . "cotizaciones/detalles?tipo=auto&id=$id");
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">Detalles</h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="<?= constant("url") ?>emisiones/adjuntar?id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">
                Adjuntar
            </a>

            <a href="<?= constant("url") ?>emisiones/descargar?tipo=auto&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">
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
            <label class="col-sm-4 col-form-label font-weight-bold">Aseguradora</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $trato->getFieldValue('Aseguradora')->getLookupLabel() ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Prima neta</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Prima_neta'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">ISC</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('ISC'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Prima total</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($trato->getFieldValue('Prima_total'), 2) ?>">
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

    </div>
</div>

<br><br>