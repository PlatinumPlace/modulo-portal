<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Lista extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function cotizaciones()
    {
        $criteria = "Account_Name:equals:" . session()->get("empresaid");
        $cotizaciones =  $this->api->searchRecordsByCriteria("Quotes", $criteria, 1, 200);
        return view("lista/cotizaciones", ["cotizaciones" => $cotizaciones]);
    }

    public function polizas()
    {
        $criteria = "Account_Name:equals:" . session()->get("empresaid");
        $polizas =  $this->api->searchRecordsByCriteria("Deals", $criteria, 1, 200);
        return view("lista/polizas", ["polizas" => $polizas]);
    }
}
