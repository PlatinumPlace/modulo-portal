<?php
if ($_POST) {
    $edad_deudor = calcular_edad($_POST["fecha_nacimiento"]);
    $edad_codeudor = (!empty($_POST["fecha_codeudor"])) ?  calcular_edad($_POST["fecha_codeudor"]) : null;
    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Vida))";
    $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
    foreach ($contratos as $contrato) {
        $prima = 0;

        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $api->searchRecordsByCriteria("Tasas", $criterio);
        foreach ($tasas as $tasa) {
            switch ($tasa->getFieldValue('Tipo')) {
                case 'Deudor':
                    $tasa_deudor = $tasa->getFieldValue('Valor');
                    break;

                case 'Codeudor':
                    $tasa_codeudor = $tasa->getFieldValue('Valor');
                    break;

                case 'Vida':
                    $tasa_vida = $tasa->getFieldValue('Valor');
                    break;

                case 'Desempleo':
                    $tasa_desempleo = $tasa->getFieldValue('Valor');
                    break;
            }
        }

        if (!empty($_POST["desempleo"])) {
            $cuota = (!empty($_POST["cuota"])) ? $_POST["cuota"] : 0;
            $prima = $_POST["valor"] / 1000 * ($tasa_vida / 100);
            $prima +=  $cuota / 1000 * $tasa_desempleo;
        } else {
            if (!empty($edad_codeudor)) {
                $prima += $_POST["valor"] / 1000 * (($tasa_codeudor - $tasa_deudor) / 100);
            } else {
                $prima = $_POST["valor"] / 1000 * ($tasa_deudor / 100);
            }
        }

        if (
            $edad_deudor > $contrato->getFieldValue('Edad_Max')
            or
            $edad_deudor < $contrato->getFieldValue('Edad_Min')
            or
            (!empty($edad_codeudor)
                and
                $edad_codeudor > $contrato->getFieldValue('Edad_Max')
                or
                $edad_codeudor < $contrato->getFieldValue('Edad_Min'))
        ) {
            $prima = 0;
        }

        $plan_seleccionado[] = array(
            "id" => $contrato->getFieldValue('Plan')->getEntityId(),
            "prima" => $prima,
            "cantidad" => 1,
            "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
            "impuesto" => "ITBIS 16",
            "impuesto_valor" => 16
        );
    }

    $nueva_cotizacion["Subject"] = "Plan Vida";
    $nueva_cotizacion["Fecha_Nacimiento_Codeudor"] = $_POST["fecha_codeudor"];
    $nueva_cotizacion["Quote_Stage"] = "Cotizando";
    $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
    $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
    $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
    $nueva_cotizacion["Tipo_P_liza"] = "Declarativa";
    $nueva_cotizacion["Plan"] = "Vida";
    $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
    $nueva_cotizacion["Plazo"] =  $_POST["plazo"];
    $nueva_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
    $nueva_cotizacion["Nombre"] = $_POST["nombre"];
    $nueva_cotizacion["Apellido"] = $_POST["apellido"];
    $nueva_cotizacion["Direcci_n"] = $_POST["direccion"];
    $nueva_cotizacion["Tel_Celular"] = $_POST["telefono"];
    $nueva_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
    $nueva_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
    $nueva_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
    $nueva_cotizacion["Correo"] = $_POST["correo"];
    $nueva_cotizacion["Cuota_Men"] =  $_POST["cuota"];

    $nuevo_cotizacion_id = $api->createRecords("Quotes", $nueva_cotizacion, $plan_seleccionado);
    header("Location:" . constant("url") . "detalles/$nuevo_cotizacion_id");
    exit();
}



require_once 'views/layout/header.php';
?>
<h1 class="mt-4 text-uppercase text-center">crear cotización vida/desempleo</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>crear/vida">Crear Vida</a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>crear/vida">

                    <h4>Deudor</h4>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">RNC/cédula</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="rnc_cedula">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" name="nombre">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="apellido">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="direccion">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="telefono">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="tel_residencia">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="tel_trabajo">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                        <div class="col-sm-9">
                            <input required type="date" class="form-control" name="fecha_nacimiento">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="correo">
                        </div>
                    </div>

                    <br>
                    <h4>Plan</h4>
                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label font-weight-bold">Desempleo</div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="desempleo">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Valor Asegurado</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" name="valor">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Plazo en meses</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" name="plazo">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Cuota Mensual</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="cuota">
                        </div>
                    </div>

                    <br>
                    <h4>Codeudor</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="fecha_codeudor">
                        </div>
                    </div>


                    <br>
                    <button type="submit" class="btn btn-primary">Crear</button>
                    |
                    <a href="<?= constant("url") ?>crear" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>