<?php

namespace App\Models;

class Vehiculo extends Zoho
{
    public function verificarMarcaRestrida($aseguradoraid, $marcaid)
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

    public function verificarModeloRestringido($aseguradoraid, $modeloid)
    {
        $criterio = "((Modelo:equals:$modeloid) and (Aseguradora:equals:$aseguradoraid))";
        if ($modelos = $this->searchRecordsByCriteria("Restringidos", $criterio, 1, 200)) {
            foreach ($modelos as $modelo) {
                return true;
            }
        }
    }

    public function calcularPrima($planid, $tipo, $a_o, $marcaid, $suma)
    {
        if ($tasa = $this->calcularTasaVehiculo($planid, $tipo, $a_o)) {
            if ($recargo = $this->calcularRecargoVehiculo($planid, $tipo, $a_o, $marcaid)) {
                $tasa = ($tasa + ($tasa * $recargo));
            }

            return $suma * $tasa;
        }
    }

    public function calcularTasaVehiculo($planid, $tipo, $a_o)
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

    public function calcularRecargoVehiculo($planid, $tipo, $a_o, $marcaid)
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
