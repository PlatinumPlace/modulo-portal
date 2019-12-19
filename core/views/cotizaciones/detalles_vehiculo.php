<h2>
    COTIZACION <br>
    SEGURO VEHICULO DE MOTOR <br>
    PLAN <?= strtoupper($deal['Plan']) ?>
</h2>
<div class="menu">
<a href="lib/print/Cotizacion.php?id=<?= $id ?>" target="blank" class="btn btn-link">Imprimir</a>
|
<a href="file\contratos\vehiculo.pdf" download class="btn btn-link">Descagar contratos</a>
|
<a href="index.php?controller=HomeController&action=emitir_cotizacion&id=<?=$id?>" class="btn btn-link">Emitir poliza</a>
</div>
<hr>
<center>
    DATOS DEL CLIENTE
</center>
<hr>
<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
                <b>Cliente: </b> <?= $deal['Nombre_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Cedula/RNC: </b> <?= $deal['RNC_Cedula_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Direccion: </b> <?= $deal['Direcci_n_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Email: </b> <?= $deal['Email_del_asegurado'] ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
                <b>Tel. Residencia: </b> <?= $deal['Telefono_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Tel. Celular: </b> <?php  //$deal[''] 
                                        ?>
            </div>
            <div class="card-body">
                <b>Tel. Trabajo: </b> <?php  //$deal[''] 
                                        ?>
            </div>
            <div class="card-body">
                <b>Otro: </b> <?php  // $deal[''] 
                                ?>
            </div>
        </div>
    </div>
</div>
<hr>
<center>
    DATOS DEL VEHICULO
</center>
<hr>
<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
                <b>Tipo: </b> <?= $deal['Tipo_de_vehiculo'] ?>
            </div>
            <div class="card-body">
                <b>Marca: </b> <?= $deal['Marca'] ?>
            </div>
            <div class="card-body">
                <b>Modelo: </b> <?= $deal['Modelo'] ?>
            </div>
            <div class="card-body">
                <b>Año: </b> <?= $deal['A_o_de_Fabricacion'] ?>
            </div>
            <div class="card-body">
                <b>Suma Asegurado: </b> RD$<?= number_format($deal['Valor_Asegurado'], 2) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
                <b>Chasis: </b> <?= $deal['Chasis'] ?>
            </div>
            <div class="card-body">
                <b>Placa: </b> <?= $deal['Placa'] ?>
            </div>
            <div class="card-body">
                <b>Color: </b> <?= $deal['Color'] ?>
            </div>
            <div class="card-body">
                <b>Condiciones: </b> <?= $retVal = ($deal['Es_nuevo'] == 1) ? "Nuevo" : "Usado"; ?>
            </div>
        </div>
    </div>
</div>
<hr>
<center>
    COBERTURAS
</center>
<hr>
<br>
<div class="row">
    <?php foreach ($quote as $key => $product) : ?>
        <?php $detail = $productAPI->getRecord($product['id_product']) ?>
        <div class="col-lg-6">
            <div class="card mb-4 py-3 border-left-primary">
                <div class="card-body">
                    <h5 class="text-gray-900"><?= $detail['Vendor_Name'] ?></h5>
                    <hr>
                    <h6 class="p-3 m-0">DAÑOS PROPIOS</h6>
                    <p class="text-gray-900 p-3 m-0">Riesgos comprensivos: <?= $detail['Riesgos_comprensivos'] ?>%</p>
                    <p class="text-gray-900 p-3 m-0">Riesgos comprensivos (Deducible): <?= $detail['Riesgos_comprensivos_Deducible'] ?>%</p>
                    <p class="text-gray-900 p-3 m-0">Rotura de Cristales (Deducible): <?= $detail['Rotura_de_Cristales_Deducible'] ?>%</p>
                    <p class="text-gray-900 p-3 m-0">Colisión y vuelco: <?= $detail['Colisi_n_y_vuelco'] ?>%</p>
                    <p class="text-gray-900 p-3 m-0">Incendio y robo: <?= $detail['Incendio_y_robo'] ?>%</p>
                    <h6 class="p-3 m-0">RESPONSABILIDAD CIVIL</h6>
                    <p class="text-gray-900 p-3 m-0">Daños Propiedad ajena: RD$<?= number_format($detail['Da_os_Propiedad_ajena'], 2) ?></p>
                    <p class="text-gray-900 p-3 m-0">Lesiones/Muerte 1 Pers: RD$<?= number_format($detail['Lesiones_Muerte_1_Pers'], 2) ?></p>
                    <p class="text-gray-900 p-3 m-0">Lesiones/Muerte más de 1 Pers: RD$<?= number_format($detail['Lesiones_Muerte_m_s_de_1_Pers'], 2) ?></p>
                    <p class="text-gray-900 p-3 m-0">Lesiones/Muerte 1 pasajero: RD$<?= number_format($detail['Lesiones_Muerte_1_pasajero'], 2) ?></p>
                    <p class="text-gray-900 p-3 m-0">Lesiones/Muerte más de 1 pasajero: RD$<?= number_format($detail['Lesiones_Muerte_m_s_de_1_pasajero'], 2) ?></p>
                    <h6 class="p-3 m-0">RIESGOS CONDUCTOR: </h6>
                    <p class="text-gray-900 p-3 m-0">RD$<?= number_format($detail['Riesgos_conductor'], 2) ?></p>
                    <h6 class="p-3 m-0">FIANZA JUDICIAL: </h6>
                    <p class="text-gray-900 p-3 m-0">RD$<?= number_format($detail['Fianza_judicial'], 2) ?></p>
                    <h6 class="p-3 m-0">COBERTURAS ADICIONALES</h6>
                    <p class="text-gray-900 p-3 m-0">Asistencia vial: <?= $retVal = ($detail['Asistencia_vial'] == 1) ? "Aplica" : "No Aplica"; ?></p>
                    <p class="text-gray-900 p-3 m-0">Renta Vehículo: <?= $retVal = ($detail['Asistencia_vial'] == 1) ? "Aplica" : "No Aplica"; ?></p>
                    <p class="text-gray-900 p-3 m-0">Reporte de accidente: <?= $detail['Reporte_de_accidente'] ?></p>
                    <hr>
                    <div class="row no-gutters">
                        <div class="col-sm-6 col-md-8">Prima Neta:</div>
                        <div class="col-6 col-md-4">RD$<?= number_format($product['ListPrice'], 2) ?></div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-sm-6 col-md-8">ISC:</div>
                        <div class="col-6 col-md-4">RD$<?= number_format($product['Tax'], 2) ?></div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-sm-6 col-md-8">Prima Total:</div>
                        <div class="col-6 col-md-4">RD$<?= number_format($product['Total'], 2) ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>