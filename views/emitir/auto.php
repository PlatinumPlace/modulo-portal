<?php
if (!empty($_FILES["cotizacion_firmada"]["name"])) {
    $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
    $permitido = array("pdf");
    if (!in_array($extension, $permitido)) {
        $alerta = "Para emitir solo se admiten documentos PDF";
    } else {
        $planes = $cotizacion->getLineItems();
        foreach ($planes as $plan) {
            if ($plan->getDescription() == $_POST["aseguradora"]) {
                $plan_id = $plan->getProduct()->getEntityId();
                $prima = $plan->getNetTotal();
                $prima_neta = $plan->getListPrice();
                $isc = $plan->getTaxAmount();
            }
        }

        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
        $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
        foreach ($contratos as $contrato) {
            if ($contrato->getFieldValue("Plan")->getEntityId() == $plan_id) {
                $poliza = $contrato->getFieldValue('No_P_liza');
                $comision_nobe = $prima * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                $comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                $comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                $contrato_id = $contrato->getEntityId();
            }
        }

        $plan_detalles = $api->getRecord("Products", $plan_id);

        $cliente_nuevo["Vendor_Name"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
        $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
        $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cliente_nuevo["Mailing_Street"] = $_POST["direccion"];
        $cliente_nuevo["First_Name"] = $_POST["nombre"];
        $cliente_nuevo["Last_Name"] = $_POST["apellido"];
        $cliente_nuevo["Mobile"] = $_POST["telefono"];
        $cliente_nuevo["Phone"] = $_POST["tel_residencia"];
        $cliente_nuevo["Tel_Trabajo"] = $_POST["tel_trabajo"];
        $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
        $cliente_nuevo["Email"] = $_POST["correo"];
        $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cliente_nuevo["Tipo"] = "Cliente";
        $cliente_nuevo_id = $api->createRecords("Contacts", $cliente_nuevo);

        $poliza_nueva["Name"] = $poliza;
        $poliza_nueva["Estado"] = true;
        $poliza_nueva["Plan"] = $cotizacion->getFieldValue('Subject');
        $poliza_nueva["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
        $poliza_nueva["Prima"] = round($prima, 2);
        $poliza_nueva["Deudor"] = $cliente_nuevo_id;
        $poliza_nueva["Ramo"] = "Automóvil";
        $poliza_nueva["Socio"] = $_SESSION["usuario"]['empresa_id'];
        $poliza_nueva["Tipo"] = $cotizacion->getFieldValue('Tipo_P_liza');
        $poliza_nueva["Valor_Aseguradora"] = $cotizacion->getFieldValue('Valor_Asegurado');
        $poliza_nueva["Vigencia_desde"] = date("Y-m-d");
        $poliza_nueva["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
        $poliza_nueva_id = $api->createRecords("P_lizas", $poliza_nueva);

        $nuevo_bien["A_o"] = $cotizacion->getFieldValue('A_o_Fabricaci_n');
        $nuevo_bien["Color"] = $_POST["color"];
        $nuevo_bien["Marca"] = $cotizacion->getFieldValue('Marca')->getLookupLabel();
        $nuevo_bien["Modelo"] = $cotizacion->getFieldValue('Modelo')->getLookupLabel();
        $nuevo_bien["Name"] = $_POST["chasis"];
        $nuevo_bien["Placa"] = $_POST["placa"];
        $nuevo_bien["Uso"] = $cotizacion->getFieldValue('Uso_Veh_culo');
        $nuevo_bien["Condicion"] = ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado";
        $nuevo_bien["P_liza"] = $poliza_nueva_id;
        $nuevo_bien["Tipo"] = "Automóvil";
        $nuevo_bien["Tipo_de_veh_culo"] = $cotizacion->getFieldValue('Tipo_Veh_culo');
        $nuevo_bien_id = $api->createRecords("Bienes", $nuevo_bien);

        $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
        $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
        $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $nuevo_trato["Stage"] = "En trámite";
        $nuevo_trato["Fecha_de_emisi_n"] = date("Y-m-d");
        $nuevo_trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $nuevo_trato["Type"] = "Auto";
        $nuevo_trato["Valor_Asegurado"] = $cotizacion->getFieldValue('Valor_Asegurado');
        $nuevo_trato["P_liza"] = $poliza_nueva_id;
        $nuevo_trato["Bien"] = $nuevo_bien_id;
        $nuevo_trato["Cliente"] = $cliente_nuevo_id;
        $nuevo_trato["Contrato"] = $contrato_id;
        $nuevo_trato["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
        $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
        $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
        $nuevo_trato["Amount"] = round($comision_nobe, 2);
        $nuevo_trato["Prima_Total"] = round($prima, 2);
        $nuevo_trato["Prima_Neta"] = round($prima_neta, 2);
        $nuevo_trato["ISC"] = round($isc, 2);
        $nuevo_trato["Lead_Source"] = "Portal";
        $nuevo_trato_id = $api->createRecords("Deals", $nuevo_trato);

        $ruta = "public/path";
        if (!is_dir($ruta)) {
            mkdir($ruta, 0755, true);
        }
        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta/$name");
        $api->uploadAttachment("Deals", $nuevo_trato_id, "$ruta/$name");
        unlink("$ruta/$name");

        $cambios_cotizacion["Quote_Stage"] = "Emitida";
        $cambios_cotizacion["Fecha_emisi_n"] = date("Y-m-d");
        $cambios_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $cambios_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cambios_cotizacion["Nombre"] = $_POST["nombre"];
        $cambios_cotizacion["Apellido"] = $_POST["apellido"];
        $cambios_cotizacion["Direcci_n"] = $_POST["direccion"];
        $cambios_cotizacion["Tel_Celular"] = $_POST["telefono"];
        $cambios_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
        $cambios_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
        $cambios_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
        $cambios_cotizacion["Correo"] = $_POST["correo"];
        $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;
        $plan_seleccionado[] = array(
            "id" => $plan_id,
            "prima" => $prima,
            "cantidad" => 1,
            "descripcion" => $plan_detalles->getFieldValue("Vendor_Name")->getLookupLabel(),
            "impuesto" => "ITBIS 16",
            "impuesto_valor" => 16
        );
        $api->update("Quotes", $cotizacion->getEntityId(), $cambios_cotizacion, $plan_seleccionado);
        header("Location:" . constant("url") . "detalles/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
        exit();
    }
}
require_once 'views/layout/header.php';
?>
<h2 class="mt-4 text-uppercase text-center">emitir cotización</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>detalles/<?= $cotizacion->getEntityId() ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <div class="card mb-4">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>emitir/<?= $cotizacion->getEntityId() ?>">

                    <h4>Deudor</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" name="rnc_cedula" value="<?= $cotizacion->getFieldValue('RNC_C_dula') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" name="nombre" value="<?= $cotizacion->getFieldValue('Nombre') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="apellido" value="<?= $cotizacion->getFieldValue('Apellido') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="direccion" value="<?= $cotizacion->getFieldValue('Direcci_n') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="telefono" value="<?= $cotizacion->getFieldValue('Tel_Celular') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="tel_residencia" value="<?= $cotizacion->getFieldValue('Tel_Residencial') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="tel_trabajo" value="<?= $cotizacion->getFieldValue('Tel_Trabajo') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="correo" value="<?= $cotizacion->getFieldValue('Correo') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?= $cotizacion->getFieldValue('Fecha_Nacimiento') ?>">
                        </div>
                    </div>

                    <br>
                    <h4>Vehículo</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Chasis</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" name="chasis">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Color</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="color">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Placa</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="placa">
                        </div>
                    </div>

                    <br>
                    <h4>Emitir con:</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Aseguradora</label>
                        <div class="col-sm-9">
                            <select required name="aseguradora" class="form-control">
                                <option value="" selected disabled>Selecciona una Aseguradora</option>
                                <?php
                                $planes = $cotizacion->getLineItems();
                                foreach ($planes as $plan) {
                                    if ($plan->getNetTotal() > 0) {
                                        echo '<option value="' . $plan->getDescription() . '">' . $plan->getDescription() . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Cotización Firmada</label>
                        <div class="col-sm-9">
                            <input required type="file" class="form-control-file" name="cotizacion_firmada">
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-success">Emitir</button>
                    |
                    <a href="<?= constant("url") ?>detalles/<?= $cotizacion->getEntityId() ?>" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>