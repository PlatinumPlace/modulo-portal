<?php

class CotizacionesController
{
    public $cotizacion;
    public $cliente;
    public $auto;

    function __construct()
    {
        $this->cotizacion = new cotizacion;
    }

    public function buscar()
    {
        if (isset($_POST['submit'])) {
            $cotizaciones = $this->cotizacion->buscar($_POST['parametro'], $_POST['busqueda']);
        } else {
            $cotizaciones = $this->cotizacion->lista();
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/buscar.php");
        require_once("core/views/template/footer.php");
    }

    public function emisiones()
    {
        $cotizaciones = $this->cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/emisiones.php");
        require_once("core/views/template/footer.php");
    }

    public function pendientes()
    {
        $cotizaciones = $this->cotizacion->lista();

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/pendientes.php");
        require_once("core/views/template/footer.php");
    }

    public function vencimientos()
    {
        $cotizaciones = $this->cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/vencimientos.php");
        require_once("core/views/template/footer.php");
    }

    public function emitir($id)
    {
        $cotizaciones = new cotizacion;
        $contrato = new contrato;

        $resultado = $cotizaciones->detalles($id);
        $cotizacion =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];

        if (
            $cotizacion->getFieldValue('Nombre') == null
            or
            empty($cotizacion)
            or
            $cotizacion->getFieldValue('Stage') == "Abandonado"
        ) {
            header("Location: " . constant('url') . "home/error");
            exit();
        }

        $emitida = array("Emitido", "En trámite");

        if (isset($_POST['submit'])) {

            $ruta_cotizacion = "public/tmp";
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

                    $cotizaciones->adjuntar_archivos($id, "$ruta_cotizacion/$name");

                    unlink("$ruta_cotizacion/$name");

                    $cambios["Aseguradora"] = $_POST["aseguradora"];
                    $cambios["Stage"] = "En trámite";
                    $cambios["Deal_Name"] = "Resumen";
                    $cotizaciones->actualizar($id, $cambios);

                    $direccion = 'cotizaciones-descargar_' . $cotizacion->getFieldValue("Type") . "-" . $id;
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

                        $cotizaciones->adjuntar_archivos($id, "$ruta_cotizacion/$name");

                        unlink("$ruta_cotizacion/$name");
                    }
                }

                $alerta = "Archivos Adjuntados.";
            }
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/emitir.php");
        require_once("core/views/template/footer.php");
    }

    public function exportar()
    {
        $aseguradora = new aseguradora;
        $cotizacion = new cotizacion;

        $aseguradoras = $aseguradora->lista();

        if (isset($_POST["csv"])) {

            if ($_POST['tipo_reporte'] == "emisiones") {

                $resultado = $cotizacion->exportar_csv_emisiones($_POST["tipo_cotizacion"], $_POST["aseguradpra_id"], $_POST["desde"], $_POST["hasta"]);
            }
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/exportar.php");
        require_once("core/views/template/footer.php");
    }
}
