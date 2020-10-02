<?php

class auto extends tratos
{
    public function crearTrato($marca, $modelo)
    {
        $trato["Stage"] = "Cotizando";
        $trato["Fecha"] = date("Y-m-d");
        $trato["Marca"] = $marca->getFieldValue("Name");
        $trato["Modelo"] = $modelo->getFieldValue("Name");
        $trato["A_o_veh_culo"] = $_POST["fabricacion"];
        $trato["Deal_Name"] = $_POST["nombre"];
        $trato["Contact_Name"] = $_SESSION["usuario"]['id'];
        $trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $trato["Suma_asegurada"] = $_POST["suma"];
        $trato["Plan"] = ucfirst($_POST["plan"]);
        $trato["Type"] = "Auto";
        $trato["Tipo_veh_culo"] = $modelo->getFieldValue("Tipo");
        return $this->createRecords("Deals", $trato);
    }

    public function selecionarTasa($contrato, $modelo)
    {
        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $this->searchRecordsByCriteria("Tasas", $criterio);
        foreach ($tasas as $tasa) {
            if (
                in_array($modelo->getFieldValue("Tipo"), $tasa->getFieldValue('Grupo_de_veh_culo'))
                and
                $tasa->getFieldValue('A_o') == $_POST["fabricacion"]
            ) {
                return $tasa->getFieldValue('Name');
            }
        }
    }

    public function selecionarRecargo($contrato, $modelo)
    {
        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $recargos = $this->searchRecordsByCriteria("Recargos", $criterio);
        foreach ($recargos as $recargo) {
            if (
                $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"]
                and
                (empty($recargo->getFieldValue("Tipo"))
                    or
                    $recargo->getFieldValue("Tipo") == $modelo->getFieldValue("Tipo")
                    or
                    ($_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                        and
                        $_POST["fabricacion"] < $recargo->getFieldValue('Hasta'))
                    or
                    $_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                    or
                    $_POST["fabricacion"] < $recargo->getFieldValue('Hasta'))
            ) {
                return $recargo->getFieldValue('Name');
            }
        }
    }

    public function calcularPrima($contrato, $marca, $modelo)
    {
        if (
            !in_array(
                $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                $marca->getFieldValue('Restringido_en')
            )
            and
            !in_array(
                $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                $modelo->getFieldValue('Restringido_en')
            )
        ) {
            $tasa = $this->selecionarTasa($contrato, $modelo);
            $recargo = $this->selecionarRecargo($contrato, $modelo);

            if (!empty($recargo)) {
                $tasa = ($tasa + ($tasa * $recargo));
            }

            $prima = $_POST["suma"] * $tasa / 100;

            if (!empty($prima) and $prima < $contrato->getFieldValue('Prima_M_nima')) {
                $prima = $contrato->getFieldValue('Prima_M_nima');
            }

            return $prima;
        } else {
            return 0;
        }
    }

    public function crearCotizacion($contrato, $trato_id, $plan_id, $prima)
    {
        $cotizacion["Subject"] = "Plan " . $_POST["plan"];
        $cotizacion["Contrato"] = $contrato->getEntityId();
        $cotizacion["Aseguradora"] = $contrato->getFieldValue('Aseguradora')->getEntityId();
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Deal_Name"] = $trato_id;
        $cotizacion["Quote_Stage"] = "Negociación";
        $this->createRecords("Quotes", $cotizacion, $plan_id, $prima / 12);
    }

    public function crearCliente()
    {
        $cliente["Mailing_Street"] = $_POST["direccion"];
        $cliente["First_Name"] = $_POST["nombre"];
        $cliente["Last_Name"] = $_POST["apellido"];
        $cliente["Phone"] = $_POST["telefono"];
        $cliente["Home_Phone"] = $_POST["tel_residencia"];
        $cliente["Other_Phone"] = $_POST["tel_trabajo"];
        $cliente["Date_of_Birth"] = date("Y-m-d", strtotime($_POST["fecha_nacimiento"]));
        $cliente["Email"] = $_POST["correo"];
        $cliente["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cliente["Title"] = "Deudor";
        $cliente["Reporting_To"] = $_SESSION["usuario"]['id'];
        $cliente["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cliente["Vendor_Name"] = $_POST["aseguradora_id"];
        return $this->createRecords("Contacts", $cliente);
    }

    public function crearPoliza($no_poliza, $cliente_id, $trato, $prima_total)
    {
        $poliza["Name"] = $no_poliza;
        $poliza["Estado"] = true;
        $poliza["Informar_a"] = $cliente_id;
        $poliza["Plan"] = $trato->getFieldValue('Plan');
        $poliza["Aseguradora"] = $_POST["aseguradora_id"];
        $poliza["Prima"] = $prima_total;
        $poliza["Ramo"] = "Automóvil";
        $poliza["Tipo"] = "Declarativa";
        $poliza["Suma_asegurada"] = $trato->getFieldValue('Suma_asegurada');
        $poliza["Vigencia_desde"] = date("Y-m-d");
        $poliza["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        return $this->createRecords("P_lizas", $poliza);
    }

    public function crearBien($trato, $poliza_id)
    {
        $bien["A_o"] = $trato->getFieldValue('A_o_veh_culo');
        $bien["Color"] = $_POST["color"];
        $bien["Marca"] = $trato->getFieldValue('Marca');
        $bien["Modelo"] = $trato->getFieldValue('Modelo');
        $bien["Name"] = $_POST["chasis"];
        $bien["Placa"] = $_POST["placa"];
        $bien["Uso"] = $_POST["uso"];
        $bien["Condicion"] = (!empty($_POST["estado"])) ? "Nuevo" : "Usado";
        $bien["Tipo_de_veh_culo"] = $trato->getFieldValue('Tipo_veh_culo');
        $bien["P_liza"] = $poliza_id;
        return $this->createRecords("Bienes", $bien);
    }

    public function actualizarTrato(
        $poliza_id,
        $cliente_id,
        $bien_id,
        $prima_neta,
        $isc,
        $prima_total,
        $contrato_id,
        $comision_corredor,
        $comision_intermediario,
        $comision_nobe,
        $comision_aseguradora,
        $id
    ) {
        $cambios["Stage"] = "En trámite";
        $cambios["Deal_Name"] = $_POST["nombre"] . " " . $_POST["apellido"];
        $cambios["Fecha"] = date("Y-m-d");
        $cambios["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        $cambios["P_liza"] = $poliza_id;
        $cambios["Cliente"] = $cliente_id;
        $cambios["Bien"] = $bien_id;
        $cambios["Prima_neta"] = $prima_neta;
        $cambios["ISC"] = $isc;
        $cambios["Prima_total"] = $prima_total;
        $cambios["Aseguradora"] = $_POST["aseguradora_id"];
        $cambios["Contrato"] = $contrato_id;
        $cambios["Comisi_n_corredor"] = round($comision_corredor, 2);
        $cambios["Comisi_n_intermediario"] = round($comision_intermediario, 2);
        $cambios["Amount"] = round($comision_nobe, 2);
        $cambios["Comisi_n_aseguradora"] = round($comision_aseguradora, 2);
        $this->update("Deals", $id, $cambios);

        $ruta = "public/path";
        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta/$name");
        $this->uploadAttachment("Deals", $id, "$ruta/$name");
        unlink("$ruta/$name");
    }
}
