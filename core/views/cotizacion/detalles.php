<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        COTIZACION <br>
        SEGURO VEHICULO DE MOTOR <br>
        PLAN <?= strtoupper($trato['Plan']) ?>
    </h1>
    <a href="index.php?controller=CotizacionController&action=lista" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left"></i> Ir a la lista</a>
    <a href="lib/print/Cotizacion.php?id=<?= $id ?>" target="blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-print"></i> Imprimir</a>
    <?php if ($trato['Stage'] == "Cotizado") : ?>
        <a href="file\contratos\vehiculo.pdf" download class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i class="fas fa-file-download"></i> Descagar contratos</a>
        <a href="index.php?controller=CotizacionController&action=emitir_poliza&id=<?= $id ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-file-import"></i> Emitir poliza</a>
    <?php endif ?>
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
                <b>Cliente: </b> <?= $trato['Nombre_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Cedula/RNC: </b> <?= $trato['RNC_Cedula_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Direccion: </b> <?= $trato['Direcci_n_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Email: </b> <?= $trato['Email_del_asegurado'] ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
                <b>Tel. Residencia: </b> <?= $trato['Telefono_del_asegurado'] ?>
            </div>
            <div class="card-body">
                <b>Tel. Celular: </b> <?php  //$trato[''] 
                                        ?>
            </div>
            <div class="card-body">
                <b>Tel. Trabajo: </b> <?php  //$trato[''] 
                                        ?>
            </div>
            <div class="card-body">
                <b>Otro: </b> <?php  // $trato[''] 
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
                <b>Tipo: </b> <?= $trato['Tipo_de_vehiculo'] ?>
            </div>
            <div class="card-body">
                <b>Marca: </b> <?= $trato['Marca'] ?>
            </div>
            <div class="card-body">
                <b>Modelo: </b> <?= $trato['Modelo'] ?>
            </div>
            <div class="card-body">
                <b>Año: </b> <?= $trato['A_o_de_Fabricacion'] ?>
            </div>
            <div class="card-body">
                <b>Suma Asegurado: </b> RD$<?= number_format($trato['Valor_Asegurado'], 2) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
                <b>Chasis: </b> <?= $trato['Chasis'] ?>
            </div>
            <div class="card-body">
                <b>Placa: </b> <?= $trato['Placa'] ?>
            </div>
            <div class="card-body">
                <b>Color: </b> <?= $trato['Color'] ?>
            </div>
            <div class="card-body">
                <b>Condiciones: </b> <?= $retVal = ($trato['Es_nuevo'] == 1) ? "Nuevo" : "Usado"; ?>
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
    <?php foreach ($cotizacion as $key => $producto) : ?>
        <?php $detalles = $productos->getRecord($producto['id_product']) ?>
        <div class="col-lg-6">
            <div class="card mb-4 py-3 border-left-primary">
                <div class="card-body">
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
                        <div class="col-6 col-md-4">RD$<?= number_format($producto['Total'], 2) ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>