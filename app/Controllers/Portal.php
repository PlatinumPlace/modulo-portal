<?php

namespace App\Controllers;

use App\Libraries\Portal as LibrariesPortal;
use App\Libraries\Zoho;

class Portal extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
        $this->libraries = new LibrariesPortal;
    }

    public function index()
    {
        $result = $this->libraries->resumen($this->api);
        return view("index", ["cotizaciones" => $result["cotizaciones"], "emisiones" => $result["emisiones"], "aseguradoras" => $result["aseguradoras"]]);
    }
}
