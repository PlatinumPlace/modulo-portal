<?php

$cotizacion =  $api->obtener_registro("Deals", $datos);

if (empty($cotizacion) or $cotizacion->getFieldValue('Stage') == "Abandonado") {
    header("Location: " . constant('url') . "home/error/");
    exit();
}

$criterio = "Deal_Name:equals:" . $datos;
$cotizacion_detalles = $api->buscar_registro_por_criterio("Quotes", $criterio);

if (empty($cotizacion_detalles)) {
    header("Location: " . constant('url') . "home/error/");
    exit();
}

$emitida = array("Emitido", "En trámite");

if (isset($_POST['submit'])) {

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

            $api->subir_archivos("Deals", $datos, "$ruta_cotizacion/$name");
            
            unlink("$ruta_cotizacion/$name");

            $cambios["Aseguradora"] = $_POST["aseguradora"];
            $cambios["Stage"] = "En trámite";
            $cambios["Deal_Name"] = "Resumen";
            $api->modificar_registro("Deals", $cambios, $datos);

            $direccion = 'cotizaciones-descargar_' . $cotizacion->getFieldValue("Type") . "-" . $datos;
            $alerta =
                "Póliza emitida,descargue la previsualizacion para obtener el carnet. "
                .
                '<a href="' . constant("url") . 'home/cargando/' . $direccion . '" class="btn btn-link">Descargar</a>';
        } else {
            $alerta = "Error al cargar documentos, solo se permiten archivos PDF.";
        }
    }
    if (!empty($_FILES["documentos"]['name'][0])) {

        foreach ($_FILES["documentos"]["error"] as $key => $error) {

            if ($error == UPLOAD_ERR_OK) {

                $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                $name = basename($_FILES["documentos"]["name"][$key]);
                move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                $api->subir_archivos("Deals", $datos, "$ruta_cotizacion/$name");
                unlink("$ruta_cotizacion/$name");
            }
        }

        $alerta = "Archivos Adjuntados.";
    }
}


?>
<form enctype="multipart/form-data" method="POST" action="<?= constant('url') ?>cotizaciones/emitir/<?= $cotizacion->getEntityId() ?>">

    <?php if (isset($_POST['submit'])) : ?>

        <div class="alert alert-primary" role="alert">
            <?= $alerta ?>
        </div>

    <?php endif ?>

    <div class="card">
        <div class="card-body">

            <?php if (!isset($_POST['submit']) and !in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Aseguradora</label>
                    <div class="col-sm-6">
                        <select name="aseguradora" class="form-control" required>
                            <?php

                            foreach ($cotizacion_detalles as $resumen) {

                                if ($resumen->getFieldValue('Grand_Total') > 0) {

                                    $contrato = $api->obtener_registro("Contratos", $resumen->getFieldValue('Contrato')->getEntityId());

                                    echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getEntityId() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                }
                            }

                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="cotizacion" class="col-sm-3 col-form-label">Cotización Firmada</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" id="cotizacion" name="cotizacion_firmada" required>
                    </div>
                </div>

            <?php else : ?>

                <div class="form-group row">
                    <label for="expedientes" class="col-sm-2 col-form-label">Expedientes</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" id="expedientes" multiple name="documentos[]" required>
                    </div>
                </div>

            <?php endif ?>
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
                    <a href="<?= constant('url') ?>cotizaciones/detalles_<?= strtolower($cotizacion->getFieldValue("Type")) ?>/<?= $cotizacion->getEntityId() ?>" class="btn btn-primary">Detalles</a>
                    |
                    <button type="submit" name="submit" class="btn btn-success">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>