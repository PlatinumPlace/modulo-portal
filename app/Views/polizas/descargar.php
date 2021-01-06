<?= $this->extend('app') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-2">
            <img src="<?= base_url("img/$imagen") ?>" width="150" height="60">
        </div>

        <div class="col-8">
            <h4 class="text-uppercase text-center">
                <?php if ($poliza->getFieldValue('Type') == 'Auto') : ?>
                    resumen coberturas <br>
                    seguro vehí­culo de motor <br>
                <?php elseif ($poliza->getFieldValue('Type') == 'Vida') : ?>
                    Certificado <br>
                <?php endif ?>

                Plan <?= $bien->getFieldValue('Plan') ?>
            </h4>
        </div>

        <div class="col-2">
            <b>Fecha</b> <br> <?= date('d-m-Y') ?><br>
            <b>Poliza</b> <br> <?= $bien->getFieldValue('P_liza') ?><br>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <div class="col-12 d-flex justify-content-center bg-primary text-white">
            <h6>CLIENTE</h6>
        </div>

        <div class="col-6 border">
            <div class="row">
                <div class="col-4">
                    <b>Nombre:</b><br>
                    <b>RNC/Cédula:</b><br>
                    <b>Email:</b><br>
                    <b>Dirección:</b>
                </div>

                <div class="col-8">
                    <?= $bien->getFieldValue('Nombre') . ' ' . $bien->getFieldValue('Apellido') ?> <br>
                    <?= $bien->getFieldValue('RNC_C_dula') ?> <br>
                    <?= $bien->getFieldValue('Email') ?> <br>
                    <?= $bien->getFieldValue('Direcci_n') ?>
                </div>
            </div>
        </div>

        <div class="col-6 border">
            <div class="row">
                <div class="col-4">
                    <b>Tel. Residencia:</b><br>
                    <b>Tel. Celular:</b><br>
                    <b>Tel. Trabajo:</b>
                </div>

                <div class="col-8">
                    <?= $bien->getFieldValue('Tel_Celular') ?> <br>
                    <?= $bien->getFieldValue('Tel_Residencia') ?> <br>
                    <?= $bien->getFieldValue('Tel_Trabajo') ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <?php if ($cotizacion->getFieldValue('Type') == "Auto") : ?>
            <?= $this->include('auto/poliza') ?>
        <?php endif ?>

        <?php if ($cotizacion->getFieldValue('Type') == "Vida") : ?>
            <?= $this->include('vida/poliza') ?>
        <?php endif ?>
    </div>
</div>

<?php if ($cotizacion->getFieldValue('Type') == "Vida") : ?>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        &nbsp;
    </div>

    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        &nbsp;
    </div>

    <div class="row">
        <div class="col-4">
            <p class="text-center">
                _______________________________
                <br>
                Firma Cliente
            </p>
        </div>

        <div class="col-4">
            &nbsp;
        </div>

        <div class="col-4">
            <p class="text-center">
                _______________________________
                <br>
                Fecha
            </p>
        </div>
    </div>
<?php endif ?>

<script>
    document.title = "<?= "Poliza No." . $bien->getFieldValue('P_liza') ?>";

    setTimeout(function() {
        window.print();
        window.location = "<?= site_url("polizas/descargar/" . $poliza->getEntityId()) ?>";
    }, 1000);
</script>

<?= $this->endSection() ?>