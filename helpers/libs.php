<?php

function obtener_url()
{
    $url = rtrim($_GET['url'], "/");
    return explode('/', $url);
}

function calcular_edad($fecha)
{
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}

function calcular_prima($api,$contrato, $tipo_vehiculo)
{
    $tasa_valor = 0;
    $criterio = "Contrato:equals:" . $contrato->getEntityId();
    $tasas = $api->searchRecordsByCriteria("Tasas", $criterio);
    $recargos = $api->searchRecordsByCriteria("Recargos", $criterio);

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
