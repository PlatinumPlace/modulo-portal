<?php

class Quotes extends API
{
    public $Subject;
    public $Deducible;
    public $Quote_Number;
    public $Poliza;

    public function buscar_por_trato($oferta_id)
    {
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $resultado = $this->searchRecordsByCriteria("Quotes", $this, $criterio, $Product_details = true);
        return $resultado;
    }
}
