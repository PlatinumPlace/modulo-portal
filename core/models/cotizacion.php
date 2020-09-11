<?php

class cotizacion {

    public function __construct() {
        $this->api = new api;
    }

    public function lista($num_pag, $cantidad) {
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        return $this->api->searchRecordsByCriteria("Quotes", $criteria, $num_pag, $cantidad);
    }

    public function buscar($num_pag, $cantidad, $parametro, $busqueda) {
        $criteria = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and ($parametro:equals:$busqueda))";
        return $this->api->searchRecordsByCriteria("Quotes", $criteria, $num_pag, $cantidad);
    }

    function listaContratos($tipo = null) {
        if ($tipo == null) {
            $criteria = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
        } else {
            $criteria = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:$tipo))";
        }

        return $this->api->searchRecordsByCriteria("Contratos", $criteria);
    }

    public function listaMarcas() {
        return $this->api->getRecords("Marcas");
    }

    function detallesMarca() {
        return $this->api->getRecord("Marcas", $_POST["marca"]);
    }

    function detallesModelo() {
        return $this->api->getRecord("Modelos", $_POST["modelo"]);
    }

    function seleccionarPlan($contrato) {
        $criteria = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $this->api->searchRecordsByCriteria("Products", $criteria);
        foreach ($planes as $plan) {
            if ($plan->getFieldValue('Product_Category') == $_POST["tipo_plan"]) {
                return $plan;
            }
        }
    }

    function seleccionarTasaAuto($contrato, $modelo) {
        $criteria = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $this->api->searchRecordsByCriteria("Tasas", $criteria);
        foreach ($tasas as $tasa) {
            if (in_array($modelo->getFieldValue("Tipo"), $tasa->getFieldValue('Grupo_de_veh_culo'))
                    and
                    $tasa->getFieldValue('A_o') == $_POST["fabricacion"]) {
                return $tasa->getFieldValue('Valor');
            }
        }
    }

    function seleccionarRecargoAuto($contrato, $modelo) {
        $criteria = "Contrato:equals:" . $contrato->getEntityId();
        $recargos = $this->api->searchRecordsByCriteria("Recargos", $criteria);
        if (!empty($recargos)) {
            foreach ($recargos as $recargo) {
                if (
                        $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"]
                        and
                        (
                        empty($recargo->getFieldValue("Tipo"))
                        or
                        $recargo->getFieldValue("Tipo") == $modelo->getFieldValue("Tipo")
                        or
                        (
                        $_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                        and
                        $_POST["fabricacion"] < $recargo->getFieldValue('Hasta')
                        )
                        or
                        $_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                        or
                        $_POST["fabricacion"] < $recargo->getFieldValue('Hasta')
                        )
                ) {
                    return $recargo->getFieldValue('Porcentaje');
                }
            }
        }
    }

    function calcularTasaAuto($contrato, $modelo) {
        $tasa = $this->seleccionarTasaAuto($contrato, $modelo);
        $recargo = $this->seleccionarRecargoAuto($contrato, $modelo);
        if (!empty($tasa)) {
            if (!empty($recargo)) {
                return ($tasa + ($tasa * $recargo)) / 100;
            } else {
                return $tasa / 100;
            }
        } else {
            return 0;
        }
    }

    function verificarRestringidoAuto($prima, $contrato, $marca, $modelo) {
        if (in_array($contrato->getFieldValue('Aseguradora')->getLookupLabel(), $marca->getFieldValue('Restringido_en'))
                or
                in_array($contrato->getFieldValue('Aseguradora')->getLookupLabel(), $modelo->getFieldValue('Restringido_en'))) {
            return 0;
        } else {
            return $prima;
        }
    }

    function calcularPrimaAuto($contrato, $marca, $modelo) {
        $tasa = $this->calcularTasaAuto($contrato, $modelo);
        $prima = $_POST["valor"] * $tasa;

        if ($prima < $contrato->getFieldValue('Prima_M_nima')) {
            $prima = $contrato->getFieldValue('Prima_M_nima');
        }

        return $this->verificarRestringidoAuto($prima, $contrato, $marca, $modelo);
    }

    function crearAuto($modelo, $planes) {
        $tipo_plan = str_replace("Plan", "", $_POST["tipo_plan"]);
        $cotizacion["Subject"] = "Plan " . $_POST["facturacion"] . " " . $tipo_plan;
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
        $cotizacion["Plan"] = $tipo_plan;
        $cotizacion["Valor_Asegurado"] = $_POST["valor"];
        $cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cotizacion["Nombre"] = $_POST["nombre"];
        $cotizacion["Marca"] = $_POST["marca"];
        $cotizacion["Modelo"] = $_POST["modelo"];
        $cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
        $cotizacion["Tipo_Veh_culo"] = $modelo->getFieldValue("Tipo");
        return $this->api->createRecords("Quotes", $cotizacion, $planes);
    }

    public function detalles() {
        return $this->api->getRecord("Quotes", $_GET["id"]);
    }

    public function imagenAseguradora($plan_id) {
        $plan = $this->api->getRecord("Products", $plan_id);
        return $this->api->downloadPhoto("Vendors", $plan->getFieldValue('Vendor_Name')->getEntityId());
    }

    public function coberturas($plan_id) {
        $plan = $this->api->getRecord("Products", $plan_id);
        $contratos = $this->listaContratos("Auto");
        foreach ($contratos as $contrato) {
            if ($plan->getFieldValue('Vendor_Name')->getEntityId() == $contrato->getFieldValue('Aseguradora')->getEntityId()) {
                return $this->api->getRecord("Coberturas", $contrato->getFieldValue('Coberturas')->getEntityId());
            }
        }
    }

    function crearCliente($aseguradora_id) {
        $cliente["Vendor_Name"] = $aseguradora_id;
        $cliente["Reporting_To"] = $_SESSION["usuario"]['id'];
        $cliente["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cliente["Mailing_Street"] = $_POST["direccion"];
        $cliente["First_Name"] = $_POST["nombre"];
        $cliente["Last_Name"] = $_POST["apellido"];
        $cliente["Mobile"] = $_POST["telefono"];
        $cliente["Phone"] = $_POST["tel_residencia"];
        $cliente["Tel_Trabajo"] = $_POST["tel_trabajo"];
        $cliente["Date_of_Birth"] = $_POST["fecha_nacimiento"];
        $cliente["Email"] = $_POST["correo"];
        $cliente["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cliente["Tipo"] = "Cliente";
        return $this->api->createRecords("Contacts", $cliente);
    }

    function crearPoliza($no_poliza, $tipo_plan, $aseguradora_id, $prima_total, $cliente_id, $tipo, $valor_asegurado) {
        $poliza["Name"] = $no_poliza;
        $poliza["Estado"] = true;
        $poliza["Plan"] = $tipo_plan;
        $poliza["Aseguradora"] = $aseguradora_id;
        $poliza["Prima"] = round($prima_total, 2);
        $poliza["Deudor"] = $cliente_id;
        $poliza["Ramo"] = $tipo;
        $poliza["Socio"] = $_SESSION["usuario"]['empresa_id'];
        $poliza["Tipo"] = "Declarativa";
        $poliza["Valor_Asegurado"] = $valor_asegurado;
        $poliza["Vigencia_desde"] = date("Y-m-d");
        $poliza["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        return $this->api->createRecords("P_lizas", $poliza);
    }

    function crearBienAuto($frabricacion, $marca, $modelo, $tipo, $poliza_id) {
        $bien["A_o"] = $frabricacion;
        $bien["Color"] = $_POST["color"];
        $bien["Marca"] = $marca;
        $bien["Modelo"] = $modelo;
        $bien["Name"] = $_POST["chasis"];
        $bien["Placa"] = $_POST["placa"];
        $bien["Uso"] = $_POST["uso"];
        $bien["Condicion"] = (!empty($_POST["estado"])) ? "Nuevo" : "Usado";
        $bien["Tipo"] = "Automóvil";
        $bien["Tipo_de_veh_culo"] = $tipo;
        $bien["P_liza"] = $poliza_id;
        return $this->api->createRecords("Bienes", $bien);
    }

    function crearTrato(
            $nombre,
            $tipo,
            $poliza_id,
            $bien_id,
            $cliente_id,
            $contrato_id,
            $aseguradora_id,
            $comision_aseguradora,
            $comision_socio,
            $comision_nobe,
            $prima_neta,
            $isc,
            $prima_total,
            $valor_asegurado
    ) {
        $trato["Deal_Name"] = $nombre;
        $trato["Contact_Name"] = $_SESSION["usuario"]['id'];
        $trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $trato["Fecha_de_emisi_n"] = date("Y-m-d");
        $trato["Stage"] = "En trámite";
        $trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $trato["Type"] = $tipo;
        $trato["P_liza"] = $poliza_id;
        $trato["Bien"] = $bien_id;
        $trato["Cliente"] = $cliente_id;
        $trato["Contrato"] = $contrato_id;
        $trato["Aseguradora"] = $aseguradora_id;
        $trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
        $trato["Comisi_n_Socio"] = round($comision_socio, 2);
        $trato["Amount"] = round($comision_nobe, 2);
        $trato["Prima_Neta"] = round($prima_neta, 2);
        $trato["ISC"] = round($isc, 2);
        $trato["Prima_Total"] = round($prima_total, 2);
        $trato["Valor_Asegurado"] = $valor_asegurado;
        return $this->api->createRecords("Deals", $trato);
    }

    function adjuntarTrato($trato_id) {
        $ruta = "public/path";
        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta/$name");
        $this->api->uploadAttachment("Deals", $trato_id, "$ruta/$name");
        unlink("$ruta/$name");
    }

    public function emitir($trato_id) {
        $cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cotizacion["Nombre"] = $_POST["nombre"];
        $cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
        $cotizacion["Deal_Name"] = $trato_id;
        $this->api->update("Quotes", $_GET["id"], $cotizacion);
    }

}
