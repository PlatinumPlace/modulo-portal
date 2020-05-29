<?php

class cotizacion extends api
{
    public $usuario;

    function __construct()
    {
        $this->usuario = json_decode($_COOKIE["usuario"], true);

        parent::__construct();
    }

    public function lista()
    {
        $criterio = "Contact_Name:equals:" . $this->usuario['id'];
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }

    public function buscar($parametro, $busqueda)
    {
        $criterio = "((Contact_Name:equals:" .  $this->usuario['id'] . ") and ($parametro:equals:$busqueda))";
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

    public function lista_marcas()
    {
        return $this->getRecords("Marcas");
    }

    public function detalles_modelo($modelo_id)
    {
        return $this->getRecord("Modelos", $modelo_id);
    }

    public function lista_aseguradoras()
    {
        $criterio = "Socio:equals:" .  $this->usuario['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);

        foreach ($contratos as $contrato) {
            $aseguradoras[$contrato->getEntityId()] = $contrato->getFieldValue('Aseguradora')->getLookupLabel();
        }

        return array_unique($aseguradoras);
    }

    public function lista_clientes()
    {
        $criterio = "Reporting_To:equals:" . $this->usuario["id"];
        return $this->searchRecordsByCriteria("Contacts", $criterio);
    }

    public function cliente_detalles($id)
    {
        return $this->getRecord("Contacts", $id);
    }

    public function foto_aseguradora($id)
    {
        if (!is_dir("public/img")) {
            mkdir("public/img", 0755, true);
        }

        return $this->downloadPhoto("Vendors", $id, "public/img/");
    }

    public function contrato_detalles($id)
    {
        return $this->getRecord("Contratos", $id);
    }
}
