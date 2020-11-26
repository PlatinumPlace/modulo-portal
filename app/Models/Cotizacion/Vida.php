<?php

namespace App\Models\Cotizacion;

use App\Models\Cotizacion;

class Vida extends Cotizacion
{
    public function seleccionarPlanes($edad_deudor, $edad_codeudor, $plazo, $suma, $cuota)
    {
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Vida))";
        $listaPlanes = $this->searchRecordsByCriteria("Products", $criterio, 1, 200);
        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (
                $edad_deudor > $plan->getFieldValue('Edad_max')
                or
                (!empty($edad_codeudor)
                    and
                    $edad_codeudor > $plan->getFieldValue('Edad_max'))
            ) {
                $motivo = "La edad del deudor/codeudor es mayor al limite establecido.";
            }

            if (
                $edad_deudor < $plan->getFieldValue('Edad_min')
                or (!empty($edad_codeudor)
                    and
                    $edad_codeudor < $plan->getFieldValue('Edad_min'))
            ) {
                $motivo = "La edad del deudor/codeudor es menor al limite establecido.";
            }

            if ($plazo > $plan->getFieldValue('Plazo_max')) {
                $motivo = "El plazo es mayor al limite establecido.";
            }

            if ($suma > $plan->getFieldValue('Suma_asegurada_max')) {
                $motivo = "La suma asegurada es mayor al limite establecido.";
            }

            if (empty($motivo)) {
                $criterio = "Plan:equals:" . $plan->getEntityId();
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
                        $prima = ($suma / 1000) * $deudor;
                    } else {
                        $prima_deudor = ($suma / 1000) * $deudor;
                        $prima_codeudor = ($suma / 1000) * ($codeudor - $deudor);
                        $prima = $prima_deudor + $prima_codeudor;
                    }
                } else {
                    $prima_vida = ($suma / 1000) * $vida;
                    $prima_desempleo =  ($cuota / 1000) * $desempleo;
                    $prima = $prima_vida + $prima_desempleo;
                }
            }

            $planes[] = ["id" => $plan->getEntityId(), "precio" => $prima, "descripcion" => $motivo];
        }

        return $planes;
    }
}
