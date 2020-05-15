<?php

class aseguradora extends api
{

    function __construct()
    {
        parent::__construct();
    }

    public function foto($id)
    {
        if (!is_dir("public/img")) {
            mkdir("public/img", 0755, true);
        }

        return $this->downloadPhoto("Vendors", $id, "public/img/");
    }

    public function lista()
    {
        $criterio = "Socio:equals:" . $_SESSION['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);

        foreach ($contratos as $contrato) {
            $aseguradoras[$contrato->getFieldValue('Aseguradora')->getEntityId()] = $contrato->getFieldValue('Aseguradora')->getLookupLabel();
        }

        return array_unique($aseguradoras);
    }
}
