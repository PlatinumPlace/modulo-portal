<?php

namespace App\Models;

class Vehiculo extends Zoho
{
    public function crear($marcaid, $modeloid, $a_o, $uso, $tipoplan, $suma)
    {
        $modelo = $this->getRecord("Modelos", $modeloid);
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Vehículo))";
        $listaPlanes = $this->searchRecordsByCriteria("Products", $criterio, 1, 200);
        $planes = array();

        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (in_array($uso, $plan->getFieldValue('Restringir_veh_culos_de_uso'))) {
                $motivo = "Uso del vehículo restringido.";
            }

            if ((date("Y") - $a_o) > $plan->getFieldValue('Max_antig_edad')) {
                $motivo = "La antigüedad del vehículo (" . (date("Y") - $a_o) . ")  es mayor al limite establecido (" . $plan->getFieldValue('Max_antig_edad') . ")";
            }

            if ($this->verificarMarcaRestrida($plan->getFieldValue('Vendor_Name')->getEntityId(), $marcaid)) {
                $motivo = "Marca restrigida.";
            }

            if ($this->verificarModeloRestringido($plan->getFieldValue('Vendor_Name')->getEntityId(), $modeloid)) {
                $motivo = "Modelo restrigido.";
            }

            if (empty($motivo)) {
                if ($prima = $this->calcularPrima($plan->getEntityId(), $modelo->getFieldValue('Tipo'), $a_o, $marcaid, $suma)) {
                    if ($prima < $plan->getFieldValue('Prima_m_nima')) {
                        $prima = $plan->getFieldValue('Prima_m_nima');
                    }

                    $prima = $prima / 12;
                } else {
                    $motivo = "No existen tasas para el tipo de vehículo especificado.";
                }
            }

            $planes[] = ["id" => $plan->getEntityId(), "precio" => $prima, "descripcion" => $motivo];
        }

        $registro = [
            "Subject" => "Cotización",
            "Account_Name" => session("empresaid"),
            "Contact_Name" => session("id"),
            "Plan" => $tipoplan,
            "A_o" => $a_o,
            "Marca" => $marcaid,
            "Modelo" => $modeloid,
            "Uso" => $uso,
            "Tipo" => "Vehículo",
            "Tipo_veh_culo" => $modelo->getFieldValue('Tipo'),
            "Suma_Asegurada" => $suma
        ];

        return $this->createRecords("Quotes", $registro, $planes);
    }

    private function verificarMarcaRestrida($aseguradoraid, $marcaid)
    {
        $criterio = "((Marca:equals:$marcaid) and (Aseguradora:equals:$aseguradoraid))";
        if ($marcas = $this->searchRecordsByCriteria("Restringidos", $criterio, 1, 200)) {
            foreach ($marcas as $marca) {
                if (empty($marca->getFieldValue('Modelo'))) {
                    return true;
                }
            }
        }
    }

    private function verificarModeloRestringido($aseguradoraid, $modeloid)
    {
        $criterio = "((Modelo:equals:$modeloid) and (Aseguradora:equals:$aseguradoraid))";
        if ($modelos = $this->searchRecordsByCriteria("Restringidos", $criterio, 1, 200)) {
            foreach ($modelos as $modelo) {
                return true;
            }
        }
    }

    private function calcularPrima($planid, $tipo, $a_o, $marcaid, $suma)
    {
        if ($tasa = $this->calcularTasaVehiculo($planid, $tipo, $a_o)) {
            if ($recargo = $this->calcularRecargoVehiculo($planid, $tipo, $a_o, $marcaid)) {
                $tasa = ($tasa + ($tasa * $recargo));
            }

            return $suma * $tasa;
        }
    }

    private function calcularTasaVehiculo($planid, $tipo, $a_o)
    {
        $criterio = "Plan:equals:$planid";
        $tasas = $this->searchRecordsByCriteria("Tasas", $criterio, 1, 200);
        foreach ($tasas as $tasa) {
            if (
                in_array($tipo, $tasa->getFieldValue('Grupo_de_veh_culo'))
                and
                $tasa->getFieldValue('A_o') == $a_o
            ) {
                return $tasa->getFieldValue('Valor') / 100;
            }
        }
    }

    private function calcularRecargoVehiculo($planid, $tipo, $a_o, $marcaid)
    {
        $criterio = "Plan:equals:$planid";
        if ($recargos = $this->searchRecordsByCriteria("Recargos", $criterio, 1, 200)) {
            foreach ($recargos as $recargo) {
                if (
                    $recargo->getFieldValue('Marca')->getEntityId() == $marcaid
                    and
                    (($tipo == $recargo->getFieldValue("Tipo")
                        or
                        empty($recargo->getFieldValue("Tipo")))
                        and
                        ((empty($recargo->getFieldValue('Desde'))
                            and
                            empty($recargo->getFieldValue('Hasta')))
                            or
                            ($a_o > $recargo->getFieldValue('Desde')
                                and
                                $a_o < $recargo->getFieldValue('Hasta'))
                            or
                            ($a_o > $recargo->getFieldValue('Desde')
                                or
                                $a_o < $recargo->getFieldValue('Hasta'))))
                ) {
                    return $recargo->getFieldValue('Valor') / 100;
                }
            }
        }
    }
}
