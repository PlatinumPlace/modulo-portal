<?php
$cotizaciones = new cotizaciones;
$url = obtener_url();

if (empty($url[0])) {
    require_once "pages/error.php";
    exit();
}

$detalles_resumen = $cotizaciones->detalles_resumen($url[0]);
$lista_cotizaciones = $cotizaciones->lista_cotizaciones_asosiadas($url[0]);

if (empty($lista_cotizaciones)) {
    $alerta = "No existen cotizaciones.";
}

$alerta = (isset($url[1])) ? $url[1] : null;

if (empty($detalles_resumen) or $detalles_resumen->getFieldValue("Stage") == "Abandonada") {
    require_once "pages/error.php";
    exit();
}

if ($_POST) {
    $ruta = "public/tmp";
    if (!is_dir($ruta)) {
        mkdir($ruta, 0755, true);
    }

    if (!empty($_FILES["cotizacion_firmada"]["name"])) {

        $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
        $permitido = array("pdf");
        if (!in_array($extension, $permitido)) {
            $alerta = "Para emitir,solo se admiten documentos PDF.";
        } else {
            $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
            $name = basename($_FILES["cotizacion_firmada"]["name"]);
            move_uploaded_file($tmp_name, "$ruta/$name");

            $cotizaciones->adjuntar_resumen($url[0], "$ruta/$name");
            unlink("$ruta/$name");

            foreach ($lista_cotizaciones as $cotizacion) {
                if ($cotizacion->getEntityId() != $_POST["cotizacion_id"]) {
                    $cotizaciones->eliminar_cotizacion($cotizacion->getEntityId());
                } else {
                    $prima = $cotizacion->getFieldValue('Grand_Total');
                    $detalles_contrato = $cotizaciones->detalles_contrato($cotizacion->getFieldValue('Contrato')->getEntityId());
                    $aseguradora_id = $cotizacion->getFieldValue('Aseguradora')->getEntityId();
                    $num_poliza = $detalles_contrato->getFieldValue('No_P_liza');
                }
            }

            $cliente_nuevo["Apellido"] = $detalles_resumen->getFieldValue('Apellidos');
            $cliente_nuevo["Aseguradora"] = $aseguradora_id;
            $cliente_nuevo["Email"] = $detalles_resumen->getFieldValue('Email');
            $cliente_nuevo["Direcci_n"] = $detalles_resumen->getFieldValue('Direcci_n');
            $cliente_nuevo["Fecha_de_Nacimiento"] = $detalles_resumen->getFieldValue('Fecha_de_Nacimiento');
            $cliente_nuevo["Informar_a"] = $_SESSION["usuario"]['id'];
            $cliente_nuevo["Name"] = $detalles_resumen->getFieldValue('Nombre');
            $cliente_nuevo["Socio"] = $_SESSION["usuario"]['empresa_id'];
            $cliente_nuevo["RNC_C_dula"] = $detalles_resumen->getFieldValue('RNC_Cedula');
            $cliente_nuevo["Tel"] = $detalles_resumen->getFieldValue('Telefono');
            $cliente_nuevo["Tel_Residencia"] = $detalles_resumen->getFieldValue('Tel_Residencia');
            $cliente_nuevo["Tel_Trabajo"] = $detalles_resumen->getFieldValue('Tel_Trabajo');

            $cliente_nuevo_id = $cotizaciones->crear_cliente($cliente_nuevo);

            $poliza_nueva["Name"] = $num_poliza;
            $poliza_nueva["Estado"] =  true;
            $poliza_nueva["Plan"] =  $detalles_resumen->getFieldValue('Plan');
            $poliza_nueva["Prima"] =  $prima;
            $poliza_nueva["Propietario"] =  $cliente_nuevo_id;
            $poliza_nueva["Ramo"] = "Automóvil";
            $poliza_nueva["Socio"] =  $_SESSION["usuario"]['empresa_id'];
            $poliza_nueva["Tipo"] =  $detalles_resumen->getFieldValue('Tipo_de_poliza');
            $poliza_nueva["Valor_Aseguradora"] =   $detalles_resumen->getFieldValue('Valor_Asegurado');
            $poliza_nueva["Vigencia_desde"] =  date("Y-m-d", strtotime($detalles_resumen->getFieldValue('Fecha_de_emisi_n')));
            $poliza_nueva["Vigencia_hasta"] =  date("Y-m-d", strtotime($detalles_resumen->getFieldValue('Closing_Date')));

            $poliza_nueva_id = $cotizaciones->crear_poliza($poliza_nueva);

            $nuevo_bien["A_o"] = $detalles_resumen->getFieldValue('A_o_de_Fabricacion');
            $nuevo_bien["Chasis"] =  $detalles_resumen->getFieldValue('Chasis');
            $nuevo_bien["Color"] =  $detalles_resumen->getFieldValue('Color');
            $nuevo_bien["Marca"] =  $detalles_resumen->getFieldValue('Marca')->getLookupLabel();
            $nuevo_bien["Modelo"] =  $detalles_resumen->getFieldValue('Modelo')->getLookupLabel();
            $nuevo_bien["Name"] = $detalles_resumen->getFieldValue('Chasis');
            $nuevo_bien["Placa"] =  $detalles_resumen->getFieldValue('Placa');
            $nuevo_bien["P_liza"] =  $poliza_nueva_id;
            $nuevo_bien["Tipo"] =   "Automóvil";
            $nuevo_bien["Tipo_de_veh_culo"] =  $detalles_resumen->getFieldValue('Tipo_de_Veh_culo');

            $nuevo_bien_id = $cotizaciones->crear_bien($nuevo_bien);

            $cambios_cotizacion["Quote_Stage"] =  "Confirmada";
            $cambios_cotizacion["Fecha_de_emisi_n"] =  date("Y-m-d");
            $cambios_cotizacion["Valid_Till"] =  date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
            $cambios_cotizacion["P_liza"] =   $poliza_nueva_id;

            $cotizaciones->guardar_cambios_cotizacion($cambios_cotizacion, $_POST["cotizacion_id"]);


            $cambios_resumen["Stage"] =  "En trámite";
            $cambios_resumen["Deal_Name"] =  "Resumen";
            $cambios_resumen["Closing_Date"] =  date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
            $cambios_resumen["Fecha_de_emisi_n"] =   date("Y-m-d");
            $cambios_resumen["Amount"] =   round($prima * $detalles_contrato->getFieldValue('Comisi_n_GrupoNobe') / 100, 2);
            $cambios_resumen["P_liza"] =   $poliza_nueva_id;

            $cotizaciones->guardar_cambios_resumen($cambios_resumen, $url[0]);

            $alerta = "Cotizacion emitida,descargue la previsualizacion para obtener el carnet.";
            header("Location:" . constant("url") . "auto/detalles/" . $url[0] . "/$alerta");
            exit();
        }
    } else if (!empty($_FILES["documentos"]['name'][0])) {
        foreach ($_FILES["documentos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                $name = basename($_FILES["documentos"]["name"][$key]);
                move_uploaded_file($tmp_name, "$ruta/$name");
                $cotizaciones->adjuntar_resumen($url[0], "$ruta/$name");
                unlink("$ruta/$name");
            }
        }
        
        header("Location:" . constant("url") . "auto/detalles/" . $url[0] . "/Documentos Adjuntados.");
        exit();
    }
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
        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>
        <div class="card mb-4">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/emitir/<?= $url[0] ?>">
                    <div class="form-row">
                        <?php if (in_array($detalles_resumen->getFieldValue("Stage"), array("Emitido", "En trámite"))) : ?>
                            <div class="col-md-6">
                                <label class="font-weight-bold">
                                    Documentos <br> <small>(Manten presionado Ctrl para seleccionar varios archivos)</small>
                                </label>
                                <input type="file" class="form-control-file" multiple name="documentos[]" required>
                            </div>
                        <?php else : ?>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Aseguradora</label>
                                <select name="cotizacion_id" class="form-control" required>
                                    <option value="" selected disabled>Selecciona una Aseguradora</option>
                                    <?php foreach ($lista_cotizaciones as $cotizacion) : ?>
                                        <?php if ($cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                                            <option value="<?= $cotizacion->getEntityId() ?>"><?= $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Cotización Firmada</label>
                                <input type="file" class="form-control-file" name="cotizacion_firmada" required>
                            </div>
                        <?php endif ?>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <button type="submit" class="btn btn-success">Emitir</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'pages/layout/footer_main.php'; ?>