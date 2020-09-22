<?php
$api = new api;
$detalles = $api->detalles("Deals", $_GET["id"]);

if (
    empty($detalles)
    or
    date("Y-m-d", strtotime($detalles->getFieldValue("Closing_Date"))) < date('Y-m-d')
) {
    require_once "error.php";
    exit();
}

if ($_POST) {
    $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
    $permitido = array("pdf");

    if (!in_array($extension, $permitido)) {
        $alerta = "Para emitir solo se admiten documentos PDF";
    } else {

        $criteria = "Deal_Name:equals:" . $detalles->getEntityId();
        $cotizaciones = $api->listaFiltrada("Quotes", $criteria);
        foreach ($cotizaciones as $cotizacion) {
            if ($cotizacion->getFieldValue('Aseguradora')->getEntityId() == $_POST["aseguradora_id"]) {
                $contrato = $api->detalles("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());

                $planes = $cotizacion->getLineItems();
                foreach ($planes as $plan) {
                    $prima_total = $plan->getNetTotal();
                }

                $no_poliza = $contrato->getFieldValue('No_P_liza');
                $comision_nobe = $prima_total * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                $comision_aseguradora = $prima_total * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                $comision_socio = $prima_total * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                $aseguradora_id = $cotizacion->getFieldValue('Aseguradora')->getEntityId();

                $cotizacion_cambios["Quote_Stage"] = "Confirmada";
                $cotizacion_cambios["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
                $api->cambios("Quotes", $cotizacion->getEntityId(), $cotizacion_cambios);
            } else {
                $api->eliminar("Quotes", $cotizacion->getEntityId());
            }
        }

        if ($detalles->getFieldValue('Edad_codeudor') != null){
            $codeudor["Direcci_n"] = $_POST["direccion_codeudor"];
            $codeudor["Nombre"] = $_POST["nombre_codeudor"];
            $codeudor["Apellido"] = $_POST["apellido_codeudor"];
            $codeudor["Tel_fono"] = $_POST["telefono_codeudor"];
            $codeudor["Tel_residencia"] = $_POST["tel_residencia_codeudor"];
            $codeudor["Tel_trabajo"] = $_POST["tel_trabajo_codeudor"];
            $codeudor["Fecha_nacimiento"] = date("Y-m-d", strtotime($_POST["fecha_nacimiento_codeudor"]));
            $codeudor["Email"] = $_POST["correo_codeudor"];
            $codeudor["RNC_C_dula"] = $_POST["rnc_cedula_codeudor"];
            $codeudor["Name"] = $_POST["rnc_cedula_codeudor"];
            $codeudor["Tipo"] = "Codeudor";
            $codeudor_id =  $api->crear("Clientes", $codeudor);
        }

        $deudor["Direcci_n"] = $_POST["direccion"];
        $deudor["Nombre"] = $_POST["nombre"];
        $deudor["Apellido"] = $_POST["apellido"];
        $deudor["Tel_fono"] = $_POST["telefono"];
        $deudor["Tel_residencia"] = $_POST["tel_residencia"];
        $deudor["Tel_trabajo"] = $_POST["tel_trabajo"];
        $deudor["Fecha_nacimiento"] = date("Y-m-d", strtotime($_POST["fecha_nacimiento"]));
        $deudor["Email"] = $_POST["correo"];
        $deudor["RNC_C_dula"] = $_POST["rnc_cedula"];
        $deudor["Name"] = $_POST["rnc_cedula"];
        $deudor["Tipo"] = "Deudor";
        $deudor["Codeudor"] = $codeudor_id;
        $deudor_id =  $api->crear("Clientes", $deudor);

        $poliza["Name"] = $no_poliza;
        $poliza["Estado"] = true;
        $poliza["Plan"] = $detalles->getFieldValue('Plan');
        $poliza["Aseguradora"] = $aseguradora_id;
        $poliza["Prima"] = round($prima_total, 2);
        $poliza["Propietario"] = $deudor_id;
        $poliza["Ramo"] =  "Vida";
        $poliza["Tipo"] = "Declarativa";
        $poliza["Suma_asegurada"] = $detalles->getFieldValue('Suma_asegurada');
        $poliza["Vigencia_desde"] = date("Y-m-d");
        $poliza["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $poliza_id =  $api->crear("P_lizas", $poliza);

        $trato["Deal_Name"] = "Resumen";
        $trato["Fecha_de_emisi_n"] = date("Y-m-d");
        $trato["Stage"] = "En trámite";
        $trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $trato["P_liza"] = $poliza_id;
        $trato["Cliente"] = $deudor_id;
        $trato["Aseguradora"] = $aseguradora_id;
        $trato["Comisi_n_aseguradora"] = round($comision_aseguradora, 2);
        $trato["Comisi_n_socio"] = round($comision_socio, 2);
        $trato["Amount"] = round($comision_nobe, 2);
        $api->cambios("Deals", $_GET["id"], $trato);

        $ruta = "public/path";
        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta/$name");
        $api->adjuntar("Deals", $_GET["id"], "$ruta/$name");
        unlink("$ruta/$name");

        header("Location:index.php?page=detallesVida&id=" . $_GET["id"]);
        exit();
    }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">emitir cotización vida</h1>
</div>

<?php if (isset($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form enctype="multipart/form-data" class="row" method="POST" action="index.php?page=emitirVida&id=<?= $_GET["id"] ?>">

    <div class="mx-auto col-10" style="width: 200px;">

        <h5>Deudor</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nombre</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="nombre" value="<?= $detalles->getFieldValue('Nombre') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Apellido</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="apellido">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">RNC/Cédula</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="rnc_cedula">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Fecha de Nacimiento</label>

            <div class="col-sm-8">
                <input type="date" class="form-control" name="fecha_nacimiento">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Correo Electrónico</label>

            <div class="col-sm-8">
                <input type="email" class="form-control" name="correo">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Dirección</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="direccion">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tel. Celular</label>

            <div class="col-sm-8">
                <input type="tel" class="form-control" name="telefono">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tel. Residencial</label>

            <div class="col-sm-8">
                <input type="tel" class="form-control" name="tel_residencia">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tel. Trabajo</label>

            <div class="col-sm-8">
                <input type="tel" class="form-control" name="tel_trabajo">
            </div>
        </div>

        <?php if ($detalles->getFieldValue('Edad_codeudor') != null) : ?>
            <br>
            <h5>Codeudor</h5>
            <hr>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nombre</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="nombre_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Apellido</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="apellido_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">RNC/Cédula</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="rnc_cedula_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Fecha de Nacimiento</label>

                <div class="col-sm-8">
                    <input type="date" class="form-control" name="fecha_nacimiento_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Correo Electrónico</label>

                <div class="col-sm-8">
                    <input type="email" class="form-control" name="correo_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Dirección</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="direccion_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tel. Celular</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="telefono_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tel. Residencial</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="tel_residencia_codeudor">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tel. Trabajo</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="tel_trabajo_codeudor">
                </div>
            </div>
        <?php endif ?>

        <br>
        <h5>Emitir con</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Aseguradora</label>

            <div class="col-sm-8">
                <select required name="aseguradora_id" class="form-control">
                    <option value="" selected disabled>Selecciona una Aseguradora</option>
                    <?php
                    $criteria = "Deal_Name:equals:" . $detalles->getEntityId();
                    $cotizaciones = $api->listaFiltrada("Quotes", $criteria);
                    foreach ($cotizaciones as $cotizacion) {
                        if ($cotizacion->getFieldValue('Grand_Total') > 0) {
                            echo '<option value="' . $cotizacion->getFieldValue('Aseguradora')->getEntityId() . '">' . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Cotización Firmada</label>

            <div class="col-sm-8">
                <input required type="file" class="form-control-file" name="cotizacion_firmada">
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success">Emitir</button>
        |
        <a href="index.php?page=detallesAuto&id=<?= $_GET["id"] ?>" class="btn btn-info">Cancelar</a>

    </div>
</form>

<br><br>