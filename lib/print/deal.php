<?php

include "../../core/models/dealModel.php";
include "../../core/models/quoteModel.php";
include "../../core/models/productModel.php";
include "../../zohoapi/config.php";

$id = $_GET['id'];
$dealModel = new dealModel;
$deal = $dealModel->getRecord($id);
$quote = new quoteModel;
$products = $quote->getRecordByCriteria($id);
$productsDetail = new productModel;
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title></title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                &nbsp;
            </div>
            <div class="col-6">
                <h4>
                    COTIZACION <br>
                    SEGURO VEHICULO DE MOTOR <br>
                    PLAN <?= strtoupper($deal['Plan']) ?>
                </h4>
            </div>
            <div class="col">
                &nbsp;
            </div>
        </div>
        <br>
        <hr>
        <center>
            <h5>DATOS DEL CLIENTE</h5>
        </center>
        <hr>
        <div class="row">
            <div class="col"><b>Cliente: </b> <?= $deal['Nombre_del_asegurado'] ?></div>
            <div class="col"><b>Cedula/RNC: </b> <?= $deal['RNC_Cedula_del_asegurado'] ?></div>
            <div class="w-100"></div>
            <div class="col"> <b>Tel. Residencia: </b> <?= $deal['Telefono_del_asegurado'] ?></div>
            <div class="col"> <b>Tel. Celular: </b> <?= $deal['Telefono_del_asegurado'] ?></div>
        </div>
        <div class="row">
            <div class="col"><b>Direccion: </b> <?= $deal['Direcci_n_del_asegurado'] ?></div>
            <div class="col"><b>Email: </b> <?= $deal['Email_del_asegurado'] ?></div>
            <div class="w-100"></div>
            <div class="col"> <b>Tel. Trabajo: </b> <?= $deal['Telefono_del_asegurado'] ?></div>
            <div class="col"> <b>Otro: </b> <?= $deal['Telefono_del_asegurado'] ?></div>
        </div>
        <br>
        <hr>
        <center>
            <h5>DATOS DEL VEHICULO</h5>
        </center>
        <hr>
        <div class="row">
            <div class="col"><b>Tipo: </b> <?= $deal['Tipo_de_vehiculo'] ?></div>
            <div class="col"><b>Chasis: </b> <?= $deal['Chasis'] ?></div>
            <div class="w-100"></div>
            <div class="col"> <b>Marca: </b> <?= $deal['Marca'] ?></div>
            <div class="col"> <b>Placa: </b> <?= $deal['Placa'] ?></div>
        </div>
        <div class="row">
            <div class="col"><b>Modelo: </b> <?= $deal['Modelo'] ?></div>
            <div class="col"><b>Color: </b> <?= $deal['Color'] ?></div>
            <div class="w-100"></div>
            <div class="col"> <b>Año: </b> <?= $deal['A_o_de_Fabricacion'] ?></div>
            <div class="col"> <b>Suma Asegurado: </b> <?= number_format($deal['Valor_Asegurado'], 2) ?></div>
        </div>
        <hr>
        <center>
            <h5>COBERTURAS</h5>
        </center>
        <hr>
        <?php foreach ($products as $key => $product) : ?>
            <?php $detail = $productsDetail->getRecord($product['id']) ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><?= $detail['Vendor_Name'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">
                            <h6><b>DAÑOS PROPIOS</b></h6>
                            <div class="row">
                                <div class="col">Riesgos comprensivos: <?= $detail['Riesgos_comprensivos'] ?>%</div>
                                <div class="col">Riesgos comprensivos (Deducible): <?= $detail['Riesgos_comprensivos_Deducible'] ?>%</div>
                                <div class="w-100"></div>
                                <div class="col">Rotura de Cristales (Deducible): <?= $detail['Rotura_de_Cristales_Deducible'] ?>%</div>
                                <div class="col">Colisión y vuelco: <?= $detail['Colisi_n_y_vuelco'] ?>%</div>
                            </div>
                            <div class="row">
                                <div class="col">Incendio y robo: <?= $detail['Incendio_y_robo'] ?>%</div>
                            </div>
                            <br>
                            <h6><b>RESPONSABILIDAD CIVIL</b></h6>
                            <div class="row">
                                <div class="col">Daños Propiedad ajena: RD$<?= number_format($detail['Da_os_Propiedad_ajena'], 2) ?></div>
                                <div class="col">Lesiones/Muerte 1 Pers: RD$<?= number_format($detail['Lesiones_Muerte_1_Pers'], 2) ?></div>
                                <div class="w-100"></div>
                                <div class="col">Lesiones/Muerte más de 1 Pers: RD$<?= number_format($detail['Lesiones_Muerte_m_s_de_1_Pers'], 2) ?></div>
                                <div class="col">Lesiones/Muerte 1 pasajero: RD$<?= number_format($detail['Lesiones_Muerte_1_pasajero'], 2) ?></div>
                            </div>
                            <div class="row">
                                <div class="col">Lesiones/Muerte más de 1 pasajero: RD$<?= number_format($detail['Lesiones_Muerte_m_s_de_1_pasajero'], 2) ?></div>
                            </div>
                            <br>
                            <h6>RIESGOS CONDUCTOR: </h6>
                            <p class="text-gray-900 p-3 m-0">RD$<?= number_format($detail['Riesgos_conductor'], 2) ?></p>
                            <br>
                            <h6>FIANZA JUDICIAL: </h6>
                            <p class="text-gray-900 p-3 m-0">RD$<?= number_format($detail['Fianza_judicial'], 2) ?></p>
                            <br>
                            <h6><b>COBERTURAS ADICIONALES</b></h6>
                            <div class="row">
                                <div class="col">Asistencia vial: <?= $retVal = ($detail['Asistencia_vial'] == 1) ? "Aplica" : "No Aplica"; ?></div>
                                <div class="col">Renta Vehículo: <?= $retVal = ($detail['Asistencia_vial'] == 1) ? "Aplica" : "No Aplica"; ?></div>
                                <div class="w-100"></div>
                                <div class="col">Reporte de accidente: <?= $detail['Reporte_de_accidente'] ?></div>
                            </div>
                            <br>
                            <hr>
                            <p>Prima: RD$<?= number_format($product['ListPrice'], 2) ?></p>
                            <p>ISC: RD$<?= number_format($product['Tax'], 2) ?></p>
                            <p>Prima total: RD$<?= number_format($product['Total'], 2) ?></p>
                        </th>
                    </tr>
                </tbody>
            </table>
        <?php endforeach ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>

<script>
    window.print();
</script>