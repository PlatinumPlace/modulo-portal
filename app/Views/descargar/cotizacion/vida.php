<?= $this->extend('app') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-2">
            <img src="<?= base_url("img/logo.png") ?>" width="100" height="100">
        </div>

        <div class="col-8">
            <h4 class="text-uppercase text-center">
                cotización <br>
                Plan <?= $cotizacion->getFieldValue('Plan') ?>
            </h4>
        </div>

        <div class="col-2">
            <b>Fecha</b> <br> <?= date('d-m-Y') ?><br>
            <b>No. de cotización</b> <br> <?= $cotizacion->getFieldValue('Quote_Number') ?><br>
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
                    <?= $cotizacion->getFieldValue('Nombre') . ' ' . $cotizacion->getFieldValue('Apellido') ?> <br>
                    <?= $cotizacion->getFieldValue('RNC_C_dula') ?> <br>
                    <?= $cotizacion->getFieldValue('Correo_electr_nico') ?> <br>
                    <?= $cotizacion->getFieldValue('Direcci_n') ?>
                </div>
            </div>
        </div>

        <div class="col-6 border">
            <div class="row">
                <div class="col-4">
                    <b>Tel. Residencia:</b><br>
                    <b>Tel. Celular:</b><br>
                    <b>Tel. Trabajo:</b> <br>
                    <b>Edad:</b> <br>
                </div>

                <div class="col-8">
                    <?= $cotizacion->getFieldValue('Tel_Celular') ?> <br>
                    <?= $cotizacion->getFieldValue('Tel_Residencia') ?> <br>
                    <?= $cotizacion->getFieldValue('Tel_Trabajo') ?> <br>
                    <?= $cotizacion->getFieldValue('Edad_deudor') ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <?php if ($cotizacion->getFieldValue('Edad_codeudor') != null) : ?>
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
                        <?= $cotizacion->getFieldValue('Nombre_codeudor') . ' ' . $cotizacion->getFieldValue('Apellido_codeudor') ?> <br>
                        <?= $cotizacion->getFieldValue('RNC_C_dula_codeudor') ?> <br>
                        <?= $cotizacion->getFieldValue('Correo_electr_nico_codeudor') ?> <br>
                        <?= $cotizacion->getFieldValue('Direcci_n_codeudor') ?>
                    </div>
                </div>
            </div>

            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Tel. Residencia:</b><br>
                        <b>Tel. Celular:</b><br>
                        <b>Tel. Trabajo:</b> <br>
                        <b>Edad:</b> <br>
                    </div>

                    <div class="col-8">
                        <?= $cotizacion->getFieldValue('Tel_Celular_codeudor') ?> <br>
                        <?= $cotizacion->getFieldValue('Tel_Residencia_codeudor') ?> <br>
                        <?= $cotizacion->getFieldValue('Tel_Trabajo_codeudor') ?> <br>
                        <?= $cotizacion->getFieldValue('Edad_codeudor') ?> <br>
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
                        <br>

                        <div class="card-body small">
                            <p>
                                <b>Suma Asegurada Vida</b> <br>

                                <?php if ($cotizacion->getFieldValue('Cuota')) : ?>
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
                        <br>

                        <div class="card-body small">
                            <p>
                                RD$<?= number_format($cotizacion->getFieldValue('Suma_asegurada'), 2) ?><br>

                                <?php if ($cotizacion->getFieldValue('Cuota')) : ?>
                                    RD$<?= number_format($cotizacion->getFieldValue('Cuota'), 2) ?><br>
                                <?php endif ?>
                            </p>
                        </div>
                    </div>
                </div>

                <?php foreach ($cotizacion->getLineItems() as $detalles) : ?>
                    <?php $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId()) ?>
                    <?php if ($detalles->getListPrice() > 0) : ?>
                        <div class="col-2">
                            <div class="card border-0">
                                <?php $imagen = $api->downloadPhoto("Vendors", $plan->getFieldValue('Vendor_Name')->getEntityId()) ?>
                                <img src="<?= base_url("img/$imagen") ?>" height="43" width="90" class="card-img-top">

                                <div class="card-body small">
                                    <p>
                                        <?php if ($cotizacion->getFieldValue('Cuota')) : ?>
                                            <br>
                                        <?php endif ?>

                                        <br> <br>
                                        RD$ <?= number_format($detalles->getListPrice(), 2) ?><br>
                                        RD$ <?= number_format($detalles->getTaxAmount(), 2) ?> <br>
                                        RD$ <?= number_format($detalles->getNetTotal(), 2) ?> <br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <div class="col-6 border">
            <h6 class="text-center">Requisitos del deudor</h6>
            <ul>
                <?php foreach ($cotizacion->getLineItems() as $detalles) : ?>
                    <?php
                    $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId());
                    $lista = $plan->getFieldValue('Requisitos_deudor');
                    ?>
                    <?php if ($detalles->getListPrice() > 0) : ?>
                        <li>
                            <b> <?= $plan->getFieldValue('Vendor_Name')->getLookupLabel() ?>:</b>

                            <?php foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito) : ?>
                                <?= $requisito ?>
                                <?php if ($requisito === end($lista)) : ?>
                                    .
                                <?php else : ?>
                                    ,
                                <?php endif ?>
                            <?php endforeach ?>
                        </li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        </div>

        <?php if (!empty($cotizacion->getFieldValue('Edad_codeudor'))) : ?>
            <div class="col-6 border">
                <h6 class="text-center">Requisitos del codeudor</h6>
                <ul>
                    <?php foreach ($cotizacion->getLineItems() as $detalles) : ?>
                        <?php
                        $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId());
                        $lista = $plan->getFieldValue('Requisitos_codeudor');
                        ?>
                        <?php if ($detalles->getListPrice() > 0) : ?>
                            <li>
                                <b> <?= $plan->getFieldValue('Vendor_Name')->getLookupLabel() ?>:</b>

                                <?php foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito) : ?>
                                    <?= $requisito ?>
                                    <?php if ($requisito === end($lista)) : ?>
                                        .
                                    <?php else : ?>
                                        ,
                                    <?php endif ?>
                                <?php endforeach ?>
                            </li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <?php if ($cotizacion->getFieldValue('Cuota')) : ?>
            <div class="col-6 border">
                <h6 class="text-center">Observaciones</h6>
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
            _______________________________ <br> Firma Cliente
        </p>
    </div>

    <div class="col-4">
        <p class="text-center">
            _______________________________ <br> Aseguradora Elegida
        </p>
    </div>

    <div class="col-4">
        <p class="text-center">
            _______________________________ <br> Fecha
        </p>
    </div>
</div>

<script>
    setTimeout(function() {
        window.print();
        window.location = "<?= site_url("detalles/cotizacion/" . $cotizacion->getEntityId()) ?>";
        document.title = "<?= "Cotización No. " . $cotizacion->getFieldValue('Quote_Number') ?>";
    }, 1000);
</script>

<?= $this->endSection() ?>