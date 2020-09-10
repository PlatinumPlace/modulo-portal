<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">detalles</h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="<?= constant("url") . "polizas/adjuntar?id=" . $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Adjuntar</a>

            <a href="<?= constant("url") . "polizas/descargar?id=" . $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
        </div>
    </div>

</div>

<h4>Cliente</h4>
<hr>
<div class="row">

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $cliente->getFieldValue('First_Name') . " " . $cliente->getFieldValue('Last_Name') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $cliente->getFieldValue('RNC_C_dula') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Email</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $cliente->getFieldValue('Email') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Dirección</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $cliente->getFieldValue('Mailing_Street') ?>">
            </div>
        </div>

    </div>

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Tel. Residencia</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $cliente->getFieldValue('Phone') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Tel. Celular</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $cliente->getFieldValue('Mobile') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Tel. Trabajo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $cliente->getFieldValue('Tel_Trabajo') ?>">
            </div>
        </div>

    </div>

</div>

<br>
<h4>Vehículo</h4>
<hr>
<div class="row">

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $bien->getFieldValue('Marca') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $bien->getFieldValue('Modelo') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Año</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $bien->getFieldValue('A_o') ?>">
            </div>
        </div>

    </div>

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Chasis</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $bien->getFieldValue('Name') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Placa</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $bien->getFieldValue('Placa') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Color</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $bien->getFieldValue('Color') ?>">
            </div>
        </div>

    </div>

</div>

<br>
<h4>Plan</h4>
<hr>
<div class="row">

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Tipo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Deal_Name') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurada</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($detalles->getFieldValue('Valor_Asegurado'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Aseguradora</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Aseguradora')->getLookupLabel() ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Póliza</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('P_liza')->getLookupLabel() ?>">
            </div>
        </div>

    </div>

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Prima Neta</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($detalles->getFieldValue('Prima_Neta'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">ISC</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($detalles->getFieldValue('ISC'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Prima Total</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($detalles->getFieldValue('Prima_Total'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Documentos</label>

            <div class="col-sm-8">
                <?php foreach ($adjuntos as $adjunto) : ?>
                    <a href="<?= constant("url") . "polizas/detalles?id=" . $_GET["id"] . '&attachment_id=' . $adjunto->getId() ?>" class="form-control-plaintext">Descargar</a>
                <?php endforeach ?>
            </div>
        </div>

    </div>

</div>

<br>
<br>