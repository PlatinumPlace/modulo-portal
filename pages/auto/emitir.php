<?php

$api = new api;

$url = rtrim($_GET['url'], "/");
$url = explode('/', $url);
$id = $url[2];

$resumen = $api->getRecord("Deals", $id);
$criterio = "Deal_Name:equals:" . $id;
$detalles =$api->searchRecordsByCriteria("Quotes", $criterio);

$emitida = array("Emitido", "En trámite");

if (
    empty($resumen)
    or
    empty($detalles)
    or
    $resumen->getFieldValue("Stage") == "Abandonada"
) {
    header("Location:" . constant("url") . "cotizaciones/error");
    exit();
}

if ($_POST) {

    $ruta_cotizacion = "tmp";
    if (!is_dir($ruta_cotizacion)) {
        mkdir($ruta_cotizacion, 0755, true);
    }

    if (!empty($_FILES["cotizacion_firmada"]["name"])) {

        $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
        $permitido = array("pdf");

        if (in_array($extension, $permitido)) {

            $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
            $name = basename($_FILES["cotizacion_firmada"]["name"]);
            move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");

            $api->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");

            unlink("$ruta_cotizacion/$name");

            $cambios["Aseguradora"] = $_POST["aseguradora_id"];
            $cambios["Stage"] = "En trámite";
            $cambios["Deal_Name"] = "Resumen";
            $api->updateRecord("Deals", $id, $cambios);

            $alerta = "Póliza emitida,descargue la previsualizacion para obtener el carnet. ";
        } else {
            $alerta = "Error al cargar documentos, solo se permiten archivos PDF.";
        }
    } else if (!empty($_FILES["documentos"]['name'][0])) {

        foreach ($_FILES["documentos"]["error"] as $key => $error) {

            if ($error == UPLOAD_ERR_OK) {

                $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                $name = basename($_FILES["documentos"]["name"][$key]);
                move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");

                $api->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");

                unlink("$ruta_cotizacion/$name");
            }
        }

        $alerta = "Documentos adjuntados";
    }

    header("Location:" . constant("url") . "cotizaciones/redirigir/auto-detalles-$id-$alerta");
    exit;
}

require_once("pages/template/header_auto.php");

?>
<div class="card">
    <div class="card-body">
        <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/emitir/<?= $id ?>">

            <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>

                <h5>Aseguradora</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Nombre</label>
                        <select name="aseguradora_id" class="form-control" required>
                            <option value="" selected disabled>Selecciona una Aseguradora</option>
                            <?php
                            foreach ($detalles as $resumen) {
                                if ($resumen->getFieldValue('Grand_Total') > 0) {
                                    echo '<option value="' . $resumen->getFieldValue('Aseguradora')->getEntityId() . '">' . $resumen->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Cotización Firmada</label>
                        <input type="file" class="form-control-file" name="cotizacion_firmada" required>
                    </div>
                </div>

            <?php else : ?>

                <h5>Adjuntar documentos a la cotización</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Expedientes</label>
                        <input type="file" class="form-control-file" multiple name="documentos[]" required>
                    </div>
                </div>

            <?php endif ?>

            <br>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" name="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>

        </form>
    </div>
</div>