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

        <div class="col-12 d-flex justify-content-center bg-primary text-white">
            <h6>VEHÍCULO</h6>
        </div>

        <div class="col-6 border">
            <div class="row">
                <div class="col-4">
                    <b>Marca:</b><br>
                    <b>Modelo:</b><br>
                    <b>Año:</b><br>
                    <b>Chasis:</b>
                </div>

                <div class="col-8">
                    <?= $bien->getFieldValue('Marca') ?> <br>
                    <?= $bien->getFieldValue('Modelo') ?> <br>
                    <?= $bien->getFieldValue('A_o') ?> <br>
                    <?= $bien->getFieldValue('Name') ?>
                </div>
            </div>
        </div>

        <div class="col-6 border">
            <div class="row">
                <div class="col-4">
                    <b>Tipo:</b><br>
                    <b>Placa:</b><br>
                    <b>Suma Asegurada:</b>
                </div>

                <div class="col-8">
                    <?= $bien->getFieldValue('Tipo') ?> <br>
                    <?= $bien->getFieldValue('Placa') ?> <br>
                    RD$<?= number_format($bien->getFieldValue('Suma_asegurada'), 2) ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <div class="col-12 d-flex justify-content-center bg-primary text-white">
            <h6>COBERTURAS</h6>
        </div>

        <div class="col-12 border">
            <div class="row">
                <div class="col-4">
                    <div class="card border-0">

                        <div class="card-body small">
                            <p>
                                <b>DAÑOS PROPIOS</b><br>
                                Riesgos comprensivos<br>
                                Riesgos comprensivos (Deducible)<br>
                                Rotura de Cristales (Deducible)<br>
                                Colisión y vuelco<br>
                                Incendio y robo
                            </p>

                            <p>
                                <b>RESPONSABILIDAD CIVIL</b><br>
                                Daños Propiedad ajena<br>
                                Lesiones/Muerte 1 Pers<br>
                                Lesiones/Muerte más de 1 Pers<br>
                                Lesiones/Muerte 1 pasajero<br>
                                Lesiones/Muerte más de 1 pasajero<br>
                            </p>

                            <p>
                                <b>RIESGOS CONDUCTOR</b> <br>
                                <b>FIANZA JUDICIAL</b>
                            </p>

                            <p>
                                <b>COBERTURAS ADICIONALES</b><br>
                                Asistencia vial<br>
                                Renta Vehí­culo<br>
                                Casa del conductor / <br> Centro del Automovilista
                            </p>

                            <br>

                            <p>
                                <b>PRIMA NETA</b> <br>
                                <b>ISC</b> <br>
                                <b>PRIMA TOTAL</b> <br>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-2">
                    &nbsp;
                </div>

                <div class="col-2">
                    <div class="card border-0">
                        <div class="card-body small">
                            <?php
                            $riesgo_compresivo = $bien->getFieldValue('Suma_asegurada') *
                                ($plan->getFieldValue('Riesgos_comprensivos') / 100);
                            $colision = $bien->getFieldValue('Suma_asegurada') *
                                ($plan->getFieldValue('Colisi_n_y_vuelco') / 100);
                            $incendio = $bien->getFieldValue('Suma_asegurada') *
                                ($plan->getFieldValue('Incendio_y_robo') / 100);
                            ?>

                            <p>
                                <br>
                                RD$<?= number_format($riesgo_compresivo) ?><br>
                                <?= $plan->getFieldValue('Riesgos_comprensivos_deducible') ?><br>
                                <?= $plan->getFieldValue('Rotura_de_cristales_deducible') ?> <br>
                                RD$<?= number_format($colision) ?> <br>
                                RD$<?= number_format($incendio) ?> <br>
                            </p>

                            <p>
                                <br>
                                RD$ <?= number_format($plan->getFieldValue('Da_os_propiedad_ajena')) ?> <br>
                                RD$ <?= number_format($plan->getFieldValue('Lesiones_muerte_1_pers')) ?> <br>
                                RD$ <?= number_format($plan->getFieldValue('Lesiones_muerte_m_s_1_pers')) ?> <br>
                                RD$<?= number_format($plan->getFieldValue('Lesiones_muerte_1_pas')) ?> <br>
                                RD$ <?= number_format($plan->getFieldValue('Lesiones_muerte_m_s_1_pas')) ?> <br>
                            </p>

                            <p>
                                RD$ <?= number_format($plan->getFieldValue('Riesgos_conductor')) ?> <br>
                                RD$ <?= number_format($plan->getFieldValue('Fianza_judicial')) ?> <br>
                            </p>

                            <br>

                            <p>
                                <?php if ($plan->getFieldValue('Asistencia_vial') == 1) : ?>
                                    Aplica <br>
                                <?php else : ?>
                                    No Aplica <br>
                                <?php endif ?>

                                <?php if ($plan->getFieldValue('Renta_veh_culo') == 1) : ?>
                                    Aplica <br>
                                <?php else : ?>
                                    No Aplica <br>
                                <?php endif ?>

                                <?php if ($plan->getFieldValue('En_caso_de_accidente') == 1) : ?>
                                    Aplica <br>
                                <?php else : ?>
                                    No Aplica <br>
                                <?php endif ?>
                            </p>

                            <br>
                            <br>

                            <p>
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

        <div class="col-6 border small">
            <br>
            <img src="<?= base_url("img/$imagen") ?>" width="150" height="60">
            <br><br>

            <div class="row">

                <div class="col-4">
                    <p>
                        <b>Póliza:</b><br>
                        <b>Marca:</b> <br>
                        <b>Modelo:</b> <br>
                        <b>Chasis:</b> <br>
                        <b>Placa:</b> <br>
                        <b>Año:</b> <br>
                        <b>Desde:</b> <br>
                        <b>Hasta:</b>
                    </p>
                </div>

                <div class="col-8">
                    <p>
                        <?= $bien->getFieldValue('P_liza') ?> <br>
                        <?= $bien->getFieldValue('Marca') ?> <br>
                        <?= $bien->getFieldValue('Modelo') ?> <br>
                        <?= $bien->getFieldValue('Name') ?> <br>
                        <?= $bien->getFieldValue('Placa') ?> <br>
                        <?= $bien->getFieldValue('A_o') ?> <br>
                        <?= $bien->getFieldValue('Vigencia_desde') ?> <br>
                        <?= $bien->getFieldValue('Vigencia_hasta') ?> <br>
                    </p>
                </div>

            </div>

        </div>

        <div class="col-6 border small">
            <div class="text-center font-weight-bold">EN CASO DE ACCIDENTE</div>
            <p>
                Realiza el levantamiento del acta policial y obténga la siguente cotizacionrmación:

                <ul>
                    <li>Nombre,dirección y teléfonos del conductor,los lesionados,del propietario y de los testigos.
                    </li>
                    <li>Número de placa y póliza del vehí­culo involucrado, y nombre de la aseguradora</li>
                </ul>

                <b>EN CASO DE ROBO:</b> Notifica de inmediato a la Policía y a la Aseguradora. <br>

                <div class="text-center"><b>RESERVE SU DERECHO</b></div>
            </p>

            <p>
                <b>Aseguradora:</b> Tel.<?= $plan->getFieldValue('Tel_aseguradora') ?>
            </p>

            <div class="row">
                <div class="col-md-6">
                    <?php if ($plan->getFieldValue('En_caso_de_accidente')) : ?>
                        <p>
                            <b><?= $plan->getFieldValue('En_caso_de_accidente') ?></b> <br>
                            Tel. Sto. Dgo <?= $plan->getFieldValue('Tel_santo_domingo') ?> <br>
                            Tel. Santiago <?= $plan->getFieldValue('Tel_santiago') ?>
                        </p>
                    <?php endif ?>
                </div>

                <div class="col-md-6">
                    <?php if ($plan->getFieldValue('Asistencia_vial') == 1) : ?>
                        <p>
                            <b>Asistencia vial 24 horas</b> <br>
                            Tel. <?= $plan->getFieldValue('Tel_asistencia_vial') ?>
                        </p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        window.print();
        window.location = "<?= site_url("detalles/poliza/" . $poliza->getEntityId()) ?>";
        document.title = "<?= "Poliza No." . $bien->getFieldValue('P_liza') ?>";
    }, 1000);
</script>

<?= $this->endSection() ?>