<?php
$vida = new vida;
$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$trato = $vida->getRecord("Deals", $id);

if (empty($trato)) {
    require_once "views/error.php";
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    &nbsp;

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="?pagina=emitirVida&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">Emitir</a>
            <a href="?pagina=descargarVida&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
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
            <label class="col-sm-4 col-form-label font-weight-bold">Codeudor</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= ($trato->getFieldValue('Edad_codeudor') != null) ? "Aplica" : "No aplica" ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurada</label>

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
            <label class="col-sm-4 col-form-label font-weight-bold">Documentos</label>

            <div class="col-sm-8">
                <?php
                $adjuntos = $vida->getAttachments("Contratos", $trato->getFieldValue('Contrato')->getEntityId());
                foreach ($adjuntos as $adjunto) {
                    echo '<a class="form-control-plaintext btn btn-link"   href="?pagina=detallesAuto&id=' . $id . '&contratoid=' . $trato->getFieldValue('Contrato')->getEntityId() . '&adjuntoid=' . $adjunto->getId() . '">Descargar</a>';
                }
                ?>
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

    </div>
</div>