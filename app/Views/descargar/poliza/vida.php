<?= $this->extend('app') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-2">
            <img src="<?= base_url("img/$imagen") ?>" width="150" height="60">
        </div>

        <div class="col-8">
            <h4 class="text-uppercase text-center">
                Certificado <br>
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
            <h6>DEUDOR</h6>
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
                    <b>Tel. Trabajo:</b> <br>
                    <b>Fecha de nacimiento:</b> <br>
                </div>

                <div class="col-8">
                    <?= $bien->getFieldValue('Tel_Celular') ?> <br>
                    <?= $bien->getFieldValue('Tel_Residencia') ?> <br>
                    <?= $bien->getFieldValue('Tel_Trabajo') ?> <br>
                    <?= $bien->getFieldValue('Fecha_de_nacimiento') ?> <br>
                </div>
            </div>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <?php if ($bien->getFieldValue('Nombre_codeudor') != null) : ?>
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>CODEUDOR</h6>
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
                        <?= $bien->getFieldValue('Nombre_codeudor') . ' ' . $bien->getFieldValue('Apellido_codeudor') ?> <br>
                        <?= $bien->getFieldValue('RNC_C_dula_codeudor') ?> <br>
                        <?= $bien->getFieldValue('Correo_electr_nico_codeudor') ?> <br>
                        <?= $bien->getFieldValue('Direcci_n_codeudor') ?>
                    </div>
                </div>
            </div>

            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Tel. Residencia:</b><br>
                        <b>Tel. Celular:</b><br>
                        <b>Tel. Trabajo:</b> <br>
                        <b>Fecha de nacimiento:</b> <br>
                    </div>

                    <div class="col-8">
                        <?= $bien->getFieldValue('Tel_Celular_codeudor') ?> <br>
                        <?= $bien->getFieldValue('Tel_Residencia_codeudor') ?> <br>
                        <?= $bien->getFieldValue('Tel_Trabajo_codeudor') ?> <br>
                        <?= $bien->getFieldValue('Fecha_de_nacimiento_codeudor') ?> <br>
                    </div>
                </div>
            </div>

            <div class="col-12">
                &nbsp;
            </div>
        <?php endif ?>

        <div class="col-12 d-flex justify-content-center bg-primary text-white">
            <h6>COBERTURAS/PRIMA MENSUAL</h6>
        </div>

        <div class="col-12 border">
            <div class="row">
                <div class="col-3">
                    <div class="card border-0">
                        <div class="card-body small">
                            <p>
                                <b>Suma Asegurada Vida</b> <br>

                                <?php if ($bien->getFieldValue('Cuota')) : ?>
                                    <b>Cuota Mensual de Prestamo</b><br>
                                <?php endif ?>

                                <br> <br>
                                <b>Prima Neta</b> <br>
                                <b>ISC</b> <br>
                                <b>Prima Total</b>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card border-0">
                        <div class="card-body small">
                            <p>
                                RD$<?= number_format($bien->getFieldValue('Suma_asegurada'), 2) ?><br>

                                <?php if ($bien->getFieldValue('Cuota')) : ?>
                                    RD$<?= number_format($bien->getFieldValue('Cuota'), 2) ?><br>
                                <?php endif ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-2">
                    <div class="card border-0">
                        <div class="card-body small">
                            <p>
                                <?php if ($bien->getFieldValue('Cuota')) : ?>
                                    <br>
                                <?php endif ?>

                                <br> <br><br>
                                RD$ <?= number_format($poliza->getFieldValue('Prima_neta'), 2) ?><br>
                                RD$ <?= number_format($poliza->getFieldValue('ISC'), 2) ?> <br>
                                RD$ <?= number_format($poliza->getFieldValue('Prima_total'), 2) ?> <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <div class="col-6 border">
            <h6 class="text-center"><b>Requisitos del deudor</b></h6>
            <ul>
                <?php $lista = $plan->getFieldValue('Requisitos_deudor'); ?>
                <?php foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito) : ?>
                    <li><?= $requisito ?></li>
                <?php endforeach ?>
                </li>
            </ul>
        </div>

        <?php if (!empty($bien->getFieldValue('Nombre_codeudor'))) : ?>
            <div class="col-6 border">
                <h6 class="text-center"><b>Requisitos del codeudor</b></h6>
                <ul>
                    <?php $lista = $plan->getFieldValue('Requisitos_codeudor'); ?>
                    <?php foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito) : ?>
                        <li><?= $requisito ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <?php if ($bien->getFieldValue('Cuota')) : ?>
            <div class="col-6 border">
                <h6 class="text-center"><b>Observaciones</b></h6>
                <ul>
                    <li>Pago de desempleo hasta por 6 meses.</li>
                </ul>
            </div>
        <?php endif ?>

    </div>
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

<script>
    setTimeout(function() {
        window.print();
        window.location = "<?= site_url("detalles/poliza/" . $poliza->getEntityId()) ?>"; 
        document.title = "<?= "Póliza No." . $bien->getFieldValue('P_liza') ?>";
    }, 1000);
</script>

<?= $this->endSection() ?>