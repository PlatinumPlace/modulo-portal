<div class='container'>

    <h4 class="header">
        COTIZACION PARA <br>
        SEGURO VEHICULO DE MOTOR <br>
        PLAN <?= strtoupper($oferta['Plan']) ?>
    </h4>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li><a class="btn-floating red tooltipped" data-tooltip="Lista de cotizaciónes"><i class="material-icons">list</i></a></li>
            <li><a class="btn-floating yellow darken-1 tooltipped" data-tooltip="Subir documentos"><i class="material-icons">backup</i></a></li>
            <li><a class="btn-floating green tooltipped" data-tooltip="Descargar cotización"><i class="material-icons">cloud_download</i></a></li>
            <?php if ($oferta['Stage'] == "Cotizando") : ?>
                <li><a class="btn-floating grey tooltipped" data-tooltip="Descagar contratos"><i class="material-icons">cloud_download</i></a></li>
                <li><a class="btn-floating blue tooltipped" data-tooltip="Emitir póliza"><i class="material-icons">recent_actors</i></a></li>
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
                    <b>Cliente: </b> <?= $oferta['Nombre_del_asegurado'] ?>
                    <br>
                    <b>Cedula/RNC: </b> <?= $oferta['RNC_Cedula_del_asegurado'] ?>
                    <br>
                    <b>Direccion: </b> <?= $oferta['Direcci_n_del_asegurado'] ?>
                    <br>
                    <b>Email: </b> <?= $oferta['Email_del_asegurado'] ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <P>
                    <b>Tel. Residencia: </b> <?= $oferta['Telefono_del_asegurado'] ?>
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
                    <b>Tipo: </b> <?= $oferta['Tipo_de_vehiculo'] ?>
                    <br>
                    <b>Marca: </b> <?= $oferta['Marca'] ?>
                    <br>
                    <b>Modelo: </b> <?= $oferta['Modelo'] ?>
                    <br>
                    <b>Año: </b> <?= $oferta['A_o_de_Fabricacion'] ?>
                    <br>
                    <b>Suma Asegurado: </b> RD$<?= number_format($oferta['Valor_Asegurado'], 2) ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <P>
                    <b>Chasis: </b> <?= $oferta['Chasis'] ?>
                    <br>
                    <b>Placa: </b> <?= $oferta['Placa'] ?>
                    <br>
                    <b>Color: </b> <?= $oferta['Color'] ?>
                    <br>
                    <b>Condiciones: </b> <?= $retVal = ($oferta['Es_nuevo'] == 1) ? "Nuevo" : "Usado"; ?>
                </P>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <h5>COBERTURAS</h5>
    </div>
    <?php foreach ($cotizacion as $key => $value) : ?>
        <?php

        foreach ($value["Product_details"] as $key2 => $value2) {
            var_dump($value2["Product_id"]);
        }

        //echo $cotizacion[0]['Product_details'][0]['Product_id'];
        //$detalles = $productos->detalles($value["Product_details"][0]['Product_id']);



        ?>
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <P>
                        <h5 class="text-gray-900"><?= $detalles['Vendor_Name'] ?></h5>
                        <hr>
                        <h6 class="p-3 m-0">DAÑOS PROPIOS</h6>
                        <p class="text-gray-900 p-3 m-0">Riesgos comprensivos: <?= $detalles['Riesgos_comprensivos'] ?>%</p>
                        <p class="text-gray-900 p-3 m-0">Riesgos comprensivos (Deducible): <?= $detalles['Riesgos_comprensivos_Deducible'] ?>%</p>
                        <p class="text-gray-900 p-3 m-0">Rotura de Cristales (Deducible): <?= $detalles['Rotura_de_Cristales_Deducible'] ?>%</p>
                        <p class="text-gray-900 p-3 m-0">Colisión y vuelco: <?= $detalles['Colisi_n_y_vuelco'] ?>%</p>
                        <p class="text-gray-900 p-3 m-0">Incendio y robo: <?= $detalles['Incendio_y_robo'] ?>%</p>
                        <h6 class="p-3 m-0">RESPONSABILIDAD CIVIL</h6>
                        <p class="text-gray-900 p-3 m-0">Daños Propiedad ajena: RD$<?= number_format($detalles['Da_os_Propiedad_ajena'], 2) ?></p>
                        <p class="text-gray-900 p-3 m-0">Lesiones/Muerte 1 Pers: RD$<?= number_format($detalles['Lesiones_Muerte_1_Pers'], 2) ?></p>
                        <p class="text-gray-900 p-3 m-0">Lesiones/Muerte más de 1 Pers: RD$<?= number_format($detalles['Lesiones_Muerte_m_s_de_1_Pers'], 2) ?></p>
                        <p class="text-gray-900 p-3 m-0">Lesiones/Muerte 1 pasajero: RD$<?= number_format($detalles['Lesiones_Muerte_1_pasajero'], 2) ?></p>
                        <p class="text-gray-900 p-3 m-0">Lesiones/Muerte más de 1 pasajero: RD$<?= number_format($detalles['Lesiones_Muerte_m_s_de_1_pasajero'], 2) ?></p>
                        <h6 class="p-3 m-0">RIESGOS CONDUCTOR: </h6>
                        <p class="text-gray-900 p-3 m-0">RD$<?= number_format($detalles['Riesgos_conductor'], 2) ?></p>
                        <h6 class="p-3 m-0">FIANZA JUDICIAL: </h6>
                        <p class="text-gray-900 p-3 m-0">RD$<?= number_format($detalles['Fianza_judicial'], 2) ?></p>
                        <h6 class="p-3 m-0">COBERTURAS ADICIONALES</h6>
                        <p class="text-gray-900 p-3 m-0">Asistencia vial: <?= $retVal = ($detalles['Asistencia_vial'] == 1) ? "Aplica" : "No Aplica"; ?></p>
                        <p class="text-gray-900 p-3 m-0">Renta Vehículo: <?= $retVal = ($detalles['Asistencia_vial'] == 1) ? "Aplica" : "No Aplica"; ?></p>
                        <p class="text-gray-900 p-3 m-0">Reporte de accidente: <?= $detalles['Reporte_de_accidente'] ?></p>
                        <hr>
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-md-8">Prima Neta:</div>
                            <div class="col-6 col-md-4">RD$<?= number_format($producto['ListPrice'], 2) ?></div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-md-8">ISC:</div>
                            <div class="col-6 col-md-4">RD$<?= number_format($producto['Tax'], 2) ?></div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-md-8">Prima Total:</div>
                            RD$<?= number_format($producto['Total'], 2) ?>
                    </P>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>