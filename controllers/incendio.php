<?php

class incendio
{
    function crear()
    {
        $api = new api;

        if ($_POST) {
            $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Incendio))";
            $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);

            $edad_deudor = calcular_edad($_POST["fecha_deudor"]);

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
                    $tasa_deudor = $tasa->getFieldValue('Valor');
                }

                $tasa_deudor = ($tasa_deudor / 100) / 100;
                $prima = $_POST["valor"] * $tasa_deudor / 12;

                $plan_seleccionado[] = array(
                    "id" => $plan_id,
                    "prima" => $prima,
                    "cantidad" => 1,
                    "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                    "impuesto" => "ITBIS 16",
                    "impuesto_valor" => 16
                );
            }

            $nueva_cotizacion["Subject"] = "Plan Incendio";
            $nueva_cotizacion["Fecha_Nacimiento_Deudor"] = $_POST["fecha_deudor"];
            $nueva_cotizacion["Quote_Stage"] = "Cotizando";
            $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
            $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
            $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
            $nueva_cotizacion["Tipo_P_liza"] = "Declarativa";
            $nueva_cotizacion["Plan"] = "Incendio";
            $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
            $nueva_cotizacion["Plazo"] =  $_POST["plazo"];

            $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);

            header("Location:" . constant("url") . "incendio/detalles/$nuevo_cotizacion_id");
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/incendio/crear.php";
        require_once "views/layout/footer_main.php";
    }

    public function detalles()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[3]) and !is_numeric($url[3])) ? $url[3] : null;
        $num_pagina = (isset($url[3]) and is_numeric($url[3])) ? $url[3] : 1;

        if (!isset($url[2])) {
            require_once "views/error.php";
            exit();
        }

        $id = $url[2];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/incendio/detalles.php";
        require_once "views/layout/footer_main.php";
    }
}
