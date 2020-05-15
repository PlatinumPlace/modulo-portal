<?php

class CotizacionesController
{

    public function buscar()
    {
        $cotizacion = new cotizacion;

        if (isset($_POST['submit'])) {
            $cotizaciones = $cotizacion->buscar($_POST['parametro'], $_POST['busqueda']);
        } else {
            $cotizaciones = $cotizacion->lista();
        }

        require_once("views/template/header.php");
        require_once("views/cotizaciones/buscar.php");
        require_once("views/template/footer.php");
    }

    public function emisiones()
    {
        $cotizacion = new cotizacion;

        $cotizaciones = $cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("views/template/header.php");
        require_once("views/cotizaciones/emisiones.php");
        require_once("views/template/footer.php");
    }

    public function pendientes()
    {
        $cotizacion = new cotizacion;

        $cotizaciones = $cotizacion->lista();

        require_once("views/template/header.php");
        require_once("views/cotizaciones/pendientes.php");
        require_once("views/template/footer.php");
    }

    public function vencimientos()
    {
        $cotizacion = new cotizacion;

        $cotizaciones = $cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("views/template/header.php");
        require_once("views/cotizaciones/vencimientos.php");
        require_once("views/template/footer.php");
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

        require_once("views/template/header.php");
        require_once("views/cotizaciones/emitir.php");
        require_once("views/template/footer.php");
    }

    public function crear_auto()
    {
        $cotizacion = new cotizacion;
        $auto = new auto;

        $marcas = $auto->lista_marcas();
        sort($marcas);

        if (isset($_POST['submit'])) {

            $nueva_cotizacion["Stage"] = "Cotizando";
            $nueva_cotizacion["Type"] = "Auto";
            $nueva_cotizacion["Lead_Source"] = "Portal GNB";
            $nueva_cotizacion["Deal_Name"] = "Cotización";
            $nueva_cotizacion["Contact_Name"] =  $_SESSION['usuario_id'];
            $nueva_cotizacion["Tipo_de_poliza"] = $_POST["Tipo_de_poliza"];
            $nueva_cotizacion["Plan"] = $_POST["Plan"];
            $nueva_cotizacion["Marca"] = $_POST["Marca"];
            $nueva_cotizacion["Modelo"] = $_POST["Modelo"];

            $modelo = $auto->modelo_detalles($_POST['Modelo']);

            $nueva_cotizacion["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
            $nueva_cotizacion["Valor_Asegurado"] = $_POST["Valor_Asegurado"];

            $nueva_cotizacion["A_o_de_Fabricacion"] = $_POST["A_o_de_Fabricacion"];
            $nueva_cotizacion["Chasis"] = (isset($_POST["Chasis"])) ? $_POST["Chasis"] : null;
            $nueva_cotizacion["Color"] = (isset($_POST["Color"])) ? $_POST["Color"] : null;
            $nueva_cotizacion["Uso"] = (isset($_POST["Uso"])) ? $_POST["Uso"] : null;
            $nueva_cotizacion["Placa"] = (isset($_POST["Placa"])) ? $_POST["Placa"] : null;
            $nueva_cotizacion["Es_nuevo"] = (isset($_POST["Es_nuevo"])) ? true : false;

            $id = $cotizacion->crear($nueva_cotizacion);

            $direccion = 'cotizaciones-detalles_auto-' . $id;
            header("Location:" . constant('url') . 'home/cargando/' . $direccion);
            exit;
        }

        require_once("views/template/header.php");
        require_once("views/cotizaciones/crear_auto.php");
        require_once("views/template/footer.php");
    }

    public function detalles_auto($id)
    {
        $cotizaciones = new cotizacion;

        $resultado = $cotizaciones->detalles($id);

        $cotizacion =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];
        $emitida = array("Emitido", "En trámite");

        if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {
            $documentos_adjuntos = $cotizaciones->lista_documentos_adjuntos($id);
        }

        require_once("views/template/header.php");
        require_once("views/cotizaciones/detalles_auto.php");
        require_once("views/template/footer.php");
    }

    public function completar_auto($id)
    {
        $cotizaciones = new cotizacion;
        $cliente = new cliente;

        $resultado = $cotizaciones->detalles($id);
        $cotizacion =  $resultado["oferta"];
        $clientes = $cliente->lista();
        sort($clientes);

        if (
            $cotizacion->getFieldValue('Nombre') != null
            or
            empty($cotizacion)
            or
            $cotizacion->getFieldValue('Stage') == "Abandonado"
        ) {
            header("Location: " . constant('url') . "home/error");
            exit();
        }

        if (isset($_POST['submit'])) {

            $cambios["Chasis"] = $_POST["Chasis"];
            $cambios["Color"] = $_POST["Color"];
            $cambios["Placa"] = $_POST["Placa"];

            if (!empty($_POST["mis_clientes"])) {

                $cliente_info = $cliente->detalles($_POST["mis_clientes"]);

                $cambios["Direcci_n"] = $cliente_info->getFieldValue("Mailing_Street");
                $cambios["Nombre"] = $cliente_info->getFieldValue("First_Name");
                $cambios["Apellido"] = $cliente_info->getFieldValue("Last_Name");
                $cambios["RNC_Cedula"] = $cliente_info->getFieldValue("RNC_C_dula");
                $cambios["Telefono"] = $cliente_info->getFieldValue("Phone");
                $cambios["Tel_Residencia"] = $cliente_info->getFieldValue("Home_Phone");
                $cambios["Tel_Trabajo"] = $cliente_info->getFieldValue("Tel_Trabajo");
                $cambios["Fecha_de_Nacimiento"] = $cliente_info->getFieldValue("Date_of_Birth");
                $cambios["Email"] = $cliente_info->getFieldValue("Email");
            } else {

                $cambios["Direcci_n"] = $_POST["Direcci_n"];
                $cambios["Nombre"] = $_POST["Nombre"];
                $cambios["Apellido"] = $_POST["Apellido"];
                $cambios["RNC_Cedula"] = $_POST["RNC_Cedula"];
                $cambios["Telefono"] = (isset($_POST["Telefono"])) ? $_POST["Telefono"] : null;
                $cambios["Tel_Residencia"] = (isset($_POST["Tel_Residencia"])) ? $_POST["Tel_Residencia"] : null;
                $cambios["Tel_Trabajo"] = (isset($_POST["Tel_Trabajo"])) ? $_POST["Tel_Trabajo"] : null;
                $cambios["Fecha_de_Nacimiento"] = $_POST["Fecha_de_Nacimiento"];
                $cambios["Email"] = $_POST["Email"];
            }

            $cotizaciones->actualizar($id, $cambios);

            header("Location:" . constant('url') . 'cotizaciones/detalles_auto/' . $id);
            exit;
        }

        require_once("views/template/header.php");
        require_once("views/cotizaciones/completar_auto.php");
        require_once("views/template/footer.php");
    }

    public function descargar_auto($id)
    {
        $cotizaciones = new cotizacion;
        $contrato = new contrato;
        $aseguradora = new aseguradora;

        $resultado = $cotizaciones->detalles($id);
        $cotizacion =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];
        $emitida = array("Emitido", "En trámite");

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

        if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

            $imagen_aseguradora = $aseguradora->foto($cotizacion->getFieldValue("Aseguradora")->getEntityId());

            foreach ($detalles as $resumen) {
                $coberturas = $contrato->detalles($resumen->getFieldValue('Contrato')->getEntityId());
            }
        }

        require_once("views/cotizaciones/descargar_auto.php");
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

        require_once("views/template/header.php");
        require_once("views/cotizaciones/exportar.php");
        require_once("views/template/footer.php");
    }
}
