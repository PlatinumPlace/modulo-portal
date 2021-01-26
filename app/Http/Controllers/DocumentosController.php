<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    public function index(Request $request, $id)
    {
        $api = new Zoho;
        if ($request->input()) {
            $fichero = $api->downloadAttachment("Products", $request->input("plan"), $request->input("documento"), public_path("tmp"));
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

        $cotizacion = $api->getRecord("Quotes", $id);
        return view("documentos.index", ["cotizacion" => $cotizacion, "api" => $api]);
    }
}
