<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zoho;

class CotizacionesController extends Controller
{
    protected $api;

    function __construct(Zoho $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        return view("cotizaciones.index");
    }

    public function cotizar($tipo)
    {
        $marcas = $this->api->getRecords("Marcas");
        sort($marcas);

        switch ($tipo) {
            case 'auto':
                $rutapost = "cotizacionesAuto.store";
                break;

            case 'vida':
                $rutapost = "cotizacionesVida.store";
                break;
        }

        return view("cotizaciones.cotizar", [
            "tipo" => $tipo,
            "marcas" => $marcas,
            "rutapost" => $rutapost
        ]);
    }

    public function modelos(Request $request)
    {
        $pag = 1;
        $criteria = "Marca:equals:" . $request->input("marcaid");

        do {
            if ($modelos = $this->api->searchRecordsByCriteria("Modelos", $criteria, $pag, 200)) {
                $pag++;
                asort($modelos);
                foreach ($modelos as $modelo) {
                    echo '<option value="' . $modelo->getEntityId() . "," . $modelo->getFieldValue('Tipo') . '">' . strtoupper($modelo->getFieldValue('Name')) . '</option>';
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);
    }

    public function detalles($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.detalles", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
    }

    public function descargar($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.descargar", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
    }

    public function documentos($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.documentos", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
    }

    public function adjunto($planid, $adjuntoid)
    {
        $fichero = $this->api->downloadAttachment("Products", $planid, $adjuntoid, storage_path("app/public"));
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fichero) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fichero));
        readfile($fichero);
        unlink($fichero);
    }

    public function emitir($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);

        if (!empty($detalles->getFieldValue('Deal_Name'))) {
            abort(404);
        }

        $planes = $detalles->getLineItems();

        switch ($detalles->getFieldValue('Tipo')) {
            case 'Auto':
                $rutapost = "polizasAuto.store";
                break;

            case 'Vida':
                $rutapost = "polizasVida.store";
                break;
        }

        return view("cotizaciones.emitir", [
            "rutapost" => $rutapost,
            "detalles" => $detalles,
            "planes" => $planes,
            "api" => $this->api
        ]);
    }
}
