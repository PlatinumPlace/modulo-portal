<?php

class Quotes extends ZohoAPI
{

    public $Subject;
    public $Deducible;
    public $Contact_Name;
    public $Account_Name;
    public $Deal_Name;
    public $Quote_Number;
    public $Poliza;
    public $Owner;
    public $Terms_and_Conditions;
    public $Valid_Till;

    public function buscar_por_trato($trato_id)
    {
        $resultado = $this->searchRecordsByCriteria("Quotes", $this, "Deal_Name:equals:" . $trato_id);
        return $resultado;
    }
}
