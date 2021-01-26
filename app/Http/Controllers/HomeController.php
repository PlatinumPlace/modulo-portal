<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $api = new Zoho;
        $total = 0;
        $emisiones = 0;
        $criteria = "Account_Name:equals:" . session("empresaid");
        $lista =  $api->searchRecordsByCriteria("Quotes", $criteria, 1, 200);

        foreach ($lista as $cotizacion) {
            if (date("Y-m", strtotime($cotizacion->getCreatedTime())) == date('Y-m')) {
                $total++;
                if (!empty($cotizacion->getFieldValue('Deal_Name'))) {
                    $emisiones++;
                    $poliza = $api->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
                    $aseguradoras[] = $poliza->getFieldValue('Aseguradora')->getLookupLabel();
                }
            }
        }

        return view(
            "home.index",
            [
                "cotizaciones" => $total,
                "emisiones" => $emisiones,
                "aseguradoras" => array_count_values($aseguradoras)
            ]
        );
    }
}
