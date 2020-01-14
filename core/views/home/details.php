<div class='container'>
    <h4 class="header">
        COTIZACIÓN PARA <br>
        SEGURO VEHICULO DE MOTOR <br>
        PLAN <?= strtoupper($oferta->getFieldValue('Plan')) ?> <?= strtoupper($oferta->getFieldValue('Tipo_de_poliza')) ?>
    </h4>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
            <li><a href="?page=list" class="btn-floating green tooltipped" data-tooltip="Lista de cotizaciónes"><i class="material-icons">list</i></a></li>
            <?php if ($contrato == null) : ?>
                <li><a href="?page=complete&id=<?= $oferta_id ?>" class="btn-floating blue tooltipped" data-tooltip="Completar cotización"><i class="material-icons">recent_actors</i></a></li>
            <?php endif ?>
            <?php if ($oferta->getFieldValue("Stage") == "En trámite" or $oferta->getFieldValue("Stage") == "Emitida") : ?>
                <li><a href="?page=download_2&id=<?= $oferta_id ?>" class="btn-floating yellow tooltipped" data-tooltip="Descargar póliza"><i class="material-icons">cloud_download</i></a></li>
            <?php elseif ($oferta->getFieldValue("Stage") == "Cotizando") : ?>
                <li><a href="?page=download_1&id=<?= $oferta_id ?>" class="btn-floating red tooltipped" data-tooltip="Descargar cotización"><i class="material-icons">file_download</i></a></li>
            <?php endif ?>
        </ul>
    </div>
</div>


<div class="row">
    <div class="col s12">
        <h5>DATOS DEL CLIENTE</h5>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <P>
                    <b>Cliente: </b> <?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?>
                    <br>
                    <b>Cedula/RNC: </b> <?= $oferta->getFieldValue('RNC_Cedula_del_asegurado') ?>
                    <br>
                    <b>Direccion: </b> <?= $oferta->getFieldValue('Direcci_n_del_asegurado') ?>
                    <br>
                    <b>Email: </b> <?= $oferta->getFieldValue('Email_del_asegurado') ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <P>
                    <b>Tel. Residencia: </b> <?= $oferta->getFieldValue('Telefono_del_asegurado') ?>
                    <br>
                    <b>Tel. Celular: </b> <?php  //$oferta[''] 
                                            ?>
                    <br>
                    <b>Tel. Trabajo: </b> <?php  //$oferta[''] 
                                            ?>
                    <br>
                    <b>Otro: </b> <?php  // $oferta[''] 
                                    ?>
                </P>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <h5>DATOS DEL VEHICULO</h5>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <P>
                    <b>Tipo: </b> <?= $oferta->getFieldValue('Tipo_de_vehiculo') ?>
                    <br>
                    <b>Marca: </b> <?= $oferta->getFieldValue('Marca') ?>
                    <br>
                    <b>Modelo: </b> <?= $oferta->getFieldValue('Modelo') ?>
                    <br>
                    <b>Año: </b> <?= $oferta->getFieldValue('A_o_de_Fabricacion') ?>
                    <br>
                    <b>Suma Asegurado: </b> RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <P>
                    <b>Chasis: </b> <?= $oferta->getFieldValue('Chasis') ?>
                    <br>
                    <b>Placa: </b> <?= $oferta->getFieldValue('Placa') ?>
                    <br>
                    <b>Color: </b> <?= $oferta->getFieldValue('Color') ?>
                    <br>
                    <b>Condiciones: </b> <?= $retVal = ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                </P>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <h5>COBERTURAS</h5>
    </div>
    <?php foreach ($cotizaciones as $cotizacion) : ?>
        <?php $planes = $cotizacion->getLineItems() ?>
        <?php foreach ($planes as $plan) : ?>
            <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <P>
                            <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                            <h5><?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?></h5>
                            <hr>
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
                                    <h6>DAÑOS PROPIOS</h6>
                                    <p>Riesgos comprensivos: <?= $cobertura->getFieldValue('Riesgos_comprensivos') ?>%</p>
                                    <p>Riesgos comprensivos (Deducible): <?= $cobertura->getFieldValue('Riesgos_comprensivos_Deducible') ?>%</p>
                                    <p>Rotura de Cristales (Deducible): <?= $cobertura->getFieldValue('Rotura_de_Cristales_Deducible') ?>%</p>
                                    <p>Colisión y vuelco: <?= $cobertura->getFieldValue('Colisi_n_y_vuelco') ?>%</p>
                                    <p>Incendio y robo: <?= $cobertura->getFieldValue('Incendio_y_robo') ?>%</p>
                                    <h6>RESPONSABILIDAD CIVIL</h6>
                                    <p>Daños Propiedad ajena: RD$<?= number_format($cobertura->getFieldValue('Da_os_Propiedad_ajena'), 2) ?></p>
                                    <p>Lesiones/Muerte 1 Pers: RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_Pers'), 2) ?></p>
                                    <p>Lesiones/Muerte más de 1 Pers: RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers'), 2) ?></p>
                                    <p>Lesiones/Muerte 1 pasajero: RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_pasajero'), 2) ?></p>
                                    <p>Lesiones/Muerte más de 1 pasajero: RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero'), 2) ?></p>
                                    <h6>RIESGOS CONDUCTOR: RD$<?= number_format($cobertura->getFieldValue('Riesgos_conductor'), 2) ?></h6>
                                    <h6>FIANZA JUDICIAL: <?= number_format($cobertura->getFieldValue('Fianza_judicial'), 2) ?></h6>
                                    <h6>COBERTURAS ADICIONALES</h6>
                                    <p>Asistencia vial: <?= $retVal = ($cobertura->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?></p>
                                    <p>Renta Vehículo: <?= $retVal = ($cobertura->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?></p>
                                    <p>Casa del conductor: <?= $retVal = ($cobertura->getFieldValue('Casa_del_Conductor') == 1) ? "Aplica" : "No Aplica"; ?></p>
                                <?php endif ?>
                                <?php break ?>
                            <?php endforeach ?>
                            <hr>
                            <div class="row">
                                <div class="col s4"><b>Prima Neta:</b> RD$<?= number_format($plan->getListPrice(), 2) ?></div>
                                <div class="col s4"><b>ISC:</b> RD$<?= number_format($plan->getTaxAmount(), 2) ?></div>
                                <div class="col s4"><b>Prima Total:</b> RD$<?= number_format($plan->getNetTotal(), 2) ?></div>
                            </div>
                        </P>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <?php break ?>
    <?php endforeach ?>
</div>