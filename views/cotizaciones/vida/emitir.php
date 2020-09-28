<?php
$url = explode("/", $_GET["url"]);
$id = (isset($url[2])) ? $url[2] : null;
$trato = detalles("Deals", $id);

if (
        empty($trato)
        or
        date("Y-m-d", strtotime($trato->getFieldValue("Closing_Date"))) < date('Y-m-d')
        or
        $trato->getFieldValue("P_liza") != null
) {
    require_once "views/portal/error.php";
    exit();
}

if ($_POST) {
    $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
    $permitido = array("pdf");

    if (!in_array($extension, $permitido)) {
        $alerta = "Para emitir solo se admiten documentos PDF";
    } else {
        $criteria = "Deal_Name:equals:" . $trato->getEntityId();
        $cotizaciones = listaPorCriterio("Quotes", $criteria);
        foreach ($cotizaciones as $cotizacion) {
            if ($cotizacion->getFieldValue('Aseguradora')->getEntityId() == $_POST["aseguradora_id"]) {
                $planes = $cotizacion->getLineItems();
                foreach ($planes as $plan) {
                    $prima_neta = round($plan->getListPrice(), 2);
                    $isc = round($plan->getTaxAmount(), 2);
                    $prima_total = round($plan->getNetTotal(), 2);
                }

                $contrato = detalles("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());

                //$coberturas_id = $cotizacion->getFieldValue('Coberturas')->getEntityId();
                $no_poliza = $contrato->getFieldValue('No_P_liza');
                $comision_nobe = $prima_total * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                $comision_aseguradora = $prima_total * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                $comision_socio = $prima_total * $contrato->getFieldValue('Comisi_n_Socio') / 100;

                $cambios["Quote_Stage"] = "Confirmada";
                actualizar("Quotes", $cotizacion->getEntityId(), $cambios);
            }
        }

        $deudor["Mailing_Street"] = $_POST["direccion"];
        $deudor["First_Name"] = $_POST["nombre"];
        $deudor["Last_Name"] = $_POST["apellido"];
        $deudor["Phone"] = $_POST["telefono"];
        $deudor["Home_Phone"] = $_POST["tel_residencia"];
        $deudor["Other_Phone"] = $_POST["tel_trabajo"];
        $deudor["Date_of_Birth"] = date("Y-m-d", strtotime($_POST["fecha_nacimiento"]));
        $deudor["Email"] = $_POST["correo"];
        $deudor["RNC_C_dula"] = $_POST["rnc_cedula"];
        $deudor["Tipo"] = "Deudor";
        $deudor["Reporting_To"] = $_SESSION["usuario"]['id'];
        $deudor["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $deudor["Vendor_Name"] = $_POST["aseguradora_id"];
        $deudor_id = crear("Contacts", $deudor);

        if ($trato->getFieldValue('Edad_codeudor') != null) {
            $codeudor["Mailing_Street"] = $_POST["direccion_codeudor"];
            $codeudor["First_Name"] = $_POST["nombre_codeudor"];
            $codeudor["Last_Name"] = $_POST["apellido_codeudor"];
            $codeudor["Phone"] = $_POST["telefono_codeudor"];
            $codeudor["Home_Phone"] = $_POST["tel_residencia_codeudor"];
            $codeudor["Other_Phone"] = $_POST["tel_trabajo_codeudor"];
            $codeudor["Date_of_Birth"] = date("Y-m-d", strtotime($_POST["fecha_nacimiento_codeudor"]));
            $codeudor["Email"] = $_POST["correo_codeudor"];
            $codeudor["RNC_C_dula"] = $_POST["rnc_cedula_codeudor"];
            $codeudor["Tipo"] = "Codeudor";
            $codeudor["Reporting_To"] = $deudor_id;
            $codeudor["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $codeudor["Vendor_Name"] = $_POST["aseguradora_id"];
            $codeudor_id = crear("Contacts", $codeudor);
        }


        $poliza["Name"] = $no_poliza;
        $poliza["Estado"] = true;
        $poliza["Informar_a"] = $deudor_id;
        $poliza["Plan"] = $trato->getFieldValue('Plan');
        $poliza["Aseguradora"] = $_POST["aseguradora_id"];
        $poliza["Prima"] = $prima_total;
        $poliza["Ramo"] = "Vida";
        $poliza["Tipo"] = "Declarativa";
        $poliza["Suma_asegurada"] = $trato->getFieldValue('Suma_asegurada');
        $poliza["Vigencia_desde"] = date("Y-m-d");
        $poliza["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $poliza_id = crear("P_lizas", $poliza);

        $cambios["Deal_Name"] = "Resumen";
        $cambios["Stage"] = "En trámite";
        $cambios["Nombre"] = $_POST["nombre"] . " " . $_POST["apellido"];
        $cambios["Fecha"] = date("Y-m-d");
        $cambios["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $cambios["P_liza"] = $poliza_id;
        $cambios["Cliente"] = $deudor_id;
        $cambios["Prima_neta"] = $prima_neta;
        $cambios["ISC"] = $isc;
        $cambios["Prima_total"] = $prima_total;
        $cambios["Aseguradora"] = $_POST["aseguradora_id"];
        //$cambios["Coberturas"] = $coberturas_id;
        $cambios["Comisi_n_socio"] = round($comision_socio, 2);
        $cambios["Amount"] = round($comision_nobe, 2);
        $cambios["Comisi_n_aseguradora"] = round($comision_aseguradora, 2);
        actualizar("Deals", $id, $cambios);

        $ruta = "public/path";
        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta/$name");
        adjuntar("Deals", $id, "$ruta/$name");
        unlink("$ruta/$name");

        header("Location:" . constant("url") . "emisiones/detallesVida/$id");
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

<form enctype="multipart/form-data" class="row" method="POST" 
      action="<?= constant("url") ?>cotizaciones/emitirVida/<?= $id ?>">

    <div class="mx-auto col-10" style="width: 200px;">

        <h5>Deudor</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nombre</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="nombre" value="<?= $trato->getFieldValue('Nombre') ?>">
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

        <?php if ($trato->getFieldValue('Edad_codeudor') != null) : ?>
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
                    $criteria = "Deal_Name:equals:" . $trato->getEntityId();
                    $cotizaciones = listaPorCriterio("Quotes", $criteria);
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
        <a href="<?= constant("url") ?>cotizaciones/emitirVida/<?= $id ?>" class="btn btn-info">Cancelar</a>

    </div>
</form>

<br><br>