<?php

class AutoController
{
    public $cotizacion;
    public $bien;
    public $cliente;
    public $aseguradora;
    public $contrato;

    function __construct()
    {
        $this->cotizacion = new cotizacion;
        $this->bien = new bien;
        $this->cliente = new cliente;
        $this->contrato = new contrato;
        $this->aseguradora = new aseguradora;
    }

    public function crear_cotizacion()
    {
        $marcas = $this->bien->lista_marcas();
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

            $modelo = $this->bien->detalles_modelo($_POST['Modelo']);

            $nueva_cotizacion["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
            $nueva_cotizacion["Valor_Asegurado"] = $_POST["Valor_Asegurado"];

            $nueva_cotizacion["A_o_de_Fabricacion"] = $_POST["A_o_de_Fabricacion"];
            $nueva_cotizacion["Chasis"] = (isset($_POST["Chasis"])) ? $_POST["Chasis"] : null;
            $nueva_cotizacion["Color"] = (isset($_POST["Color"])) ? $_POST["Color"] : null;
            $nueva_cotizacion["Uso"] = (isset($_POST["Uso"])) ? $_POST["Uso"] : null;
            $nueva_cotizacion["Placa"] = (isset($_POST["Placa"])) ? $_POST["Placa"] : null;
            $nueva_cotizacion["Es_nuevo"] = (isset($_POST["Es_nuevo"])) ? true : false;

            $id = $this->cotizacion->crear($nueva_cotizacion);

            $direccion = 'auto-detalles_cotizacion-' . $id;
            header("Location:" . constant('url') . 'home/reedirigir_controlador/' . $direccion);
            exit;
        }

        require_once("core/views/template/header.php");
        require_once("core/views/auto/crear_cotizacion.php");
        require_once("core/views/template/footer.php");
    }

    public function detalles_cotizacion($id)
    {
        $resultado = $this->cotizacion->detalles($id);

        $cotizacion =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];
        $emitida = array("Emitido", "En trámite");

        if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {
            $documentos_adjuntos = $this->cotizacion->lista_documentos_adjuntos($id);
        }

        require_once("core/views/template/header.php");
        require_once("core/views/auto/detalles_cotizacion.php");
        require_once("core/views/template/footer.php");
    }

    public function completar_cotizacion($id)
    {
        $resultado = $this->cotizacion->detalles($id);
        $cotizacion =  $resultado["oferta"];
        $clientes = $this->cliente->lista();
        sort($clientes);

        if (
            $cotizacion->getFieldValue('Email') != null
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

                $cliente_info = $this->cliente->detalles($_POST["mis_clientes"]);

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

            if (empty($cambios["Email"])) {
                $alerta = "Ha ocurrido un error,vuelve a intertarlo.";
            }
            else {
                $this->cotizacion->actualizar($id, $cambios);

                header("Location:" . constant('url')."auto/detalles_cotizacion/" . $id);
                exit;
            }

        }

        require_once("core/views/template/header.php");
        require_once("core/views/auto/completar_cotizacion.php");
        require_once("core/views/template/footer.php");
    }

    public function descargar_cotizacion($id)
    {
        $resultado = $this->cotizacion->detalles($id);
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

            $imagen_aseguradora = $this->aseguradora->foto($cotizacion->getFieldValue("Aseguradora")->getEntityId());

            foreach ($detalles as $resumen) {
                $coberturas = $this->contrato->detalles($resumen->getFieldValue('Contrato')->getEntityId());
            }
        }

        require_once("core/views/auto/descargar_cotizacion.php");
    }
}
