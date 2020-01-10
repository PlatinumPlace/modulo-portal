<?php

class Quotes extends API
{
    public $Quote_Stage;
    public $Deducible;
    public $Quote_Number;
    public $Poliza;

    public function buscar_por_oferta($oferta_id)
    {
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $resultado = $this->searchRecordsByCriteria("Quotes", $this, $criterio, $Product_details = true);
        return $resultado;
    }
}
