<?php

namespace App\Models;

class Persona extends Zoho
{
    public function calcularPrima($planid, $plan, $cuota, $suma, $edad_codeudor)
    {
        $criterio = "Plan:equals:$planid";
        $tasas = $this->searchRecordsByCriteria("Tasas", $criterio, 1, 200);
        foreach ($tasas as $tasa) {
            switch ($tasa->getFieldValue('Tipo')) {
                case 'Deudor':
                    $deudor = ($tasa->getFieldValue('Valor') / 100);
                    break;

                case 'Codeudor':
                    $codeudor = ($tasa->getFieldValue('Valor') / 100);
                    break;

                case 'Vida':
                    $vida = ($tasa->getFieldValue('Valor') / 100);
                    break;

                case 'Desempleo':
                    $desempleo = $tasa->getFieldValue('Valor');
                    break;
            }
        }

        if ($plan == "Vida") {
            if (empty($edad_codeudor)) {
                return ($suma / 1000) * $deudor;
            } else {
                $prima_deudor = ($suma / 1000) * $deudor;
                $prima_codeudor = ($suma / 1000) * ($codeudor - $deudor);
                return $prima_deudor + $prima_codeudor;
            }
        } else {
            $prima_vida = ($suma / 1000) * $vida;
            $prima_desempleo =  ($cuota / 1000) * $desempleo;
            return $prima_vida + $prima_desempleo;
        }
    }
}
