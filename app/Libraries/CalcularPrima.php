<?php

namespace App\Libraries;

class CalcularPrima
{
    public function auto($api, $planid, $modelotipo, $a_o, $marca, $suma)
    {
        $criterio = "Plan:equals:$planid";

        $tasas = $api->searchRecordsByCriteria("Tasas", $criterio, 1, 200);
        foreach ($tasas as $tasa) {
            if (
                in_array($modelotipo, $tasa->getFieldValue('Grupo_de_veh_culo'))
                and
                $tasa->getFieldValue('A_o') == $a_o
            ) {
                $valortasa = $tasa->getFieldValue('Valor') / 100;
            }
        }

        $recargos = $api->searchRecordsByCriteria("Recargos", $criterio, 1, 200);
        $recargovalor = 0;
        foreach ($recargos as $recargo) {
            if (
                $recargo->getFieldValue('Marca')->getEntityId() == $marca
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
                            $$a_o < $recargo->getFieldValue('Hasta'))
                        or
                        ($$a_o > $recargo->getFieldValue('Desde')
                            or
                            $$a_o < $recargo->getFieldValue('Hasta'))))
            ) {
                $recargovalor = $recargo->getFieldValue('Valor') / 100;
            }
        }

        $valortasa = ($valortasa + ($valortasa * $recargovalor));
        return $suma * $valortasa;
    }

    public function deudor($tasas, $suma)
    {
        foreach ($tasas as $tasa) {
            if ($tasa->getFieldValue('Tipo') == 'Deudor') {
                $deudor = ($tasa->getFieldValue('Valor') / 100);
            }
        }

        return ($suma / 1000) * $deudor;
    }

    public function codeudor($tasas, $suma, $prima)
    {
        foreach ($tasas as $tasa) {
            switch ($tasa->getFieldValue('Tipo')) {
                case 'Deudor':
                    $deudor = ($tasa->getFieldValue('Valor') / 100);
                    break;

                case 'Codeudor':
                    $codeudor = ($tasa->getFieldValue('Valor') / 100);
                    break;
            }
        }

        $prima_codeudor = ($suma / 1000) * ($codeudor - $deudor);
        return $prima + $prima_codeudor;
    }

    public function desempleo($tasas, $suma, $cuota)
    {
        foreach ($tasas as $tasa) {
            switch ($tasa->getFieldValue('Tipo')) {
                case 'Vida':
                    $vida = ($tasa->getFieldValue('Valor') / 100);
                    break;

                case 'Desempleo':
                    $desempleo = $tasa->getFieldValue('Valor');
                    break;
            }
        }

        $prima_vida = ($suma / 1000) * $vida;
        $prima_desempleo =  ($cuota / 1000) * $desempleo;
        return $prima_vida + $prima_desempleo;
    }
}
