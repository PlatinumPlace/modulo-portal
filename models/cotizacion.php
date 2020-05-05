<?php
class cotizacion extends zoho_api
{
    function __construct()
    {
        parent::__construct();
    }
    public function total_mensual($usuario_id)
    {
        $criterio = "Contact_Name:equals:" . $usuario_id;
        $cotizaciones = $this->searchRecordsByCriteria("Deals", $criterio);
        $resultado["total"] = 0;
        $resultado["pendientes"] = 0;
        $resultado["emisiones"] = 0;
        $resultado["vencimientos"] = 0;
        $resultado["filtro_pendientes"] = "";
        $resultado["filtro_emisiones"] = "";
        $resultado["filtro_vencimientos"] = "";
        $emitida = array("Emitido", "En trámite");
        if (!empty($cotizaciones)) {
            foreach ($cotizaciones as $resumen) {
                $resultado["total"] += 1;
                if (
                    $resumen->getFieldValue("Stage") == "Cotizando"
                    and
                    date("Y-m", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                ) {
                    $resultado["pendientes"] += 1;
                    $resultado["filtro_pendientes"] = $resumen->getFieldValue("Stage");
                }
                if (
                    in_array($resumen->getFieldValue("Stage"), $emitida)
                    and
                    date("Y-m", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                ) {
                    $resultado["emisiones"] += 1;
                    $resultado["filtro_emiresultadosiones"] = $resumen->getFieldValue("Stage");
                }
                if (
                    in_array($resumen->getFieldValue("Stage"), $emitida)
                    and
                    date("Y-m", strtotime($resumen->getFieldValue("Closing_Date"))) == date('Y-m')
                ) {
                    $resultado["vencimientos"] += 1;
                    $resultado["filtro_vencimientos"] = $resumen->getFieldValue("Stage");
                }
            }
        }
        return $resultado;
    }
    public function buscar_cotizaciones($parametro, $busqueda)
    {
        $usuario_id = $_SESSION['usuario_id'];
        $criterio = "((Contact_Name:equals:$usuario_id) and ($parametro:equals:$busqueda))";
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }
    public function lista_cotizaciones()
    {
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }
    public function nueva_cotizacion()
    {
        $nuevo["Stage"] = "Cotizando";
        $nuevo["Lead_Source"] = "Portal GNB";
        $nuevo["Deal_Name"] = "Cotización";
        $nuevo["Contact_Name"] =  $_SESSION['usuario_id'];
        if (isset($_POST["Tipo_de_poliza"])) {
            $nuevo["Tipo_de_poliza"] = $_POST["Tipo_de_poliza"];
        }
        if (isset($_POST["Plan"])) {
            $nuevo["Plan"] = $_POST["Plan"];
        }
        if (isset($_POST["Marca"])) {
            $nuevo["Marca"] = $_POST["Marca"];
        }
        if (isset($_POST["Modelo"])) {
            $nuevo["Modelo"] = $_POST["Modelo"];
            $modelo = $this->getRecord("Modelos", $_POST['Modelo']);
            $nuevo["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
        }
        if (isset($_POST["Valor_Asegurado"])) {
            $nuevo["Valor_Asegurado"] = $_POST["Valor_Asegurado"];
        }
        if (isset($_POST["A_o_de_Fabricacion"])) {
            $nuevo["A_o_de_Fabricacion"] = $_POST["A_o_de_Fabricacion"];
        }
        if (isset($_POST["Chasis"])) {
            $nuevo["Chasis"] = $_POST["Chasis"];
        }
        if (isset($_POST["Color"])) {
            $nuevo["Color"] = $_POST["Color"];
        }
        if (isset($_POST["Uso"])) {
            $nuevo["Uso"] = $_POST["Uso"];
        }
        if (isset($_POST["Placa"])) {
            $nuevo["Placa"] = $_POST["Placa"];
        }
        if (isset($_POST["Direcci_n"])) {
            $nuevo["Direcci_n"] = $_POST["Direcci_n"];
        }
        if (isset($_POST["Direcci_n"])) {
            $nuevo["Direcci_n"] = $_POST["Direcci_n"];
        }
        if (isset($_POST["Nombre"])) {
            $nuevo["Nombre"] = $_POST["Nombre"];
        }
        if (isset($_POST["Apellido"])) {
            $nuevo["Apellido"] = $_POST["Apellido"];
        }
        if (isset($_POST["RNC_Cedula"])) {
            $nuevo["RNC_Cedula"] = $_POST["RNC_Cedula"];
        }
        if (isset($_POST["Telefono"])) {
            $nuevo["Telefono"] = $_POST["Telefono"];
        }
        if (isset($_POST["Tel_Residencia"])) {
            $nuevo["Tel_Residencia"] = $_POST["Tel_Residencia"];
        }
        if (isset($_POST["Tel_Trabajo"])) {
            $nuevo["Tel_Trabajo"] = $_POST["Tel_Trabajo"];
        }
        if (isset($_POST["Fecha_de_Nacimiento"])) {
            $nuevo["Fecha_de_Nacimiento"] = $_POST["Fecha_de_Nacimiento"];
        }
        if (isset($_POST["Email"])) {
            $nuevo["Email"] = $_POST["Email"];
        }
        if (isset($_POST['Es_nuevo'])) {
            $nuevo["Es_nuevo"]  = true;
        } else {
            $nuevo["Es_nuevo"]  = false;
        }
        return $nuevo;
    }
    public function guardar_cotizacion($id = null, $nuevo = null)
    {
        foreach ($nuevo as $campo => $valor) {
            $cotizacion[$campo] = $valor;
        }
        if ($id == null) {
            return $this->createRecord("Deals", $cotizacion);
        } else {
            $this->updateRecord("Deals", $cotizacion, $id);
        }
    }
    public function resumen_detalles($id)
    {
        return $this->getRecord("Deals", $id);
    }
    public function obtener_cotizaciones($id)
    {
        $criterio = "Deal_Name:equals:" . $id;
        return $this->searchRecordsByCriteria("Quotes", $criterio);
    }
    public function obtener_marcas()
    {
        return $this->getRecords("Marcas");
    }
    public function obtener_imagen_aseguradora($aseguradora_id)
    {
        return $this->downloadPhoto("Vendors", $aseguradora_id, "public/img/");
    }
    public function detalles_contrato($contrato_id)
    {
        return $this->getRecord("Contratos", $contrato_id);
    }
    public function cotizacion_detalles($resumen_id)
    {
        $cotizaciones =  $this->obtener_cotizaciones($resumen_id);
        foreach ($cotizaciones as $cotizacion) {
            return $cotizacion;
        }
    }
    public function aseguradora_detalles($aseguradora_id)
    {
        return $this->getRecord("Vendors", $aseguradora_id);
    }
    public function adjuntar_documento($id)
    {
        $ruta_cotizacion = "public/tmp";
        if (!is_dir($ruta_cotizacion)) {
            mkdir($ruta_cotizacion, 0755, true);
        }
        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
        $this->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
        unlink("$ruta_cotizacion/$name");
    }
    public function adjuntar_varios_documentos($id)
    {
        $ruta_cotizacion = "public/tmp";
        if (!is_dir($ruta_cotizacion)) {
            mkdir($ruta_cotizacion, 0755, true);
        }
        foreach ($_FILES["documentos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                $name = basename($_FILES["documentos"]["name"][$key]);
                move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                $this->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                unlink("$ruta_cotizacion/$name");
            }
        }
    }
}
