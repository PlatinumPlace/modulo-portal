<?php

class contrato extends api
{

    function __construct()
    {
        parent::__construct();
    }

    public function detalles($id)
    {
       return $this->getRecord("Contratos", $id);
    }

    public function lista($id)
    {
        $criterio = "Deal_Name:equals:" . $id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);

        $resultado = array();

        foreach ($cotizaciones as $cotizacion) {

            $resultado[] = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
        }

        return $resultado;
    }

    public function lista_aseguradoras()
    {
        $criterio = "Socio:equals:" . $_SESSION['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);

        foreach ($contratos as $contrato) {
            $aseguradoras[$contrato->getEntityId()] = $contrato->getFieldValue('Aseguradora')->getLookupLabel();
        }

        return array_unique($aseguradoras);
    }

}
