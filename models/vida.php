<?php

class vida extends api
{
    public function crearTrato($plan)
    {
        $trato["Stage"] = "Cotizando";
        $trato["Fecha"] = date("Y-m-d");
        $trato["Deal_Name"] = $_POST["nombre"];
        $trato["Contact_Name"] = $_SESSION["usuario"]['id'];
        $trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $trato["Suma_asegurada"] = $_POST["suma"];
        $trato["Edad_deudor"] = $_POST["edad_deudor"];
        $trato["Edad_codeudor"] = $_POST["edad_codeudor"];
        $trato["Plazo"] = $_POST["plazo"];
        $trato["Cuota"] = (!empty($_POST["cuota"])) ? $_POST["cuota"] : 0;
        $trato["Plan"] = $plan;
        $trato["Type"] = "Vida";
        return $this->createRecords("Deals", $trato);
    }

    public function selecionarPlan($contrato)
    {
        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $this->searchRecordsByCriteria("Products", $criterio);
        foreach ($planes as $plan) {
            return $plan->getEntityId();
        }
    }

    public function calcularPrimaDeudor($contrato)
    {
        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $this->searchRecordsByCriteria("Tasas", $criterio);
        foreach ($tasas as $tasa) {
            if ($tasa->getFieldValue('Tipo') == "Deudor") {
                $deudor = $tasa->getFieldValue('Name') / 100;
            }
        }

        return ($_POST["suma"] / 1000) * $deudor;
    }

    public function calcularPrimaCodeudor($contrato)
    {
        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $this->searchRecordsByCriteria("Tasas", $criterio);
        foreach ($tasas as $tasa) {
            if ($tasa->getFieldValue('Tipo') == "Deudor") {
                $deudor = $tasa->getFieldValue('Name') / 100;
            }
            if ($tasa->getFieldValue('Tipo') == "Codeudor") {
                $codeudor = $tasa->getFieldValue('Name') / 100;
            }
        }

        $prima = ($_POST["suma"] / 1000) * $deudor;
        $prima += ($_POST["suma"] / 1000) * ($codeudor - $deudor);
        return $prima;
    }

    public function calcularPrimaDesempleo($contrato)
    {
        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $this->searchRecordsByCriteria("Tasas", $criterio);
        foreach ($tasas as $tasa) {
            if ($tasa->getFieldValue('Tipo') == "Vida") {
                $vida = $tasa->getFieldValue('Name') / 100;
            }
            if ($tasa->getFieldValue('Tipo') == "Desempleo") {
                $desempleo = $tasa->getFieldValue('Name') / 100;
            }
        }

        $prima = ($_POST["suma"] / 1000) * $vida;
        $prima += ($_POST["cuota"] / 1000) * $desempleo;
        return $prima;
    }

    public function calcularPrima($contrato)
    {
        if (
            $_POST["suma"] < $contrato->getFieldValue('Suma_Asegurada_Max')
            and
            $_POST["edad_deudor"] < $contrato->getFieldValue('Edad_Max')
            and
            $_POST["plazo"] < $contrato->getFieldValue('Plazo_Max')
            and
            $_POST["edad_deudor"] > $contrato->getFieldValue('Edad_Min')
        ) {
            if (empty($_POST["desempleo"])) {
                if (
                    !empty($_POST["edad_codeudor"])
                    and
                    !empty($_POST["cuota"])
                    and
                    $_POST["edad_codeudor"] < $contrato->getFieldValue('Edad_Max')
                    and
                    $_POST["edad_codeudor"] > $contrato->getFieldValue('Edad_Min')
                ) {
                    return $this->calcularPrimaCodeudor($contrato);
                } else {
                    return $this->calcularPrimaDeudor($contrato);
                }
            } else {
                return $this->calcularPrimaDesempleo($contrato);
            }
        } else {
            return 0;
        }
    }

    public function crearCotizacion($plan_nombre, $contrato, $trato_id, $plan_id, $prima)
    {
        $cotizacion["Subject"] = "Plan $plan_nombre";
        $cotizacion["Contrato"] = $contrato->getEntityId();
        $cotizacion["Aseguradora"] = $contrato->getFieldValue('Aseguradora')->getEntityId();
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Deal_Name"] = $trato_id;
        $cotizacion["Quote_Stage"] = "Negociación";
        return $this->createRecords("Quotes", $cotizacion, $plan_id, $prima);
    }

    public function crearDeudor()
    {
        $deudor["Mailing_Street"] = $_POST["direccion"];
        $deudor["First_Name"] = $_POST["nombre"];
        $deudor["Last_Name"] = $_POST["apellido"];
        $deudor["Phone"] = $_POST["telefono"];
        $deudor["Home_Phone"] = $_POST["tel_residencia"];
        $deudor["Other_Phone"] = $_POST["tel_trabajo"];
        $deudor["Date_of_Birth"] = date("Y-m-d", strtotime($_POST["fecha_nacimiento"]));
        $deudor["Email"] = $_POST["correo"];
        $deudor["RNC_C_dula"] = $_POST["rnc_cedula"];
        $deudor["Title"] = "Deudor";
        $deudor["Reporting_To"] = $_SESSION["usuario"]['id'];
        $deudor["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $deudor["Vendor_Name"] = $_POST["aseguradora_id"];
        return $this->createRecords("Contacts", $deudor);
    }

    public function crearCodeudor($deudor_id)
    {
        $codeudor["Mailing_Street"] = $_POST["direccion_codeudor"];
        $codeudor["First_Name"] = $_POST["nombre_codeudor"];
        $codeudor["Last_Name"] = $_POST["apellido_codeudor"];
        $codeudor["Phone"] = $_POST["telefono_codeudor"];
        $codeudor["Home_Phone"] = $_POST["tel_residencia_codeudor"];
        $codeudor["Other_Phone"] = $_POST["tel_trabajo_codeudor"];
        $codeudor["Date_of_Birth"] = date("Y-m-d", strtotime($_POST["fecha_nacimiento_codeudor"]));
        $codeudor["Email"] = $_POST["correo_codeudor"];
        $codeudor["RNC_C_dula"] = $_POST["rnc_cedula_codeudor"];
        $codeudor["Title"] = "Codeudor";
        $codeudor["Reporting_To"] = $deudor_id;
        $codeudor["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $codeudor["Vendor_Name"] = $_POST["aseguradora_id"];
        return $this->createRecords("Contacts", $codeudor);
    }

    public function crearPoliza($no_poliza, $deudor_id, $trato, $codeudor_id, $prima_total)
    {
        $poliza["Name"] = $no_poliza;
        $poliza["Estado"] = true;
        $poliza["Informar_a"] = $deudor_id;
        $poliza["Codeudor"] = $codeudor_id;
        $poliza["Plan"] = $trato->getFieldValue('Plan');
        $poliza["Aseguradora"] = $_POST["aseguradora_id"];
        $poliza["Prima"] = $prima_total;
        $poliza["Ramo"] = "Vida";
        $poliza["Tipo"] = "Declarativa";
        $poliza["Suma_asegurada"] = $trato->getFieldValue('Suma_asegurada');
        $poliza["Vigencia_desde"] = date("Y-m-d");
        $poliza["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
        return $this->createRecords("P_lizas", $poliza);
    }

    public function actualizarTrato(
        $poliza_id,
        $deudor_id,
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
        $cambios["Cliente"] = $deudor_id;
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
