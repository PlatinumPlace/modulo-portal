<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Home extends BaseController
{
	function __construct()
	{
		$this->api = new Zoho;
	}

	public function index()
	{
		//Cotizaciones
		$total = 0;
		$emisiones = 0;
		$criteria = "Account_Name:equals:" . session()->get("empresaid");
		$lista =  $this->api->searchRecordsByCriteria("Quotes", $criteria, 1, 200);
		foreach ($lista as $cotizacion) {
			if (date("Y-m", strtotime($cotizacion->getCreatedTime())) == date('Y-m')) {
				$total++;
				if (!empty($cotizacion->getFieldValue('Deal_Name'))) {
					$emisiones++;
				}
			}
		}

		//Emisiones
		$aseguradoras = array();
		$criteria = "Account_Name:equals:" . session()->get("empresaid");
		$lista =  $this->api->searchRecordsByCriteria("Deals", $criteria, 1, 200);
		foreach ($lista as $poliza) {
			if (date("Y-m", strtotime($poliza->getCreatedTime())) == date('Y-m')) {
				$aseguradoras[] = $poliza->getFieldValue('Aseguradora')->getLookupLabel();
			}
		}
		$aseguradoras = array_count_values($aseguradoras);

		return view("index", [
			"cotizaciones" => $total,
			"emisiones" => $emisiones,
			"aseguradoras" => $aseguradoras
		]);
	}
}
