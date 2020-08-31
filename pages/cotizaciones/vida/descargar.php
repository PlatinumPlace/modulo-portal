<style>
    @media print {
        .pie_pagina {
            position: fixed;
            margin: auto;
            height: 100px;
            width: 100%;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
        }
    }
</style>

<div class="container">
    <div class="row">

        <div class="col-2">
            <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
                <img src="<?= constant("url") ?>public/icons/logo.png" width="100" height="100">
            <?php else : ?>
                <img height="100" width="100" src="<?= constant("url") . $imagen_aseguradora ?>">
            <?php endif ?>
        </div>

        <div class="col-8">
            <h4 class="text-uppercase text-center">
                cotización <br> seguro <?= $cotizacion->getFieldValue('Subject') ?>
            </h4>
        </div>

        <div class="col-2">
            <b>Fecha</b> <br> <?= $cotizacion->getFieldValue('Fecha_emisi_n') ?> <br>
            <b>Cotización No.</b> <br> <?= $cotizacion->getFieldValue('Quote_Number') ?> <br>
        </div>

        <div class="col-12 d-flex justify-content-center bg-primary text-white">
            <h6>CLIENTE</h6>
        </div>

        <div class="col-6 border">
            <div class="row">

                <div class="col-4">
                    <b>Nombre:</b><br> <b>RNC/Cédula:</b><br> <b>Email:</b><br> <b>Dirección:</b>
                </div>

                <div class="col-8">
                    <?php
                    echo $cotizacion->getFieldValue('Nombre');
                    echo "<br>";
                    echo $cotizacion->getFieldValue('RNC_C_dula');
                    ?>
                </div>

            </div>
        </div>

        <div class="col-6 border">
            <div class="row">

                <div class="col-4">
                    <b>Tel. Residencia:</b><br> <b>Tel. Celular:</b><br> <b>Tel.
                        Trabajo:</b>
                </div>

                <div class="col-8">&nbsp;</div>

            </div>
        </div>

        <div class="col-12 d-flex justify-content-center bg-primary text-white">
            <h6>COBERTURAS</h6>
        </div>

        <div class="col-12 border">
            <div class="row">

                <div class="col-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title">
                                Suma Asegurada:<br>
                                RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>
                            </h5>

                            <br>
                            <hr>

                            <p class="card-text">
                                Prima Neta<br>
                                ISC<br>
                                Prima Mensual
                            </p>
                        </div>
                    </div>
                </div>

                <?php $planes = $cotizacion->getLineItems() ?>
                <?php foreach ($planes as $plan) : ?>
                    <?php if ($plan->getNetTotal() > 0) : ?>
                        <?php
                        $planes_detalles = detalles_registro("Products", $plan->getProduct()->getEntityId());
                        $imagen_aseguradora = obtener_imagen_registro("Vendors", $planes_detalles->getFieldValue('Vendor_Name')->getEntityId());
                        ?>
                        
                        <?php if ($cotizacion->getFieldValue("Deal_Name") != null) : ?>
                            <div class="col-2">&nbsp;</div>
                        <?php endif ?>

                        <div class="col-2">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="card-title">
                                        <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
                                            <img height="50" width="120" src="<?= constant("url") . $imagen_aseguradora ?>">
                                        <?php else : ?>
                                            &nbsp; <br><br>
                                        <?php endif ?>
                                    </div>

                                    <br>
                                    <hr>

                                    <p class="card-text">
                                        RD$<?= number_format($plan->getListPrice(), 2) ?><br>
                                        RD$<?= number_format($plan->getTaxAmount(), 2) ?><br>
                                        RD$<?= number_format($plan->getNetTotal(), 2) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>

    </div>

    <div class="row pie_pagina">
        <div class="col-3">
            <p class="text-center">
                _______________________________
                <br>
                Firma Cliente
            </p>
        </div>
        <div class="col-6">
            <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
                <p class="text-center">
                    _______________________________
                    <br>
                    Aseguradora Elegida
                </p>
            <?php else : ?>
                &nbsp;
            <?php endif ?>
        </div>
        <div class="col-3">
            <p class="text-center">
                _______________________________
                <br>
                Fecha
            </p>
        </div>
    </div>

</div>

<script>
    var time = 500;
    var url = "<?= constant("url") ?>";
    var titulo = "Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?>";
    var id = "<?= $id ?>";
    setTimeout(function() {
        window.document.title = titulo;
        window.print();
        window.location = url + "?page=detalles&id=" + id;
    }, time);
</script>

</body>

</html>