<?php

class CotizacionesController
{
    public $cotizacion;
    public $contrato;

    function __construct()
    {
        $this->cotizacion = new cotizacion;
        $this->contrato = new contrato;
    }

    public function buscar_cotizaciones()
    {
        if (isset($_POST['submit'])) {
            $cotizaciones = $this->cotizacion->buscar($_POST['parametro'], $_POST['busqueda']);
        } else {
            $cotizaciones = $this->cotizacion->lista();
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/buscar_cotizaciones.php");
        require_once("core/views/template/footer.php");
    }

    public function emisiones_mensuales()
    {
        $cotizaciones = $this->cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/emisiones_mensuales.php");
        require_once("core/views/template/footer.php");
    }

    public function cotizaciones_pendientes()
    {
        $cotizaciones = $this->cotizacion->lista();

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/cotizaciones_pendientes.php");
        require_once("core/views/template/footer.php");
    }

    public function vencimientos_mensuales()
    {
        $cotizaciones = $this->cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/vencimientos_mensuales.php");
        require_once("core/views/template/footer.php");
    }

    public function emitir_cotizacion($id)
    {
        $resultado = $this->cotizacion->detalles($id);
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

                    $this->cotizacion->adjuntar_archivos($id, "$ruta_cotizacion/$name");

                    unlink("$ruta_cotizacion/$name");

                    $cambios["Aseguradora"] = $_POST["aseguradora"];
                    $cambios["Stage"] = "En trámite";
                    $cambios["Deal_Name"] = "Resumen";
                    $this->cotizacion->actualizar($id, $cambios);

                    $direccion = strtolower($cotizacion->getFieldValue("Type")) . "/" . "descargar_cotizacion/" . $id;
                    $alerta =
                        "Póliza emitida,descargue la previsualizacion para obtener el carnet. "
                        .
                        '<a href="' . constant("url") . 'home/reedirigir_controlador/' . $direccion . '" class="btn btn-link">Descargar</a>';
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

                        $this->cotizacion->adjuntar_archivos($id, "$ruta_cotizacion/$name");

                        unlink("$ruta_cotizacion/$name");
                    }
                }

                $alerta = "Archivos Adjuntados.";
            }
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/emitir_cotizacion.php");
        require_once("core/views/template/footer.php");
    }

    public function exportar_cotizaciones()
    {
        $contratos = $this->contrato->lista_aseguradoras();

        if (isset($_POST["csv"])) {

            if ($_POST['tipo_reporte'] == "emisiones") {
                $resultado = $this->cotizacion->exportar_csv_emisiones($_POST["tipo_cotizacion"], $_POST["contrato_id"], $_POST["desde"], $_POST["hasta"]);
            }
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/exportar_cotizaciones.php");
        require_once("core/views/template/footer.php");
    }
}
