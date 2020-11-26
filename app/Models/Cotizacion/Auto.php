<?php

namespace App\Models\Cotizacion;

use App\Models\Cotizacion;

class Auto extends Cotizacion
{
    public function listaMarcas()
    {
        return $this->getRecords("Marcas");
    }

    public function listaModelos($marcaid, $pag)
    {
        $criterio = "Marca:equals:$marcaid";
        return $this->searchRecordsByCriteria("Modelos", $criterio, $pag, 200);
    }

    public function seleccionarPlanes($uso, $a_o, $marcaid, $modeloid, $modelotipo, $suma)
    {
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Auto))";
        $listaPlanes = $this->searchRecordsByCriteria("Products", $criterio, 1, 200);
        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (in_array($uso, $plan->getFieldValue('Restringir_veh_culos_de_uso'))) {
                $motivo = "Uso del vehículo restringido.";
            }

            if ((date("Y") - $a_o) > $plan->getFieldValue('Max_antig_edad')) {
                $motivo = "La antigüedad del vehículo (" . (date("Y") - $a_o) . ")  es mayor al limite establecido (" . $plan->getFieldValue('Max_antig_edad') . ")";
            }

            $criterio = "((Marca:equals:$marcaid) and (Aseguradora:equals:" . $plan->getFieldValue('Vendor_Name')->getEntityId() . "))";
            if ($marcas = $this->searchRecordsByCriteria("Restringidos", $criterio, 1, 200)) {
                foreach ($marcas as $marca) {
                    if (empty($marca->getFieldValue('Modelo'))) {
                        $motivo = "Marca restrigida.";
                    }
                }
            }

            $criterio = "((Modelo:equals:$modeloid) and (Aseguradora:equals:" . $plan->getFieldValue('Vendor_Name')->getEntityId() . "))";
            if ($modelos = $this->searchRecordsByCriteria("Restringidos", $criterio, 1, 200)) {
                foreach ($modelos as $modelo) {
                    $motivo = "Modelo restrigido.";
                }
            }

            if (empty($motivo)) {
                $criterio = "Plan:equals:" . $plan->getEntityId();
                $tasas = $this->searchRecordsByCriteria("Tasas", $criterio, 1, 200);
                foreach ($tasas as $tasa) {
                    if (
                        in_array($modelotipo, $tasa->getFieldValue('Grupo_de_veh_culo'))
                        and
                        $tasa->getFieldValue('A_o') == $a_o
                    ) {
                        $tasavalor = $tasa->getFieldValue('Valor') / 100;
                    }
                }

                if ($tasavalor) {
                    $criterio = "Plan:equals:" . $plan->getEntityId();
                    if ($recargos = $this->searchRecordsByCriteria("Recargos", $criterio, 1, 200)) {
                        foreach ($recargos as $recargo) {
                            if (
                                $recargo->getFieldValue('Marca')->getEntityId() == $marcaid
                                and
                                (($modelotipo == $recargo->getFieldValue("Tipo")
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
                                $recargovalor = $recargo->getFieldValue('Valor') / 100;
                            }
                        }
                    }

                    if (!empty($recargovalor)) {
                        $tasavalor = ($tasavalor + ($tasavalor * $recargovalor));
                    }

                    $prima = $suma * $tasavalor;

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

        return $planes;
    }

    public function crear($registro, $planes)
    {
        return $this->createRecords("Quotes", $registro, $planes);
    }
}
