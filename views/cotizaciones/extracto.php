<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Extracto de las Principales Condiciones</title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">

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
</head>

<body>
    <div class="container">
        <div class="row">

            <div class="col-2">
                <img height="50" width="150" src="<?= constant("url") . $imagen_aseguradora ?>">
            </div>

            <div class="col-8 text-center">
                <h4>
                    RESUMEN DE LAS PRINCIPALES CONDICIONES <br>
                    VEHICULOS DE MOTOR
                </h4>
            </div>

            <div class="col-2">
                <b> Póliza No.</b><br><?= $trato->getFieldValue('P_liza')->getLookupLabel() ?><br>
            </div>

            <div class="col-12">
                &nbsp;
            </div>

            <div class="col-12">
                <ol>
                    <li>
                        Este certificado es sólo un cotización de las condiciones principales contenidas en la póliza.
                    </li>
                    <li>
                        Si al momento de un siniestro, la suma asegurada del vehículo es menor que su valor de mercado, la aseguradora reducirá de la reclamación presentada, el monto equivalente a la proporción dejada de asegurar. La compañía aseguradora sólo será responsable por aquella parte de la pérdida en la proporción en la que tenga el valor real como suma asegurada.
                    </li>
                    <li>
                        Queda excluida de toda cobertura, los accesorios, equipos y aditamentos que no sean instalados de fábrica en el vehículo asegurado, a menos de que hayan sido declarados previamente en la póliza. Tampoco tienen cobertura mercancías o herramientas dejadas dentro del vehículo asegurado o que se transporten en el mismo.
                    </li>
                    <li>
                        Quedan excluidas las pérdidas y/o daños sufridos y/o causados al vehículo asegurado si el mismo fuese conducido por personas sin licencia de conducir otorgada por las autoridades competentes. Se excluye también los daños sufridos u ocasionados en el vehículo asegurado si este fuese conducido en estado de embriaguez o bajo la influencia de cualquier droga. Tampoco tendrá cobertura si el vehículo asegurado no está siendo es utilizado con fines privados, es decir que se utilice como transporte comercial (taxi, carro público, etc.).
                    </li>
                    <li>
                        En caso de realizarse alguna modificación o instalación de algún aditamento o accesorio a las especificaciones de fábrica al vehículo asegurado, (Ejemplo: cambio en el sistema de combustible, cambio de ubicación del volante, aros, equipos de música, luces, etc.), luego de haberse incluido en la póliza, obligatoriamente debe de notificarse a la compañía aseguradora para los fines de re-inspección del vehículo, aceptación y cobertura, mediante endoso, por la aseguradora.
                    </li>
                    <li>
                        Si el vehículo asegurado se encontrase transitando fuera del territorio nacional o en caminos no declarados ni autorizados de tránsito público por las autoridades competentes, y sufre algún tipo de daño o siniestro, la cobertura queda excluida, a menos que fuera autorizado por la aseguradora.
                    </li>
                    <li>
                        Queda excluida de toda cobertura daños ocasionados por la entrada de agua al motor o cualquier otra parte del vehículo asegurado, cuando dicha entrada es causada por el ingreso voluntario del vehículo a una vía, camino o terreno inundado.
                    </li>
                    <li>
                        En caso de reclamación parcial para vehículos de más de 3 años de fabricación, se indemnizará utilizando repuestos usados y/o piezas de reemplazo.
                    </li>
                    <li>
                        La aseguradora indemnizará pérdidas y/ o daños sufridos al vehículo asegurado, descontando el deducible aplicable a cada cobertura.
                    </li>
                    <li>
                        La aseguradora está en su derecho de proceder a la cancelación de la póliza, o descontinuar la cobertura del vehículo, en cualquier momento previo aviso al asegurado con treinta (30) días de antelación a la efectividad de la misma. Si la cancelación es por falta de pago, aplica lo establecido en los artículos 73, 74 y 75 de ley 146-02 de seguros y fianzas de la República Dominicana.
                    </li>
                    <li>
                        Para proceder a la inclusión del vehículo asegurado en la póliza, si el vehículo es usado debe de ser sometido a inspección y reportar su inclusión a la aseguradora en un plazo no mayor de 48 horas. Pasado este plazo, la cobertura quedará reducida a seguro de ley. En caso del vehículo ser nuevo (0 KM) se puede proceder a la inclusión en la póliza con el conduce de salida, debidamente sellado, completado con los datos del mismo y firmado por el dealer o concesionario.
                    </li>
                    <li>
                        La cobertura de este certificado está sujeta al pago de la prima.
                    </li>
                    <li>
                        Esta póliza tendrá un período de duración igual a la vigencia del préstamo. Si el préstamo es saldado antes del fin de la vigencia, la cobertura cesará.
                    </li>
                    <li>
                        La prima de este seguro puede ser revisable sin previo aviso y está sujeta a la siniestralidad de la póliza.
                    </li>
                    <li>
                        Tarifa NO APLICA para Vehículos con Equipo de Gas instalado, solo se aceptarán si el Equipo es marca LOVATO o TARTARINI, los cuales deben ser inspeccionado por perito de la aseguradora y sujeto a que cliente suministre copia de factura instalación y garantía del mismo. En caso de aceptación aplica recargo a la tarifa.
                    </li>
                    <li>
                        Los vehículos MITSUBISHI para los modelos, NATIVA, MONTERO SPORT Y L200, y los camiones DAIHATSU deberán de tener un sistema de seguridad contra robo o rastreo tipo GPS. En caso contrario solo se asegurará a un 50%.
                    </li>
                </ol>
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
                &nbsp;
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
        var id = "<?= $id ?>";
        setTimeout(function() {
            window.print();
            window.location = url + "cotizaciones/detalles/" + id;
        }, time);
    </script>

</body>

</html>