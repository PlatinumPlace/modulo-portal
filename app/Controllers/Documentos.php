<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Documentos extends BaseController
{
	function __construct()
	{
		$this->api = new Zoho;
	}

    public function index($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        return view("documentos", ["cotizacion" => $detalles, "api" => $this->api]);
    }

    public function descargar($json)
    {
        $json = json_decode($json);
        $fichero = $this->api->downloadAttachment("Products", $json[0], $json[1], WRITEPATH . "uploads");
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
}
