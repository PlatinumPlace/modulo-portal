<?php

class cotizacion
{
    public $api;

    public function __construct()
    {
        $this->api = new api;
    }

    public function lista($num_pag, $cantidad)
    {
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        return $this->api->searchRecordsByCriteria("Quotes", $criteria, $num_pag, $cantidad);
    }

    public function total()
    {
        $num_pag = 1;
        $total = 0;

        do {
            $cotizaciones = $this->lista($num_pag, 200);
            if (!empty($cotizaciones)) {
                $num_pag++;

                foreach ($cotizaciones as $cotizacion) {
                    $total += 1;
                }
            } else {
                $num_pag = 0;
            }
        } while ($num_pag > 1);

        return $total;
    }

    public function buscar($num_pag, $cantidad, $parametro, $busqueda)
    {
        $criteria = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and ($parametro:equals:$busqueda))";
        return $this->api->searchRecordsByCriteria("Quotes", $criteria, $num_pag, $cantidad);
    }

    public function listaContratos()
    {
        $criteria = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
        return $this->api->searchRecordsByCriteria("Contratos", $criteria);
    }

    public function contratosDisponiblesCrear()
    {
        $contratos = $this->listaContratos();

        foreach ($contratos as $contrato) {
            if ($contrato->getFieldValue('Tipo') == "Auto") {
                $result["auto"] = true;
            } elseif ($contrato->getFieldValue('Tipo') == "Vida") {
                $result["vida"] = true;
            } elseif ($contrato->getFieldValue('Tipo') == "Incendio") {
                $result["incendio"] = true;
            }
        }

        return $result;
    }

    public function listaMarcas()
    {
        return $this->api->getRecords("Marcas");
    }

    public function seleccionarPlan($aseguradora_id)
    {
        $criteria = "Vendor_Name:equals:" . $aseguradora_id;
        $planes = $this->api->searchRecordsByCriteria("Vendors", $criteria);
        foreach ($planes as $plan) {
            if ($plan->getFieldValue('Product_Category') == $_POST["tipo_plan"]) {
                return $plan;
            }
        }
    }

    public function calcularTasaAuto($contrato_id, $modelo)
    {
        $tasa_elejida = 0;
        $criteria = "Contrato:equals:" . $contrato_id;
        $tasas = $this->api->searchRecordsByCriteria("Tasas", $criteria);
        foreach ($tasas as $tasa) {
            if (
                in_array($modelo->getFieldValue("Tipo"), $tasa->getFieldValue('Grupo_de_veh_culo'))
                and
                $tasa->getFieldValue('A_o') == $_POST["fabricacion"]
            ) {
                $tasa_elejida = $tasa->getFieldValue('Valor');
            }
        }

        $recargos = $this->api->searchRecordsByCriteria("Recargos", $criteria);
        foreach ($recargos as $recargo) {
            if ((in_array($modelo->getFieldValue("Tipo"), $recargo->getFieldValue('Grupo_de_veh_culo'))
                    and
                    $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"])
                and
                (($_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                    and
                    $_POST["fabricacion"] < $recargo->getFieldValue('Hasta'))
                    or
                    $_POST["fabricacion"] < $recargo->getFieldValue('Hasta')
                    or
                    $_POST["fabricacion"] > $recargo->getFieldValue('Desde'))
            ) {
                $recargo_elejido = $recargo->getFieldValue('Porcentaje');
            }
        }

        if (!empty($recargo_elejido)) {
            return $tasa_elejida + (($tasa_elejida * $recargo_elejido) / 100);
        } else {
            return $tasa_elejida;
        }
    }

    public function calcularPrimaAuto($contrato_id, $marca, $modelo, $contrato)
    {
        $prima = 0;
        $tasa = $this->calcularTasaAuto($contrato_id, $modelo);

        if (
            in_array($contrato->getFieldValue('Aseguradora')->getLookupLabel(), $marca->getFieldValue('Restringido_en'))
            or
            in_array($contrato->getFieldValue('Aseguradora')->getLookupLabel(), $modelo->getFieldValue('Restringido_en'))
        ) {
            $prima = 0;
        } else {
            $prima = $_POST["valor"] * ($tasa / 100);

            if ($prima < $contrato->getFieldValue('Prima_M_nima')) {
                $prima = $contrato->getFieldValue('Prima_M_nima');
            }
        }

        return $prima;
    }

    public function crearAuto()
    {
        $marca = $this->api->getRecord("Marcas", $_POST["marca"]);
        $modelo = $this->api->getRecord("Modelo", $_POST["modelo"]);

        $criteria = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
        $contratos = $this->api->searchRecordsByCriteria("Contratos", $criteria);
        foreach ($contratos as $contrato) {
            $plan = $this->seleccionarPlan($contrato->getFieldValue('Aseguradora')->getEntityId());

            if ($_POST["tipo_plan"] == "Plan Ley") {
                $prima = $plan->getFieldValue('Unit_Price');
            } else {
                $prima = $this->calcularPrimaAuto($contrato->getEntityId(), $marca, $modelo, $contrato);
            }

            if ($_POST["facturacion"] == "Mensual") {
                $prima = $prima / 12;
            }

            $planes[] = array(
                "id" => $plan->getEntityId(),
                "prima" => $prima,
                "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel()
            );
        }

        $plan = str_replace("Plan", "", $_POST["tipo_plan"]);
        $cotizacion["Subject"] = "Plan " . $_POST["facturacion"] . " " . $plan;
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Quote_Stage"] = "Cotizando";
        $cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
        $cotizacion["Plan"] = $plan;
        $cotizacion["Valor_Asegurado"] = $_POST["valor"];
        $cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cotizacion["Nombre"] = $_POST["nombre"];
        $cotizacion["Marca"] = $_POST["marca"];
        $cotizacion["Modelo"] = $_POST["modelo"];
        $cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
        $cotizacion["Tipo_Veh_culo"] = $modelo->getFieldValue("Tipo");

        return $this->api->createRecords("Quotes", $cotizacion, $planes);
    }

    public function detalles()
    {
        return $this->api->getRecord("Quotes", $_GET["id"]);
    }

    public function imagenAseguradora($plan_id)
    {
        $plan = $this->api->getRecord("Products", $plan_id);
        return $this->api->downloadPhoto("Vendors", $plan->getFieldValue('Vendor_Name')->getEntityId());
    }

    public function coberturas($plan_id)
    {
        $plan = $this->api->getRecord("Products", $plan_id);
        $criteria = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
        $contratos = $this->api->searchRecordsByCriteria("Contratos", $criteria);
        foreach ($contratos as $contrato) {
            if ($plan->getFieldValue('Vendor_Name')->getEntityId() == $contrato->getFieldValue('Aseguradora')->getEntityId()) {
                return $this->api->getRecord("Coberturas", $contrato->getFieldValue('Coberturas')->getEntityId());
            }
        }
    }

    public function emitirAuto($detalles)
    {
        $planes = $detalles->getLineItems();
        foreach ($planes as $plan) {
            if ($plan->getId() == $_POST["plan_id"]) {
                $prima_neta = $plan->getListPrice();
                $isc = $plan->getTaxAmount();
                $prima_total = $plan->getNetTotal();
                $criteria = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
                $contratos = $this->api->searchRecordsByCriteria("Contratos", $criteria);
                foreach ($contratos as $contrato) {
                    if ($plan->getDescription() == $contrato->getFieldValue('Aseguradora')->getLookupLabel()) {
                        $poliza = $contrato->getFieldValue('No_P_liza');
                        $comision_nobe = $prima_total * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                        $comision_aseguradora = $prima_total * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                        $comision_socio = $prima_total * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                        $contrato_id = $contrato->getEntityId();
                        $aseguradora_id = $contrato->getFieldValue('Aseguradora')->getEntityId();
                    }
                }
            }
        }

        $cliente["Vendor_Name"] = $contrato->getFieldValue("Aseguradora")->getEntityId();
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
        $cliente_id = $this->api->createRecords("Contacts", $cliente);

        $poliza["Name"] = $poliza;
        $poliza["Estado"] = true;
        $poliza["Plan"] = $detalles->getFieldValue('Subject');
        $poliza["Aseguradora"] = $aseguradora_id;
        $poliza["Prima"] = round($prima_total, 2);
        $poliza["Deudor"] = $cliente_id;
        $poliza["Ramo"] = "Automóvil";
        $poliza["Socio"] = $_SESSION["usuario"]['empresa_id'];
        $poliza["Tipo"] = "Declarativa";
        $poliza["Valor_Aseguradora"] = $detalles->getFieldValue('Valor_Asegurado');
        $poliza["Vigencia_desde"] = date("Y-m-d");
        $poliza["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $poliza_id = $this->api->createRecords("P_lizas", $poliza);

        $bien["A_o"] = $detalles->getFieldValue('A_o_Fabricaci_n');
        $bien["Color"] = $_POST["color"];
        $bien["Marca"] = $detalles->getFieldValue('Marca')->getLookupLabel();
        $bien["Modelo"] = $detalles->getFieldValue('Modelo')->getLookupLabel();
        $bien["Name"] = $_POST["chasis"];
        $bien["Placa"] = $_POST["placa"];
        $bien["Uso"] = $_POST["uso"];
        $bien["Condicion"] = (!empty($_POST["estado"])) ? "Nuevo" : "Usado";
        $bien["P_liza"] = $poliza_id;
        $bien["Tipo"] = "Automóvil";
        $bien["Tipo_de_veh_culo"] = $detalles->getFieldValue('Tipo_Veh_culo');
        $bien_id = $this->api->createRecords("Bienes", $bien);

        $trato["Deal_Name"] = $detalles->getFieldValue('Subject');
        $trato["Contact_Name"] = $_SESSION["usuario"]['id'];
        $trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $trato["Fecha_de_emisi_n"] = date("Y-m-d");
        $trato["Stage"] = "En trámite";
        $trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $trato["Type"] = "Auto";
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
        $trato["Valor_Aseguradora"] = $detalles->getFieldValue('Valor_Asegurado');
        $trato_id = $this->api->createRecords("Deals", $trato);

        $ruta = "public/path";
        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta/$name");
        $this->api->uploadAttachment("Deals", $trato_id, "$ruta/$name");
        unlink("$ruta/$name");

        $cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cotizacion["Nombre"] = $_POST["nombre"];
        $cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
        $cotizacion["Deal_Name"] = $trato_id;
        $this->api->update("Quotes", $_GET["id"], $cotizacion);

        return $trato_id;
    }
}
