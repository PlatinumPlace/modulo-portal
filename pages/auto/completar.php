<?php
$cotizaciones = new cotizaciones;
$url = obtener_url();

if (empty($url[0])) {
    require_once "pages/error.php";
    exit();
}

$detalles_resumen = $cotizaciones->detalles_resumen($url[0]);

$alerta = (isset($url[1])) ? $url[1] : null;
$num_pagina = (isset($url[2])) ? $url[2] : 1;

if (
    empty($detalles_resumen)
    or
    $detalles_resumen->getFieldValue('Nombre') != null
    or
    $detalles_resumen->getFieldValue("Stage") == "Abandonada"
) {
    require_once "pages/error.php";
    exit();
}

if ($_POST) {
    $cambios_resumen["Chasis"] = $_POST["chasis"];
    $cambios_resumen["Color"] = (isset($_POST["color"])) ? $_POST["color"] : null;
    $cambios_resumen["Placa"] = (isset($_POST["placa"])) ? $_POST["placa"] : null;
    $cambios_resumen["Uso"] = (isset($_POST["uso"])) ? $_POST["uso"] : null;
    $cambios_resumen["Es_nuevo"] = (isset($_POST["nuevo"])) ? true : false;

    if (isset($_POST["cliente_id"])) {
        $cambios_resumen["RNC_Cedula"] = $_POST["rnc_cedula"];
        $cambios_resumen["Direcci_n"] = (isset($_POST["direccion"])) ? $_POST["direccion"] : null;
        $cambios_resumen["Nombre"] = $_POST["nombre"];
        $cambios_resumen["Apellidos"] = (isset($_POST["apellido"])) ? $_POST["apellido"] : null;
        $cambios_resumen["Telefono"] = (isset($_POST["telefono"])) ? $_POST["telefono"] : null;
        $cambios_resumen["Tel_Residencia"] = (isset($_POST["tel_residencia"])) ? $_POST["tel_residencia"] : null;
        $cambios_resumen["Tel_Trabajo"] = (isset($_POST["tel_trabajo"])) ? $_POST["tel_trabajo"] : null;
        $cambios_resumen["Fecha_de_Nacimiento"] = $_POST["fecha_nacimiento"];
        $cambios_resumen["Email"] = (isset($_POST["correo"])) ? $_POST["correo"] : null;
    } else {
        $cliente = $cotizaciones->detalles_cliente($_POST["cliente_id"]);
        $cambios_resumen["RNC_Cedula"] =  $cliente->getFieldValue("RNC_C_dula");
        $cambios_resumen["Direcci_n"] =  $cliente->getFieldValue("Direcci_n");
        $cambios_resumen["Nombre"] =  $cliente->getFieldValue("Name");
        $cambios_resumen["Apellidos"] =  $cliente->getFieldValue("Apellido");
        $cambios_resumen["Telefono"] =  $cliente->getFieldValue("Tel");
        $cambios_resumen["Tel_Residencia"] =  $cliente->getFieldValue("Tel_Residencia");
        $cambios_resumen["Tel_Trabajo"] =  $cliente->getFieldValue("Tel_Trabajo");
        $cambios_resumen["Fecha_de_Nacimiento"] = date("Y-m-d", strtotime($cliente->getFieldValue("Fecha_de_Nacimiento")));
        $cambios_resumen["Email"] =  $cliente->getFieldValue("Email");
    }

    if (
        empty($cambios_resumen["Nombre"])
        or
        empty($cambios_resumen["RNC_Cedula"])
        or
        empty($cambios_resumen["Fecha_de_Nacimiento"])
        or
        empty($cambios_resumen["Chasis"])
        or
        !ctype_alnum($cambios_resumen["Chasis"])
    ) {
        $alerta = "Debes completar almenos: Chasis valido,RNC/cedula,Nombre y Fecha de nacimiento del cliente.";
    } else {
        $cotizaciones->guardar_cambios_resumen($cambios_resumen, $url[0]);
    }

    header("Location:" . constant("url") . "auto/detalles/" . $url[0] . "/Cliente agregado.");
    exit();
}

require_once 'pages/layout/header_main.php';
?>
<h2 class="mt-4 text-uppercase text-center">
    seguro vehículo de motor plan <?= $detalles_resumen->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $url[0] ?>">No. <?= $detalles_resumen->getFieldValue('No_Cotizaci_n') ?></a></li>
</ol>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (isset($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>
        <div class="card mb-4">
            <div class="card-body">
                <button onclick="existente()" class="btn btn-secondary">Cliente Existente</button>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>auto/completar/<?= $url[0] ?>">
                    <div id="existente" style="display: none;">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Clientes</label>
                                    <select name="cliente_id" class="form-control">
                                        <option selected value="">Ninguno</option>
                                        <?php $lista_clientes = $cotizaciones->lista_clientes() ?>
                                        <?php foreach ($lista_clientes as $cliente) : ?>
                                            <option value="<?= $cliente->getEntityId() ?>"><?= strtoupper($cliente->getFieldValue('Name') . " " . $cliente->getFieldValue('Apellido')) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>

                    <div id="nuevo">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">RNC/Cédula <small>(sin guiones)</small> </label>
                                    <input type="text" class="form-control" name="rnc_cedula" maxlength="11" value="<?= (isset($_POST["rnc/cedula"])) ? $_POST["rnc/cedula"] : ""; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="<?= (isset($_POST["nombre"])) ? $_POST["nombre"] : ""; ?>">
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Apellido</label>
                                    <input type="text" class="form-control" name="apellido" value="<?= (isset($_POST["apellido"])) ? $_POST["apellido"] : ""; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" value="<?= (isset($_POST["direccion"])) ? $_POST["direccion"] : ""; ?>">
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tel. Celular</label>
                                <input type="tel" class="form-control" name="telefono" value="<?= (isset($_POST["telefono"])) ? $_POST["telefono"] : ""; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tel. Trabajo</label>
                                <input type="tel" class="form-control" name="tel_residencia" value="<?= (isset($_POST["tel_residencia"])) ? $_POST["tel_residencia"] : ""; ?>">
                            </div>
                        </div>

                        <br>


                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tel. Residencial</label>
                                <input type="tel" class="form-control" name="tel_trabajo" value="<?= (isset($_POST["tel_trabajo"])) ? $_POST["tel_trabajo"] : ""; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Correo Electrónico</label>
                                <input type="email" class="form-control" name="correo" value="<?= (isset($_POST["correo"])) ? $_POST["correo"] : ""; ?>">
                            </div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" value="<?= (isset($_POST["fecha_nacimiento"])) ? $_POST["fecha_nacimiento"] : ""; ?>">
                            </div>
                        </div>

                        <br>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Chasis <small>(sin guiones,solo números y letras)</small></label>
                            <input type="text" class="form-control" name="chasis" value="<?= (isset($_POST["chasis"])) ? $_POST["chasis"] : $detalles_resumen->getFieldValue('Chasis'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Color</label>
                            <input type="text" class="form-control" name="color" value="<?= (isset($_POST["color"])) ? $_POST["color"] : $detalles_resumen->getFieldValue('Color'); ?>">
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Uso</label>
                            <select name="uso" class="form-control">
                                <option selected disabled value="<?= $detalles_resumen->getFieldValue('Uso') ?>"><?= (!empty($detalles_resumen->getFieldValue('Uso'))) ? $detalles_resumen->getFieldValue('Uso') : "Selecciona una opcion"; ?></option>
                                <option value="Privado">Privado</option>
                                <option value="Publico">Publico</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Placa</label>
                            <input type="text" class="form-control" name="placa" value="<?= (isset($_POST["place"])) ? $_POST["place"] : $detalles_resumen->getFieldValue('Placa'); ?>">
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">&nbsp;</label>
                            <div class="form-group form-check">
                                <input class="form-check-input" type="checkbox" name="nuevo" <?= ($detalles_resumen->getFieldValue('Es_nuevo') == true) ? "checked" : ""; ?>>
                                ¿Es nuevo?
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <button type="submit" class="btn btn-success">Completar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'pages/layout/footer_main.php'; ?>
<script>
    function existente() {
        if (document.getElementById("existente").style.display == "none") {
            document.getElementById("existente").style.display = "block";
            document.getElementById("nuevo").style.display = "none";
        } else {
            document.getElementById("nuevo").style.display = "block";
            document.getElementById("existente").style.display = "none";
        }
    }
</script>