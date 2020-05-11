<?php

$cotizacion =  $api->obtener_registro("Deals", $datos);

$criterio = "Reporting_To:equals:" . $_SESSION["usuario_id"];
$mis_clientes = $api->buscar_registro_por_criterio("Contacts", $criterio);
sort($mis_clientes);

if (empty($cotizacion) or $cotizacion->getFieldValue('Stage') == "Abandonado") {
    header("Location: " . constant('url') . "home/error/");
    exit();
}

if (isset($_POST['submit'])) {

    if (!empty($_POST["Chasis"])) {
        $cambios["Chasis"] = $_POST["Chasis"];
    }
    if (!empty($_POST["Color"])) {
        $cambios["Color"] = $_POST["Color"];
    }
    if (!empty($_POST["Placa"])) {
        $cambios["Placa"] = $_POST["Placa"];
    }

    if (!empty($_POST["mis_clientes"])) {

        $cliente = $api->getRecord("Contacts", $_POST["mis_clientes"]);

        $cambios["Direcci_n"] = $cliente->getFieldValue("Mailing_Street");
        $cambios["Nombre"] = $cliente->getFieldValue("First_Name");
        $cambios["Apellido"] = $cliente->getFieldValue("Last_Name");
        $cambios["RNC_Cedula"] = $cliente->getFieldValue("RNC_C_dula");
        $cambios["Telefono"] = $cliente->getFieldValue("Phone");
        $cambios["Tel_Residencia"] = $cliente->getFieldValue("Home_Phone");
        $cambios["Tel_Trabajo"] = $cliente->getFieldValue("Tel_Trabajo");
        $cambios["Fecha_de_Nacimiento"] = $cliente->getFieldValue("Date_of_Birth");
        $cambios["Email"] = $cliente->getFieldValue("Email");
    } else {

        if (!empty($_POST["Direcci_n"])) {
            $cambios["Direcci_n"] = $_POST["Direcci_n"];
        }
        if (!empty($_POST["Nombre"])) {
            $cambios["Nombre"] = $_POST["Nombre"];
        }
        if (!empty($_POST["Apellido"])) {
            $cambios["Apellido"] = $_POST["Apellido"];
        }
        if (!empty($_POST["RNC_Cedula"])) {
            $cambios["RNC_Cedula"] = $_POST["RNC_Cedula"];
        }
        if (!empty($_POST["Telefono"])) {
            $cambios["Telefono"] = $_POST["Telefono"];
        }
        if (!empty($_POST["Tel_Residencia"])) {
            $cambios["Tel_Residencia"] = $_POST["Tel_Residencia"];
        }
        if (!empty($_POST["Tel_Trabajo"])) {
            $cambios["Tel_Trabajo"] = $_POST["Tel_Trabajo"];
        }
        if (!empty($_POST["Fecha_de_Nacimiento"])) {
            $cambios["Fecha_de_Nacimiento"] = $_POST["Fecha_de_Nacimiento"];
        }
        if (!empty($_POST["Email"])) {
            $cambios["Email"] = $_POST["Email"];
        }
    }
    $api->updateRecord("Deals", $cambios, $datos);

    header("Location:" . constant('url') . 'cotizaciones/detalles_auto/' . $datos);
    exit;
}

?>
<form method="POST" action="<?= constant('url') ?>cotizaciones/completar_auto/<?= $cotizacion->getEntityId() ?>">


    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button class="nav-link active" onclick="mis_clientes()">Mis Clientes</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" onclick="cliente_nuevo()">Cliente Nuevo</button>
        </li>
    </ul>

    <div id="mis_clientes">

        <div class="card">
            <h5 class="card-header">Mis Clientes</h5>
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <select name="mis_clientes" class="form-control">
                            <option selected value="">Ninguno</option>
                            <?php
                            foreach ($mis_clientes as $cliente) {
                                $nombre = $cliente->getFieldValue("First_Name") . " " . $cliente->getFieldValue("Last_Name");
                                echo '<option value="' . $cliente->getEntityId() . '">' . strtoupper($nombre) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <br>

    </div>

    <div id="cliente_nuevo" style="display: none">

        <div class="card">
            <h5 class="card-header">Cliente</h5>
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">RNC/Cédula</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="RNC_Cedula" id="RNC_Cedula">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="Nombre" id="Nombre">
                    </div>

                    <label class="col-sm-2 col-form-label">Apellido</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="Apellido" id="Apellido">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Direcci_n">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Celular</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="Telefono">
                    </div>

                    <label class="col-sm-2 col-form-label">Tel. Trabajo</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="Tel_Residencia">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Residencial</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="Tel_Trabajo">
                    </div>

                    <label class="col-sm-2 col-form-label">Correo Electrónico</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="Email" id="Email">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="Fecha_de_Nacimiento" id="Fecha_de_Nacimiento">
                    </div>
                </div>

            </div>
        </div>

        <br>

    </div>

    <div class="card">
        <h5 class="card-header">Vehículo</h5>
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Chasis</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Chasis" required value="<?= $cotizacion->getFieldValue('Chasis') ?>">
                </div>

                <label class="col-sm-2 col-form-label">Color</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Color" value="<?= $cotizacion->getFieldValue('Color') ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Placa</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Placa" value="<?= $cotizacion->getFieldValue('Placa') ?>">
                </div>
            </div>

        </div>
    </div>

    <br>
    <div class="row">

        <div class="col-md-8">
            &nbsp;
        </div>

        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Opciones</h5>
                <div class="card-body">
                    <button type="submit" name="submit" class="btn btn-success">Completar</button>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    var x = document.getElementById("mis_clientes");
    var y = document.getElementById("cliente_nuevo");

    function mis_clientes() {

        if (x.style.display === "none") {

            x.style.display = "block";
            y.style.display = "none";

            document.getElementById("mis_clientes").required = true;
            document.getElementById("RNC_Cedula").required = false;
            document.getElementById("Nombre").required = false;
            document.getElementById("Apellido").required = false;
            document.getElementById("Email").required = false;
            document.getElementById("Fecha_de_Nacimiento").required = false;


        }

    }

    function cliente_nuevo() {

        if (y.style.display === "none") {

            y.style.display = "block";
            x.style.display = "none";

            document.getElementById("mis_clientes").required = false;
            document.getElementById("RNC_Cedula").required = true;
            document.getElementById("Nombre").required = true;
            document.getElementById("Apellido").required = true;
            document.getElementById("Email").required = true;
            document.getElementById("Fecha_de_Nacimiento").required = true;
        }

    }
</script>