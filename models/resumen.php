<?php

use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class resumen extends zoho_api
{
    function __construct()
    {
        parent::__construct();
    }

    public function resumen()
    {
        $resultado["total"] = 0;
        $resultado["pendientes"] = 0;
        $resultado["emisiones"] = 0;
        $resultado["vencimientos"] = 0;
        $emitida = array(
            "Emitido",
            "En trámite"
        );
        $pagina = 1;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        do {
            $param_map = array("page" => $pagina, "per_page" => 200);
            try {
                $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
                $records = $response->getData();
                $pagina++;
                foreach ($records as $record) {
                    $resultado["total"] += 1;
                    if ($record->getFieldValue("Stage") == "Cotizando") {
                        $resultado["pendientes"] += 1;
                    }
                    if (in_array($record->getFieldValue("Stage"), $emitida)) {
                        if (date("Y-m", strtotime($record->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                            $resultado["emisiones"] += 1;
                            $aseguradoras[] = $record->getFieldValue('Aseguradora')->getLookupLabel();
                        }
                        if (date("Y-m", strtotime($record->getFieldValue("Closing_Date"))) == date('Y-m')) {
                            $resultado["vencimientos"] += 1;
                        }
                    }
                }
            } catch (ZCRMException $ex) {
                /*
            echo $ex->getMessage();
            echo "<br>";
            echo $ex->getExceptionCode();
            echo "<br>";
            echo $ex->getFile();
            echo "<br>";
            */

                $pagina = 0;
            }
        } while ($pagina > 1);

        if (!empty($aseguradoras)) {
            $resultado["aseguradoras"] = array_count_values($aseguradoras);
        }

        return $resultado;
    }

    public function lista_cotizaciones()
    {
        # code...
    }
}
