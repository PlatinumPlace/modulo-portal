<?php

class auto extends api
{

    function lista_marcas()
    {
        $marcas = $this->getRecords("Marcas");
        sort($marcas);
        foreach ($marcas as $marca) {
            echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
        }
    }

    function calcular_prima($contrato, $tipo_vehiculo)
    {
        $tasa_valor = 0;
        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $this->searchRecordsByCriteria("Tasas", $criterio);
        $recargos = $this->searchRecordsByCriteria("Recargos", $criterio);

        foreach ($tasas as $tasa) {
            if (in_array($tipo_vehiculo, $tasa->getFieldValue('Grupo_de_veh_culo')) and $tasa->getFieldValue('A_o') == $_POST["fabricacion"]) {
                $tasa_valor = $tasa->getFieldValue('Valor');
            }
        }

        foreach ($recargos as $recargo) {
            if (
                (in_array($tipo_vehiculo, $recargo->getFieldValue('Grupo_de_veh_culo'))
                    and
                    $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"])
                and
                (
                    ($_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                        and
                        $_POST["fabricacion"] < $recargo->getFieldValue('Hasta'))
                    or
                    $_POST["fabricacion"] < $recargo->getFieldValue('Hasta')
                    or
                    $_POST["fabricacion"] > $recargo->getFieldValue('Desde'))
            ) {
                $recargo_valor = $recargo->getFieldValue('Porcentaje');
            }
        }

        if (!empty($recargo_valor)) {
            $tasa_valor = $tasa_valor + (($tasa_valor * $recargo_valor) / 100);
        }

        $prima = $_POST["valor"] * $tasa_valor / 100;

        if ($prima < $contrato->getFieldValue('Prima_M_nima')) {
            $prima = $contrato->getFieldValue('Prima_M_nima');
        }

        return $prima;
    }

    function verificar_restringido($prima, $plan, $marca, $modelo)
    {
        if (!empty($marca->getFieldValue('Restringido_en')) and in_array($plan->getFieldValue('Vendor_Name')->getLookupLabel(), $marca->getFieldValue('Restringido_en'))) {
            return 0;
        } elseif (!empty($modelo->getFieldValue('Restringido_en')) and in_array($plan->getFieldValue('Vendor_Name')->getLookupLabel(), $modelo->getFieldValue('Restringido_en'))) {
            return 0;
        } else {
            return $prima;
        }
    }

    function crear()
    {
        $marca = $this->getRecord("Marcas", $_POST["marca"]);
        $modelo = $this->getRecord("Modelos", $_POST["modelo"]);
        $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);

        foreach ($contratos as $contrato) {
            $prima = 0;

            $plan = $this->getRecord("Products", $contrato->getFieldValue('Plan')->getEntityId());
            if ($_POST["tipo_plan"] == "Ley") {
                $prima = $plan->getFieldValue('Unit_Price');
            } else {
                $prima = $this->calcular_prima($contrato, $modelo->getFieldValue("Tipo"));
            }

            if ($_POST["facturacion"] == "Mensual") {
                $prima = $prima / 12;
            }

            $prima = $this->verificar_restringido($prima, $plan, $marca, $modelo);

            $plan_seleccionado[] = array(
                "id" => $contrato->getFieldValue('Plan')->getEntityId(),
                "prima" => $prima,
                "cantidad" => 1,
                "descripcion" => $plan->getFieldValue('Vendor_Name')->getLookupLabel(),
                "impuesto" => "ITBIS 16",
                "impuesto_valor" => 16
            );
        }

        $cotizacion["Subject"] = "Plan " . $_POST["facturacion"] . " " . $_POST["tipo_plan"];
        $cotizacion["Quote_Stage"] = "Cotizando";
        $cotizacion["Tipo"] = "Auto";
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Fecha_emisi_n"] = date("Y-m-d");
        $cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
        $cotizacion["Tipo_P_liza"] = "Declarativa";
        $cotizacion["Plan"] = $_POST["tipo_plan"];
        $cotizacion["Valor_Asegurado"] = $_POST["valor"];

        $cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cotizacion["Nombre"] = $_POST["nombre"];
        $cotizacion["Apellido"] = $_POST["apellido"];
        $cotizacion["Direcci_n"] = $_POST["direccion"];
        $cotizacion["Tel_Celular"] = $_POST["telefono"];
        $cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
        $cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
        $cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
        $cotizacion["Correo"] = $_POST["correo"];

        $cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
        $cotizacion["Marca"] = $_POST["marca"];
        $cotizacion["Modelo"] = $_POST["modelo"];
        $cotizacion["Uso_Veh_culo"] = $_POST["uso"];
        $cotizacion["Estado_Veh_culo"] = (!empty($_POST["estado"])) ? true : false;
        $cotizacion["Tipo_Veh_culo"] = $modelo->getFieldValue('Tipo');

        $id = $this->createRecords("Quotes", $cotizacion, $plan_seleccionado);
        header("Location:" . constant("url") . "detalles/$id");
        exit();
    }

    function emitir($cotizacion)
    {
        $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
        $permitido = array("pdf");
        if (!in_array($extension, $permitido)) {
            return "Para emitir solo se admiten documentos PDF";
        } else {
            $planes = $cotizacion->getLineItems();
            foreach ($planes as $plan) {
                if ($plan->getDescription() == $_POST["aseguradora"]) {
                    $plan_id = $plan->getProduct()->getEntityId();
                    $prima = $plan->getNetTotal();
                    $prima_neta = $plan->getListPrice();
                    $isc = $plan->getTaxAmount();
                }
            }

            $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
            $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);
            foreach ($contratos as $contrato) {
                if ($contrato->getFieldValue("Plan")->getEntityId() == $plan_id) {
                    $poliza = $contrato->getFieldValue('No_P_liza');
                    $comision_nobe = $prima * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                    $comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                    $comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                    $contrato_id = $contrato->getEntityId();
                }
            }

            $plan_detalles = $this->getRecord("Products", $plan_id);

            $cliente_nuevo["Vendor_Name"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
            $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
            $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $cliente_nuevo["Mailing_Street"] = $_POST["direccion"];
            $cliente_nuevo["First_Name"] = $_POST["nombre"];
            $cliente_nuevo["Last_Name"] = $_POST["apellido"];
            $cliente_nuevo["Mobile"] = $_POST["telefono"];
            $cliente_nuevo["Phone"] = $_POST["tel_residencia"];
            $cliente_nuevo["Tel_Trabajo"] = $_POST["tel_trabajo"];
            $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
            $cliente_nuevo["Email"] = $_POST["correo"];
            $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
            $cliente_nuevo["Tipo"] = "Cliente";
            $cliente_nuevo_id = $this->createRecords("Contacts", $cliente_nuevo);

            $poliza_nueva["Name"] = $poliza;
            $poliza_nueva["Estado"] = true;
            $poliza_nueva["Plan"] = $cotizacion->getFieldValue('Subject');
            $poliza_nueva["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
            $poliza_nueva["Prima"] = round($prima, 2);
            $poliza_nueva["Deudor"] = $cliente_nuevo_id;
            $poliza_nueva["Ramo"] = "Automóvil";
            $poliza_nueva["Socio"] = $_SESSION["usuario"]['empresa_id'];
            $poliza_nueva["Tipo"] = $cotizacion->getFieldValue('Tipo_P_liza');
            $poliza_nueva["Valor_Aseguradora"] = $cotizacion->getFieldValue('Valor_Asegurado');
            $poliza_nueva["Vigencia_desde"] = date("Y-m-d");
            $poliza_nueva["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
            $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
            $poliza_nueva_id = $this->createRecords("P_lizas", $poliza_nueva);

            $nuevo_bien["A_o"] = $cotizacion->getFieldValue('A_o_Fabricaci_n');
            $nuevo_bien["Color"] = $_POST["color"];
            $nuevo_bien["Marca"] = $cotizacion->getFieldValue('Marca')->getLookupLabel();
            $nuevo_bien["Modelo"] = $cotizacion->getFieldValue('Modelo')->getLookupLabel();
            $nuevo_bien["Name"] = $_POST["chasis"];
            $nuevo_bien["Placa"] = $_POST["placa"];
            $nuevo_bien["Uso"] = $cotizacion->getFieldValue('Uso_Veh_culo');
            $nuevo_bien["Condicion"] = ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado";
            $nuevo_bien["P_liza"] = $poliza_nueva_id;
            $nuevo_bien["Tipo"] = "Automóvil";
            $nuevo_bien["Tipo_de_veh_culo"] = $cotizacion->getFieldValue('Tipo_Veh_culo');
            $nuevo_bien_id = $this->createRecords("Bienes", $nuevo_bien);

            $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
            $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
            $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $nuevo_trato["Stage"] = "En trámite";
            $nuevo_trato["Fecha_de_emisi_n"] = date("Y-m-d");
            $nuevo_trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
            $nuevo_trato["Type"] = "Auto";
            $nuevo_trato["Valor_Asegurado"] = $cotizacion->getFieldValue('Valor_Asegurado');
            $nuevo_trato["P_liza"] = $poliza_nueva_id;
            $nuevo_trato["Bien"] = $nuevo_bien_id;
            $nuevo_trato["Cliente"] = $cliente_nuevo_id;
            $nuevo_trato["Contrato"] = $contrato_id;
            $nuevo_trato["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
            $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
            $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
            $nuevo_trato["Amount"] = round($comision_nobe, 2);
            $nuevo_trato["Prima_Total"] = round($prima, 2);
            $nuevo_trato["Prima_Neta"] = round($prima_neta, 2);
            $nuevo_trato["ISC"] = round($isc, 2);
            $nuevo_trato["Lead_Source"] = "Portal";
            $nuevo_trato_id = $this->createRecords("Deals", $nuevo_trato);

            $ruta = "public/path";
            if (!is_dir($ruta)) {
                mkdir($ruta, 0755, true);
            }
            $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
            $name = basename($_FILES["cotizacion_firmada"]["name"]);
            move_uploaded_file($tmp_name, "$ruta/$name");
            $this->uploadAttachment("Deals", $nuevo_trato_id, "$ruta/$name");
            unlink("$ruta/$name");

            $cambios_cotizacion["Quote_Stage"] = "Emitida";
            $cambios_cotizacion["Fecha_emisi_n"] = date("Y-m-d");
            $cambios_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
            $cambios_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
            $cambios_cotizacion["Nombre"] = $_POST["nombre"];
            $cambios_cotizacion["Apellido"] = $_POST["apellido"];
            $cambios_cotizacion["Direcci_n"] = $_POST["direccion"];
            $cambios_cotizacion["Tel_Celular"] = $_POST["telefono"];
            $cambios_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
            $cambios_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
            $cambios_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
            $cambios_cotizacion["Correo"] = $_POST["correo"];
            $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;
            $plan_seleccionado[] = array(
                "id" => $plan_id,
                "prima" => $prima,
                "cantidad" => 1,
                "descripcion" => $plan_detalles->getFieldValue("Vendor_Name")->getLookupLabel(),
                "impuesto" => "ITBIS 16",
                "impuesto_valor" => 16
            );
            $this->update("Quotes", $cotizacion->getEntityId(), $cambios_cotizacion, $plan_seleccionado);
            header("Location:" . constant("url") . "detalles/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
            exit();
        }
    }
}
