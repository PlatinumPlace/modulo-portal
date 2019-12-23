<?php

include "../../core/models/dealsAPI.php";
include "../../core/models/productsAPI.php";
include "../../core/models/quotesAPI.php";
include "../../zohoapi/config.php";

$id = $_GET['id'];
$dealAPI = new dealsAPI;
$deal = $dealAPI->getRecord($id);
$quoteAPI = new quotesAPI;
$quote = $quoteAPI->getRecordByCriteria($id);
$productsAPI = new productsAPI;

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Portal</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <div id="wrapper">



        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">


                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            COTIZACION <br>
                            SEGURO VEHICULO DE MOTOR <br>
                            PLAN <?= strtoupper($deal['Plan']) ?>
                        </h1>
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
                            <?php $detail = $productsAPI->getRecord($product['id_product']) ?>
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
                </div>
                <br>
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Grupo Nobe SRL <?= date("Y") ?></span>
                        </div>
                    </div>
                </footer>


            </div>

        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>.. <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

        <script src="../js/sb-admin-2.min.js"></script>

        <script src="../vendor/chart.js/Chart.min.js"></script>

        <script src="../js/demo/chart-area-demo.js"></script>
        <script src="../js/demo/chart-pie-demo.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script>
            print();
        </script>

</body>

</html>