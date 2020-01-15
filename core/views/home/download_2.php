<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title>Póliza provisional</title>

    <!-- CSS  -->
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="all" />
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all" />
</head>

<body>


    <main>
        <div class="row">
            <div class="col s12 m7">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <?php foreach ($cotizaciones as $cotizacion) : ?>
                                <?php $planes = $cotizacion->getLineItems() ?>
                                <?php foreach ($planes as $plan) : ?>
                                    <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                                    <?php
                                    $criterio = "Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
                                    $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
                                    ?>
                                    <?php foreach ($coberturas as $cobertura) : ?>
                                        <?php if (
                                            $cobertura->getFieldValue('Aseguradora')->getEntityId() == $plan_detalles->getFieldValue('Vendor_Name')->getEntityId()
                                            and
                                            $cobertura->getFieldValue('Socio_IT')->getEntityId() == $oferta->getFieldValue('Account_Name')->getEntityId()
                                        ) : ?>
                                            <div class="col s6">
                                                <h4><?= $oferta->getFieldValue('Aseguradora')->getLookupLabel() ?></h4>
                                                <P>
                                                    <b>PÓLIZA </b><?= $cotizacion->getFieldValue('Poliza')->getLookupLabel() ?><br>
                                                    <b>MARCA </b><?= $oferta->getFieldValue('Marca') ?><br>
                                                    <b>MODELO </b><?= $oferta->getFieldValue('Modelo') ?><br>
                                                    <b>AÑO </b><?= $oferta->getFieldValue('A_o_de_Fabricacion') ?><br>
                                                    <b>CHASIS </b><?= $oferta->getFieldValue('Chasis') ?><br>
                                                    <b>PLACA </b><?= $oferta->getFieldValue('Placa') ?><br>
                                                    <b>VIGENTE HASTA </b><?= $cotizacion->getFieldValue('Valid_Till') ?>
                                                </P>
                                            </div>
                                            <div class="col s6">
                                            <FONT SIZE=2>
                                                <P>
                                                    <b>RECOMENDACIONES EN CASO DE ACCIDENTE</b><br>
                                                    <ul>
                                                        <li>EN CASO DE EXISTIR LESIONADOS ATENDER AL HERIDO.</li>
                                                        <li>NO ACEPTAR RESPONSABILIDAD EN EL MOMENTO DEL ACCIDENTE.</li>
                                                        <li>EN CASO DE ROBO NOTIFIQUE INMEDIATAMENTE A LA POLICIA Y ASEGURADORA.</li>
                                                    </ul>
                                                    <?php if ($cobertura->getFieldValue('Casa_del_Conductor') == 1) : ?>
                                                        <b>CENTRO DE ASISTENCIA AL AUTOMOVILISTA</b><br>
                                                        SANTO DOMINGO: (809) 565-8222 <br>
                                                        SANTIAGO: (809) 583-6222<br>
                                                    <?php endif ?>
                                                    <?php if ($cobertura->getFieldValue('Asistencia_vial') == 1) : ?>
                                                        <b>ASISTENCIA VIAL 24 HORAS</b><br>
                                                        (829) 378-8888<br>
                                                    <?php endif ?>
                                                </P>
                                            </FONT>
                                            </div>
                                        <?php endif ?>
                                        <?php break ?>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                                <?php break ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <input type="text" value="<?= $_GET['id'] ?>" id="id" hidden>
    <!--  Scripts-->
    <script>
        var time = 500;
        var id = document.getElementById('id').value;
        setTimeout(function() {
            window.print();
            window.location = "?page=details&id=" + id;
        }, time);
    </script>
</body>

</html>