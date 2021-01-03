<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Detalles extends BaseController
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
				return view("detalles/cotizacion/auto", ["cotizacion" => $cotizacion, "api" => $this->api]);
				break;

			case 'Vida':
				return view("detalles/cotizacion/vida", ["cotizacion" => $cotizacion, "api" => $this->api]);
				break;
		}
	}

	public function poliza($id)
	{
        $poliza = $this->api->getRecord("Deals", $id);
        $bien = $this->api->getRecord("Bienes", $poliza->getFieldValue('Bien')->getEntityId());
		switch ($poliza->getFieldValue('Type')) {
			case 'Auto':
				return view("detalles/poliza/auto", ["poliza" => $poliza, "bien" => $bien]);
				break;

			case 'Vida':
				return view("detalles/poliza/vida", ["poliza" => $poliza,"bien" => $bien]);
				break;
		}
	}
}
