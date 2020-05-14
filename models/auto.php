<?php

class auto extends zoho_api
{

    function __construct()
    {
        parent::__construct();
    }

    public function lista_marcas()
    {
        return $this->getRecords("Marcas");
    }

    public function modelo_detalles($modelo_id)
    {
        return $this->getRecord("Modelos", $modelo_id);
    }
}
