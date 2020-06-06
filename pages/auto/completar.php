<?php
$api = new api;
$usuario = json_decode($_COOKIE["usuario"], true);

$url = rtrim($_GET['url'], "/");
$url = explode('/', $url);
$id = $url[2];

$resumen = $api->getRecord("Deals", $id);
$criterio = "Deal_Name:equals:" . $id;
$detalles = $api->searchRecordsByCriteria("Quotes", $criterio);

if (
    empty($resumen)
    or
    empty($detalles)
    or
    $resumen->getFieldValue("Stage") == "Abandonada"
    or
    $resumen->getFieldValue("Email") != null
) {
    header("Location:" . constant("url") . "cotizaciones/error");
    exit();
}

$criterio = "Reporting_To:equals:" . $usuario["id"];
$clientes = $api->searchRecordsByCriteria("Contacts", $criterio);

if ($_POST) {

    $cambios["Chasis"] = $_POST["Chasis"];
    $cambios["Color"] = $_POST["Color"];
    $cambios["Placa"] = $_POST["Placa"];

    if (!empty($_POST["mis_clientes"])) {

        $cliente_info = $api->getRecord("Contacts", $_POST["mis_clientes"]);

        $cambios["Direcci_n"] = $cliente_info->getFieldValue("Mailing_Street");
        $cambios["Nombre"] = $cliente_info->getFieldValue("First_Name");
        $cambios["Apellido"] = $cliente_info->getFieldValue("Last_Name");
        $cambios["RNC_Cedula"] = $cliente_info->getFieldValue("RNC_C_dula");
        $cambios["Telefono"] = $cliente_info->getFieldValue("Phone");
        $cambios["Tel_Residencia"] = $cliente_info->getFieldValue("Home_Phone");
        $cambios["Tel_Trabajo"] = $cliente_info->getFieldValue("Tel_Trabajo");
        $cambios["Fecha_de_Nacimiento"] = $cliente_info->getFieldValue("Date_of_Birth");
        $cambios["Email"] = $cliente_info->getFieldValue("Email");
    } else {

        $cambios["Direcci_n"] = $_POST["Direcci_n"];
        $cambios["Nombre"] = $_POST["Nombre"];
        $cambios["Apellido"] = $_POST["Apellido"];
        $cambios["RNC_Cedula"] = $_POST["RNC_Cedula"];
        $cambios["Telefono"] = (isset($_POST["Telefono"])) ? $_POST["Telefono"] : null;
        $cambios["Tel_Residencia"] = (isset($_POST["Tel_Residencia"])) ? $_POST["Tel_Residencia"] : null;
        $cambios["Tel_Trabajo"] = (isset($_POST["Tel_Trabajo"])) ? $_POST["Tel_Trabajo"] : null;
        $cambios["Fecha_de_Nacimiento"] = $_POST["Fecha_de_Nacimiento"];
        $cambios["Email"] = $_POST["Email"];
    }

    if (
        empty($cambios["RNC_Cedula"])
        or
        empty($cambios["Nombre"])
        or
        empty($cambios["Apellido"])
        or
        empty($cambios["Email"])
        or
        empty($cambios["Fecha_de_Nacimiento"])
    ) {
        $alerta = "Debes completar almenos el <b>nombre,RNC/Cedula,Email y fecha de nacimiento</b> para agregar un cliente.";
    } else {

        $api->updateRecord("Deals", $id, $cambios);
        $alerta = "Cliente agregado";

        header("Location:" . constant("url") . "auto/detalles/$id?alert=$alerta");
        exit;
    }
}

require_once("pages/template/header_auto.php");

?>
<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>

    <br>
<?php endif ?>

<div class="card">
    <div class="card-body">

        <ul class="nav justify-content-center">
            <li class="nav-item">
                <button type="button" class="btn btn-link nav-link" onclick="mostrar_clientes()">
                    <i class="tiny material-icons">group</i> Clientes
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-link nav-link" onclick="mostrar_cliente_nuevo()">
                    <i class="tiny material-icons">group_add</i> Cliente Nuevo
                </button>
            </li>
        </ul>

        <br>

        <form method="POST" action="<?= constant("url") ?>auto/completar/<?= $id ?>">

            <div id="cliente_nuevo">
                <h5>Agregar Cliente Nuevo</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">RNC/Cédula</label>
                        <input type="text" class="form-control" name="RNC_Cedula" value="<?= (isset($_POST["RNC_Cedula"])) ? $_POST["RNC_Cedula"] : ""; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Nombre</label>
                        <input type="text" class="form-control" name="Nombre" value="<?= (isset($_POST["Nombre"])) ? $_POST["Nombre"] : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Apellido</label>
                        <input type="text" class="form-control" name="Apellido" value="<?= (isset($_POST["Apellido"])) ? $_POST["Apellido"] : ""; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Dirección</label>
                        <input type="text" class="form-control" name="Direcci_n" value="<?= (isset($_POST["Direcci_n"])) ? $_POST["Direcci_n"] : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tel. Celular</label>
                        <input type="tel" class="form-control" name="Telefono" value="<?= (isset($_POST["Telefono"])) ? $_POST["Telefono"] : ""; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tel. Trabajo</label>
                        <input type="tel" class="form-control" name="Tel_Residencia" value="<?= (isset($_POST["Tel_Residencia"])) ? $_POST["Tel_Residencia"] : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tel. Residencial</label>
                        <input type="tel" class="form-control" name="Tel_Trabajo" value="<?= (isset($_POST["Tel_Trabajo"])) ? $_POST["Tel_Trabajo"] : ""; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Correo Electrónico</label>
                        <input type="email" class="form-control" name="Email" value="<?= (isset($_POST["Email"])) ? $_POST["Email"] : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" name="Fecha_de_Nacimiento" value="<?= (isset($_POST["Fecha_de_Nacimiento"])) ? $_POST["Fecha_de_Nacimiento"] : ""; ?>">
                    </div>
                </div>
            </div>

            <div id="clientes" style="display: none">
                <h5>Mis Clientes</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Nombre</label>
                        <select name="mis_clientes" class="form-control">
                            <option selected value="">Ninguno</option>
                            <?php
                            sort($clientes);
                            foreach ($clientes as $cliente) {
                                $nombre = $cliente->getFieldValue("First_Name") . " " . $cliente->getFieldValue("Last_Name");
                                echo '<option value="' . $cliente->getEntityId() . '">' . strtoupper($nombre) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <br>

            <h5>Vehículo</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Chasis</label>
                    <input type="text" class="form-control" name="Chasis" required value="<?= (isset($_POST["Chasis"])) ? $_POST["Chasis"] : $resumen->getFieldValue('Chasis'); ?>">
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Color</label>
                    <input type="text" class="form-control" name="Color" required value="<?= (isset($_POST["Color"])) ? $_POST["Color"] : $resumen->getFieldValue('Color'); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Placa</label>
                    <input type="text" class="form-control" name="Placa" required value="<?= (isset($_POST["Placa"])) ? $_POST["Placa"] : $resumen->getFieldValue('Placa'); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-success">Completar</button>
                </div>
            </div>

        </form>

    </div>
</div>

<script>
    var clientes = document.getElementById("clientes");
    var cliente_nuevo = document.getElementById("cliente_nuevo");

    function mostrar_clientes() {
        if (clientes.style.display === "none") {
            clientes.style.display = "block";
            cliente_nuevo.style.display = "none";
        }

    }

    function mostrar_cliente_nuevo() {
        if (cliente_nuevo.style.display === "none") {
            cliente_nuevo.style.display = "block";
            clientes.style.display = "none";
        }

    }
</script>