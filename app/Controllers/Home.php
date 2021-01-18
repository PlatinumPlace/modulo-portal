<?php

namespace App\Controllers;

use App\Libraries\Home as LibrariesHome;
use App\Libraries\Zoho;

class Home extends BaseController
{
	function __construct()
	{
		$this->api = new Zoho;
		$this->libraries = new LibrariesHome;
	}

	public function index()
	{
		$result = $this->libraries->resumen($this->api);
		return view("home/index", ["cotizaciones" => $result["cotizaciones"], "emisiones" => $result["emisiones"], "aseguradoras" => $result["aseguradoras"]]);
	}
}
