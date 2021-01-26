<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class PolizasController extends Controller
{
    public function index()
    {
        $api = new Zoho;
        $criteria = "Account_Name:equals:" . session("empresaid");
        $polizas =  $api->searchRecordsByCriteria("Deals", $criteria, 1, 200);
        return view("polizas/index", ["polizas" => $polizas]);
    }

    public function detalles($id)
    {
        $api = new Zoho;
        $poliza = $api->getRecord("Deals", $id);
        $bien = $api->getRecord("Bienes", $poliza->getFieldValue('Bien')->getEntityId());
        return view("polizas/detalles", ["poliza" => $poliza, "bien" => $bien]);
    }

    public function descargar($id)
    {
        $api = new Zoho;
        $poliza = $api->getRecord("Deals", $id);
        $bien = $api->getRecord("Bienes", $poliza->getFieldValue('Bien')->getEntityId());
        $imagen = $api->downloadPhoto("Vendors", $poliza->getFieldValue('Aseguradora')->getEntityId());
        $plan = $api->getRecord("Products", $poliza->getFieldValue('Coberturas')->getEntityId());
        return view("polizas/descargar", ["poliza" => $poliza, "imagen" => $imagen, "bien" => $bien, "plan" => $plan]);
    }
}
