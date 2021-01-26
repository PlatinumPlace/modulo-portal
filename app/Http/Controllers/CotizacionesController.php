<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    public function index()
    {
        $api = new Zoho;
        $criteria = "Account_Name:equals:" . session("empresaid");
        $cotizaciones =  $api->searchRecordsByCriteria("Quotes", $criteria, 1, 200);
        return view("cotizaciones.index", ["cotizaciones" => $cotizaciones]);
    }

    public function detalles($id)
    {
        $api = new Zoho;
        $cotizacion = $api->getRecord("Quotes", $id);
        return view("cotizaciones.detalles", ["cotizacion" => $cotizacion, "api" => $api]);
    }

    public function descargar($id)
    {
        $api = new Zoho;
        $cotizacion = $api->getRecord("Quotes", $id);
        return view("cotizaciones.descargar", ["cotizacion" => $cotizacion, "api" => $api]);
    }
}
