<?php

class cotizacion
{
    public $api;

    function __construct()
    {
        $this->api = new api;
    }

    public function resumen($contacto_id)
    {
        $criterio = "Contact_Name:equals:" . $contacto_id;
        $tratos = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $resultado = array();
        $resultado['total'] = 0;
        $resultado['emisiones'] = 0;
        $resultado['vencimientos'] = 0;
        foreach ($tratos as $trato) {
            $resultado['total'] += 1;
            if (
                $trato->getFieldValue("Aseguradora") != null
                and
                date(
                    "Y-m",
                    strtotime($trato->getFieldValue("Closing_Date") . "- 1 month")
                ) == date('Y-m')
            ) {
                $resultado['emisiones'] += 1;
                $resultado['filtro_emisiones'] = $trato->getFieldValue("Stage");
            }
            if (
                $trato->getFieldValue("Aseguradora") != null
                and
                date("Y-m", strtotime($trato->getFieldValue("Closing_Date") . "- 1 years")) == date('Y-m')
            ) {
                $resultado['vencimientos'] += 1;
                $resultado['filtro_vencimientos'] = $trato->getFieldValue("Stage");
            }
        }
        return $resultado;
    }
}
