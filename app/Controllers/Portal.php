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
        return view("index", [
            "cotizaciones" => 0,
            "emisiones" => 0,
            "aseguradoras" => array()
        ]);
    }
}
