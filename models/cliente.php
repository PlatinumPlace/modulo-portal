<?php

class cliente extends zoho_api
{

    function __construct()
    {
        parent::__construct();
    }

    public function lista()
    {
        $criterio = "Reporting_To:equals:" . $_SESSION["usuario_id"];
        return $this->searchRecordsByCriteria("Contacts", $criterio);
    }

    public function detalles($id)
    {
        return $this->getRecord("Contacts", $id);
    }

}
