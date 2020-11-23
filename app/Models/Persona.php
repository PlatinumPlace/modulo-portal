<?php

namespace App\Models;

class Persona extends Zoho
{
    public function crear($edad_deudor, $edad_codeudor, $plazo, $cuota, $tipoplan, $suma)
    {
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Persona))";
        $listaPlanes = $this->searchRecordsByCriteria("Products", $criterio, 1, 200);
        $planes = array();

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
                $prima = $this->calcularPrima(
                    $plan->getEntityId(),
                    $tipoplan,
                    $cuota,
                    $suma,
                    $edad_codeudor
                );
            }

            $planes[] = ["id" => $plan->getEntityId(), "precio" => $prima, "descripcion" => $motivo];
        }

        $registro = [
            "Subject" => "Cotización",
            "Account_Name" => session("empresaid"),
            "Contact_Name" => session("id"),
            "Plan" => $tipoplan,
            "Edad_codeudor" => $edad_codeudor,
            "Edad_deudor" => $edad_deudor,
            "Cuota" => $cuota,
            "Plazo" => $plazo,
            "Tipo" => "Persona",
            "Suma_Asegurada" => $suma,
            "Nombre_cliente" =>  $request->input("nombre")
        ];

        return $this->createRecords("Quotes", $registro, $planes);
    }

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
