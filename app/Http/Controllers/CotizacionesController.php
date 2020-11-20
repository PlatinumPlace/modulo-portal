<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Vehiculo;
use App\Models\Zoho;
use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    public function index($pagina = 1)
    {
        $api = new Zoho;
        $criterio = "Account_Name:equals:" . session("empresaid");
        if (!$lista = $api->searchRecordsByCriteria("Quotes", $criterio, $pagina, 10)) {
            $lista = array();
        }
        return view("cotizaciones.index", ["lista" => $lista, "pagina" => $pagina]);
    }

    public function buscar(Request $request)
    {
        $api = new Zoho;
        $criterio = "((Account_Name:equals:" . session("empresaid") . ") and (Quote_Number:equals:" . $request->input("num") . "))";
        if (!$lista = $api->searchRecordsByCriteria("Quotes", $criterio, 1, 1)) {
            $lista = array();
        }
        return view("cotizaciones.index", ["lista" => $lista, "pag" => 1]);
    }

    public function cotizar($tipo)
    {
        $api = new Zoho;
        switch ($tipo) {
            case 'vehiculo':
                $marcas = $api->getRecords("Marcas");
                asort($marcas);
                return view("cotizaciones.cotizar", ["tipo" => "vehiculo", "marcas" => $marcas]);
                break;

            case 'persona':
                return view("cotizaciones.cotizar", ["tipo" => "persona"]);
                break;
        }
    }

    public function modelosAJAX(Request $request)
    {
        $api = new Zoho;
        $pag = 1;
        $criterio = "Marca:equals:" . $request->input("marcaid");

        do {
            if ($modelos = $api->searchRecordsByCriteria("Modelos", $criterio, $pag, 200)) {
                $pag++;
                asort($modelos);
                foreach ($modelos as $modelo) {
                    echo '<option value="' . $modelo->getEntityId() . '">' . strtoupper($modelo->getFieldValue('Name')) . '</option>';
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);
    }

    public function vehiculo(Request $request)
    {
        $api = new Vehiculo;
        $id = $api->crear(
            $request->input("marca"),
            $request->input("modelo"),
            $request->input("a_o"),
            $request->input("uso"),
            $request->input("plan"),
            $request->input("suma")
        );
        return redirect("cotizacion/$id");
    }

    public function persona(Request $request)
    {
        $api = new Persona;
        $id = $api->crear(
            $request->input("edad_deudor"),
            $request->input("edad_codeudor"),
            $request->input("plazo"),
            $request->input("cuota"),
            $request->input("plan"),
            $request->input("suma")
        );
        return redirect("cotizacion/$id");
    }

    public function detalles($id)
    {
        $api = new Zoho;
        $detalles = $api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.detalles", [
            "detalles" => $detalles,
            "planes" => $planes,
            "api" => $api
        ]);
    }

    public function descargar($id)
    {
        $api = new Zoho;
        $detalles = $api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.descargar", [
            "detalles" => $detalles,
            "planes" => $planes,
            "api" => $api
        ]);
    }
}
