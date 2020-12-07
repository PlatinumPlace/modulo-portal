<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zoho;

class PolizasController extends Controller
{
    protected $api;

    function __construct(Zoho $api)
    {
        $this->api = $api;
    }

    public function detalles($id)
    {
        $detalles = $this->api->getRecord("Deals", $id);
        return view("polizas.detalles", ["detalles" => $detalles, "api" => $this->api]);
    }

    public function descargar($id)
    {
        $detalles = $this->api->getRecord("Deals", $id);
        $imagen = $this->api->downloadPhoto("Vendors", $detalles->getFieldValue('Aseguradora')->getEntityId());
        $planDetalles = $this->api->getRecord("Products", $detalles->getFieldValue('Coberturas')->getEntityId());
        return view("polizas.descargar", ["detalles" => $detalles, "imagen" => $imagen, "planDetalles" => $planDetalles]);
    }
    
    public function reportes()
    {
        if (session("excel")) {
            $fichero = session("excel");
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

        $criterio = "Corredor:equals:" . session("empresaid");
        $planes = $this->api->searchRecordsByCriteria("Products", $criterio, 1, 200);
        return view("polizas.reportes", ["planes" => $planes]);
    }
}
