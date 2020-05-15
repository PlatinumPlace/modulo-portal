<?php

class cotizacion extends api
{

    function __construct()
    {
        parent::__construct();
    }

    public function lista()
    {
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }

    public function buscar($parametro, $busqueda)
    {
        $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and ($parametro:equals:$busqueda))";
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }

    public function crear($cotizacion)
    {
        return $this->createRecord("Deals", $cotizacion);
    }

    public function detalles($id)
    {
        $resultado["oferta"] = $this->getRecord("Deals", $id);

        $criterio = "Deal_Name:equals:" . $id;
        $resultado["cotizaciones"] = $this->searchRecordsByCriteria("Quotes", $criterio);

        return $resultado;
    }

    public function actualizar($id, $cotizacion)
    {
        return $this->updateRecord("Deals", $id, $cotizacion);
    }

    public function adjuntar_archivos($id, $ruta_archivo)
    {
        return $this->uploadAttachment("Deals", $id, $ruta_archivo);
    }

    public function lista_documentos_adjuntos($id)
    {
        return $this->getAttachments("Deals", $id);
    }

    public function exportar_csv_emisiones($tipo_cotizacion, $aseguradpra_id, $desde, $hasta)
    {
        
        
    }

}
