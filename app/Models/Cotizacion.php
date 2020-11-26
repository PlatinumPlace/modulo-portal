<?php

namespace App\Models;

class Cotizacion extends Zoho
{
    public function lista($pag = 1, $cantidad = 200)
    {
        $criterio = "Account_Name:equals:" . session("empresaid");
        return $this->searchRecordsByCriteria("Quotes", $criterio, $pag, $cantidad);
    }

    public function buscar($num)
    {
        $criterio = "((Account_Name:equals:" . session("empresaid") . ") and (Quote_Number:equals:$num))";
        return $this->searchRecordsByCriteria("Quotes", $criterio, 1, 200);
    }

    public function detalles($id)
    {
        return $this->getRecord("Quotes", $id);
    }

    public function rutaImagenAseguradora($aseguradoraid)
    {
        return $this->downloadPhoto("Vendors", $aseguradoraid);
    }

    public function detallesPlan($planid)
    {
        return $this->getRecord("Products", $planid);
    }

    public function crear($registro, $planes)
    {
        return $this->createRecords("Quotes", $registro, $planes);
    }
}
