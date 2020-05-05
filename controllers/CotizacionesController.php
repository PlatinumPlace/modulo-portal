<?php
class CotizacionesController
{
    function __construct()
    {
        $this->cotizacion = new cotizacion;
    }
    public function buscar($filtro = null)
    {
        if (isset($_POST['submit'])) {
            $cotizaciones = $this->cotizacion->buscar_cotizaciones($_POST['parametro'], $_POST['busqueda']);
            if (empty($cotizaciones)) {
                $alerta = "No se encontraron registros";
            }
        } else {
            $cotizaciones = $this->cotizacion->lista_cotizaciones();
        }
        require_once("views/template/header.php");
        require_once("views/Cotizaciones/buscar.php");
        require_once("views/template/footer.php");
    }
    public function crear_auto()
    {
        $marcas = $this->cotizacion->obtener_marcas();
        sort($marcas);
        if (isset($_POST['submit'])) {
            $nuevo = $this->cotizacion->nueva_cotizacion();
            $nuevo["Type"] = "Auto";
            $id = $this->cotizacion->guardar_cotizacion(null, $nuevo);
            $direccion = 'cotizaciones-detalles_auto-' . $id;
            header("Location:" . constant('url') . 'home/cargando/' . $direccion);
            exit;
        }
        require_once("views/template/header.php");
        require_once("views/Cotizaciones/crear_auto.php");
        require_once("views/template/footer.php");
    }
    public function detalles_auto($id = null)
    {
        $resumen = $this->cotizacion->resumen_detalles($id);
        if (empty($resumen)) {
            $alerta = "No se encontro el registro";
            header("Location: " . constant('url') . "home/error/" . $alerta);
            exit();
        }
        $cotizaciones =  $this->cotizacion->obtener_cotizaciones($id);
        if (empty($cotizaciones)) {
            $alerta = "No se encontraron cotizaciones";
            header("Location: " . constant('url') . "home/error/" . $alerta);
            exit();
        }
        $emitida = array("Emitido", "En trámite");
        require_once("views/template/header.php");
        require_once("views/Cotizaciones/detalles_auto.php");
        require_once("views/template/footer.php");
    }
    public function completar_auto($id = null)
    {
        $resumen = $this->cotizacion->resumen_detalles($id);
        if (empty($resumen)) {
            $alerta = "No se encontro el registro";
            header("Location: " . constant('url') . "home/error/" . $alerta);
            exit();
        }
        if (isset($_POST['submit'])) {
            $nuevo = $this->cotizacion->nueva_cotizacion();
            $this->cotizacion->guardar_cotizacion($id, $nuevo);
            header("Location:" . constant('url') . 'cotizaciones/detalles_auto/' . $id);
            exit;
        }
        require_once("views/template/header.php");
        require_once("views/Cotizaciones/completar_auto.php");
        require_once("views/template/footer.php");
    }
    public function descargar_auto($id = null)
    {
        $resumen = $this->cotizacion->resumen_detalles($id);
        if (empty($resumen)) {
            $alerta = "No se encontro el registro";
            header("Location: " . constant('url') . "home/error/" . $alerta);
            exit();
        }
        $cotizaciones =  $this->cotizacion->obtener_cotizaciones($id);
        if (empty($cotizaciones)) {
            $alerta = "No se encontraron cotizaciones";
            header("Location: " . constant('url') . "home/error/" . $alerta);
            exit();
        }
        $emitida = array("Emitido", "En trámite");
        if (in_array($resumen->getFieldValue("Stage"), $emitida)) {
            $imagen_aseguradora = $this->cotizacion->obtener_imagen_aseguradora($resumen->getFieldValue('Aseguradora')->getEntityId());
            $cotizacion = $this->cotizacion->cotizacion_detalles($id);
            $aseguradora = $this->cotizacion->aseguradora_detalles($resumen->getFieldValue('Aseguradora')->getEntityId());
            $contrato = $this->cotizacion->detalles_contrato($cotizacion->getFieldValue('Contrato')->getEntityId());
        }
        require_once("views/Cotizaciones/descargar_auto.php");
    }
    public function emitir($id = null)
    {
        $resumen = $this->cotizacion->resumen_detalles($id);
        if (empty($resumen)) {
            $alerta = "No se encontro el registro";
            header("Location: " . constant('url') . "home/error/" . $alerta);
            exit();
        }
        $cotizaciones =  $this->cotizacion->obtener_cotizaciones($id);
        if (empty($cotizaciones)) {
            $alerta = "No se encontraron cotizaciones";
            header("Location: " . constant('url') . "home/error/" . $alerta);
            exit();
        }
        $emitida = array("Emitido", "En trámite");
        if (isset($_POST['submit'])) {
            if (!empty($_FILES["cotizacion_firmada"]["name"])) {
                $cambios["Aseguradora"] = $_POST["aseguradora"];
                $cambios["Stage"] = "En trámite";
                $cambios["Deal_Name"] = "Resumen";
                $this->cotizacion->guardar_cotizacion($id, $cambios);
                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                $permitido = array("pdf");
                if (in_array($extension, $permitido)) {
                    $this->cotizacion->adjuntar_documento($id);
                    $direccion = 'cotizaciones-descargar_' . $resumen->getFieldValue("Type") . "-" . $id;
                    $alerta =
                        "Póliza emitida,descargue la previsualizacion para obtener el carnet. "
                        .
                        '<a href="' . constant("url") . 'home/cargando/' . $direccion . '" class="btn btn-link">Descargar</a>';
                } else {
                    $alerta = "Error al cargar documentos, solo se permiten archivos PDF.";
                }
            }
            if (!empty($_FILES["documentos"]['name'][0])) {
                $this->cotizacion->adjuntar_varios_documentos($id);
                $alerta = "Archivos Adjuntados.";
            }
        }
        require_once("views/template/header.php");
        require_once("views/Cotizaciones/emitir.php");
        require_once("views/template/footer.php");
    }
}
