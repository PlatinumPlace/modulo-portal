<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolizasController extends Controller
{
    public function emitir(Request $request, $id)
    {

        $api = new Zoho;
        $detalles = $api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();

        if ($request->input()) {

            switch ($detalles->getFieldValue('Plan')) {
                case 'Full':
                    $cotizaciones = new SeguroVehiculo;


                    return redirect("poliza/$id");
                    break;

                default:
                    # code...
                    break;
            }
        }

        return view("cotizaciones.emitir", [
            "detalles" => $detalles,
            "planes" => $planes,
            "api" => $api
        ]);
    }
}
