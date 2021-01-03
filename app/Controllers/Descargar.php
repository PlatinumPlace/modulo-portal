<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Descargar extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function cotizacion($id)
    {
        $cotizacion = $this->api->getRecord("Quotes", $id);
        switch ($cotizacion->getFieldValue('Tipo')) {
            case 'Auto':
                return view("descargar/cotizacion/auto", ["cotizacion" => $cotizacion, "api" => $this->api]);
                break;

            case 'Vida':
                return view("descargar/cotizacion/vida", ["cotizacion" => $cotizacion, "api" => $this->api]);
                break;
        }
    }

    public function poliza($id)
    {
        $poliza = $this->api->getRecord("Deals", $id);
        $bien = $this->api->getRecord("Bienes", $poliza->getFieldValue('Bien')->getEntityId());
        $imagen = $this->api->downloadPhoto("Vendors", $poliza->getFieldValue('Aseguradora')->getEntityId());
        $plan = $this->api->getRecord("Products", $poliza->getFieldValue('Coberturas')->getEntityId());
        switch ($poliza->getFieldValue('Type')) {
			case 'Auto':
                return view("descargar/poliza/auto", [
                    "poliza" => $poliza,
                    "imagen" => $imagen,
                    "bien" => $bien,
                    "plan" => $plan
                ]);
				break;

			case 'Vida':
                return view("descargar/poliza/vida", [
                    "poliza" => $poliza,
                    "imagen" => $imagen,
                    "bien" => $bien,
                    "plan" => $plan
                ]);
				break;
		}
    }
}
