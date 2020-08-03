<?php

class vida extends cotizaciones
{
    function crear()
    {
        $api = new api;

        if ($_POST) {
            $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Vida))";
            $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);

            $edad_deudor = calcular_edad($_POST["fecha_deudor"]);
            $edad_codeudor = (!empty($_POST["fecha_codeudor"])) ?  calcular_edad($_POST["fecha_codeudor"]) : null;

            foreach ($contratos as $contrato) {
                $prima = 0;

                $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                $planes = $api->buscar_criterio("Products", $criterio, 1, 2);
                foreach ($planes as $plan) {
                    if ($plan->getFieldValue('Product_Category') == "Plan Vida") {
                        $plan_id = $plan->getEntityId();
                    }
                }

                $criterio = "Contrato:equals:" . $contrato->getEntityId();
                $tasas = $api->buscar_criterio("Tasas", $criterio, 1, 200);
                foreach ($tasas as $tasa) {
                    if ($tasa->getFieldValue('Codeudor') == true) {
                        $tasa_codeudor = $tasa->getFieldValue('Valor');
                    } else {
                        $tasa_deudor = $tasa->getFieldValue('Valor');
                    }
                }

                $tasa_deudor = $tasa_deudor / 100;
                $tasa_codeudor = $tasa_codeudor / 100;
                $prima = $_POST["valor"] / 1000 * $tasa_deudor;

                if (!empty($edad_codeudor)) {
                    $prima += $_POST["valor"] / 1000 * ($tasa_codeudor - $tasa_deudor);
                }

                if (
                    $edad_deudor > $contrato->getFieldValue('Edad_Max')
                    or
                    $edad_deudor < $contrato->getFieldValue('Edad_Min')
                    or
                    (!empty($edad_codeudor)
                        and
                        $edad_codeudor > $contrato->getFieldValue('Edad_Max')
                        or
                        $edad_codeudor < $contrato->getFieldValue('Edad_Min'))
                ) {
                    $prima = 0;
                }

                $plan_seleccionado[] = array(
                    "id" => $plan_id,
                    "prima" => $prima,
                    "cantidad" => 1,
                    "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                    "impuesto" => "ITBIS 16",
                    "impuesto_valor" => 16
                );
            }

            $nueva_cotizacion["Subject"] = "Plan Vida";
            $nueva_cotizacion["Fecha_de_Nacimiento_Deudor"] = $_POST["fecha_deudor"];
            $nueva_cotizacion["Fecha_de_Nacimiento_Codeudor"] = $_POST["fecha_codeudor"];
            $nueva_cotizacion["Quote_Stage"] = "Cotizando";
            $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
            $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
            $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
            $nueva_cotizacion["Tipo_P_liza"] = "Declarativa";
            $nueva_cotizacion["Plan"] = "Vida";
            $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
            $nueva_cotizacion["Plazo"] =  $_POST["plazo"];

            $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);

            header("Location:" . constant("url") . "vida/detalles/$nuevo_cotizacion_id");
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/vida/crear.php";
        require_once "views/layout/footer_main.php";
    }
}
