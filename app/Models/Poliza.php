<?php

namespace App\Models;

class Poliza extends Zoho
{
    public function lista($pag = 1, $cantidad = 200)
    {
        $criterio = "Account_Name:equals:" . session("empresaid");
        return $this->searchRecordsByCriteria("Deals", $criterio, $pag, $cantidad);
    }

    public function buscar($parametro, $busqueda)
    {
        $criterio = "((Account_Name:equals:" . session("empresaid") . ") and ($parametro:equals:$busqueda))";
        return $this->searchRecordsByCriteria("Deals", $criterio, 1, 200);
    }

    public function detalles($id)
    {
        return $this->getRecord("Deals", $id);
    }

    public function listaAdjunto($planid)
    {
        return $this->getAttachments("Products", $planid, 1, 200);
    }

    public function rutaAdjunto($planid, $adjuntoid)
    {
        return $this->downloadAttachment("Products", $planid, $adjuntoid, storage_path("app/public"));
    }

    public function rutaImagenAseguradora($aseguradoraid)
    {
        return $this->downloadPhoto("Vendors", $aseguradoraid);
    }

    public function detallesPlan($planid)
    {
        return $this->getRecord("Products", $planid);
    }

    public function detallesCotizacion($cotizacionid)
    {
        return $this->getRecord("Quotes", $cotizacionid);
    }

    public function crear($registro)
    {
        return $this->createRecords("Deals", $registro);
    }

    public function actualizarCotizacion($cotizacionid,$id)
    {
        return $this->update("Quotes", $cotizacionid, ["Deal_Name" => $id]);
    }

    public function adjuntarArchivo($id,$ruta)
    {
        $this->uploadAttachment("Deals", $id, storage_path("app/$ruta"));
        unlink(storage_path("app/$ruta"));
    }
}
