<?php

use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

class cotizaciones extends api
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resumenes_mensuales()
    {
        $resultado["total"] = 0;
        $resultado["pendientes"] = 0;
        $resultado["emisiones"] = 0;
        $resultado["vencimientos"] = 0;
        $estado_emitido = array(
            "Emitido",
            "En trámite"
        );
        $num_pagina = 1;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        do {
            $param_map = array(
                "page" => $num_pagina,
                "per_page" => 200
            );
            try {
                $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
                $records = $response->getData();
                $num_pagina++;
                foreach ($records as $record) {
                    $resultado["total"] += 1;
                    if ($record->getFieldValue("Stage") == "Cotizando") {
                        $resultado["pendientes"] += 1;
                    }
                    if (in_array($record->getFieldValue("Stage"), $estado_emitido)) {
                        if (date("Y-m", strtotime($record->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                            $resultado["emisiones"] += 1;
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

                $num_pagina = 0;
            }
        } while ($num_pagina > 1);
        return $resultado;
    }

    public function cotizaciones_mensuales()
    {
        $resultado["aseguradoras"] = array();
        $num_pagina = 1;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        do {
            $param_map = array(
                "page" => $num_pagina,
                "per_page" => 200
            );
            try {
                $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
                $records = $response->getData();
                $num_pagina++;
                foreach ($records as $record) {
                    if ($record->getFieldValue("Quote_Stage") == "Confirmada") {
                        $resultado["aseguradoras"][] = $record->getFieldValue('Aseguradora')->getLookupLabel();
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

                $num_pagina = 0;
            }
        } while ($num_pagina > 1);

        $resultado["aseguradoras"] =  array_count_values($resultado["aseguradoras"]);

        return $resultado;
    }

    public function lista_resumenes($num_pagina)
    {
        $resultado = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => 10
        );
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                $resultado[] = $record;
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
        }
        return $resultado;
    }

    public function buscar_resumenes($num_pagina, $parametro, $busqueda)
    {
        $resultado = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $criteria = "((Contact_Name:equals:" . $_SESSION["usuario"]['id'] . ") and ($parametro:equals:$busqueda))";
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => 10
        );
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                $resultado[] = $record;
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
        }
        return $resultado;
    }

    public function lista_contratos()
    {
        $resultado = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contratos");
        $criteria = "Socio:equals:" .  $_SESSION["usuario"]['empresa_id'];
        $param_map = array(
            "page" => 1,
            "per_page" => 10
        );
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                $resultado[] = $record;
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
        }
        return $resultado;
    }

    public function lista_cotizaciones($num_pagina)
    {
        $resultado = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => 10
        );
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                $resultado[] = $record;
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
        }
        return $resultado;
    }

    public function detalles_resumen($id)
    {
        $record = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        try {
            $response = $moduleIns->getRecord($id);
            return $response->getData();
        } catch (ZCRMException $ex) {
            /*
            echo $ex->getMessage();
            echo "<br>";
            echo $ex->getExceptionCode();
            echo "<br>";
            echo $ex->getFile();
             */
        }
        return $record;
    }

    public function lista_marcas($num_pagina)
    {
        $resultado = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Marcas");
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => 200
        );
        try {
            $response = $moduleIns->getRecords($param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                $resultado[] = $record;
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
        }
        return $resultado;
    }

    public function crear_resumen($nuevo_resumen)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $records = array();
        $record = ZCRMRecord::getInstance("Deals", null);
        foreach ($nuevo_resumen as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            /*
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
            echo "Status:" . $responseIns->getStatus();
            echo "Message:" . $responseIns->getMessage();
            echo "Code:" . $responseIns->getCode();
            echo "Details:" . json_encode($responseIns->getDetails());
*/
            $details = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $details["id"];
    }

    public function detalles_modelo($modelo_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Modelos");
        try {
            $response = $moduleIns->getRecord($modelo_id);
            return $response->getData();
        } catch (ZCRMException $ex) {
            /*
              echo $ex->getMessage();
             echo "<br>";
              echo $ex->getExceptionCode();
             echo "<br>";
              echo $ex->getFile();
              echo "<br>";
             */
        }
    }

    public function obtener_plan_ley_full($aseguradora_id)
    {
        $resultado = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Products");
        $criteria = "Vendor_Name:equals:$aseguradora_id";
        $param_map = array("page" => 1, "per_page" => 200);
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                $pos = strpos($_POST["tipo_plan"], "Ley");
                if ($pos !== false) {
                    $resultado["prima"] = $record->getFieldValue('Unit_Price');
                    $resultado["plan_id"] = $record->getEntityId();
                } else {
                    $resultado["plan_id"] = $record->getEntityId();
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
        }
        return $resultado;
    }

    public function obtener_tasa($contrato_id, $tipo_vehiculo)
    {
        $resultado = 0;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Tasas");
        $criteria = "Contrato:equals:$contrato_id";
        $param_map = array("page" => 1, "per_page" => 200);
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                if (
                    in_array($tipo_vehiculo, $record->getFieldValue('Grupo_de_veh_culo'))
                    and
                    $record->getFieldValue('A_o') == $_POST["fabricacion"]
                ) {
                    $resultado = $record->getFieldValue('Valor');
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
        }
        return $resultado;
    }

    public function obtener_recargo($contrato_id, $tipo_vehiculo, $tasa)
    {
        $resultado = 0;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Recargos");
        $criteria = "Contrato:equals:$contrato_id";
        $param_map = array(
            "page" => 1,
            "per_page" => 200
        );
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                if (in_array($tipo_vehiculo, $record->getFieldValue('Grupo_de_veh_culo')) and $record->getFieldValue('Marca')->getEntityId() == $_POST["marca"]) {
                    if (!empty($record->getFieldValue('Hasta')) and !empty($record->getFieldValue('Desde'))) {
                        if ($_POST["fabricacion"] < $record->getFieldValue('Desde') and $_POST["fabricacion"] > $record->getFieldValue('Hasta')) {
                            $resultado = $tasa * $record->getFieldValue('Porcentaje') / 100;
                        }
                    } else {
                        if (!empty($record->getFieldValue('Hasta')) and $_POST["fabricacion"] > $record->getFieldValue('Hasta')) {
                            $resultado = $tasa * $record->getFieldValue('Porcentaje') / 100;
                        } elseif (!empty($record->getFieldValue('Desde')) and $_POST["fabricacion"] < $record->getFieldValue('Desde')) {
                            $resultado = $tasa * $record->getFieldValue('Porcentaje') / 100;
                        }
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
        }
        return $resultado;
    }

    public function crear_cotizacion($nueva_cotizacion, $plan_id, $prima)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
        $records = array();
        $record = ZCRMRecord::getInstance("Quotes", null);
        foreach ($nueva_cotizacion as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }

        $lineItem = ZCRMInventoryLineItem::getInstance(null);

        $lineItem->setProduct(ZCRMRecord::getInstance("Products", $plan_id));
        $lineItem->setQuantity(1);
        $lineItem->setListPrice($prima);

        $taxInstance1 = ZCRMTax::getInstance("ITBIS 16");
        $taxInstance1->setPercentage(16);
        $taxInstance1->setValue(50);
        $lineItem->addLineTax($taxInstance1);

        $record->addLineItem($lineItem);

        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            /*
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
            echo "Status:" . $responseIns->getStatus();
            echo "Message:" . $responseIns->getMessage();
            echo "Code:" . $responseIns->getCode();
            echo "Details:" . json_encode($responseIns->getDetails());
*/
            $details = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $details["id"];
    }

    public function verificar_vehiculo_retringido($contrato_id)
    {
        $resultado = 1;
        $page = 1;
        do {
            $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Restringidos");
            $criteria = "Contrato:equals:$contrato_id";
            $param_map = array(
                "page" => $page,
                "per_page" => 200
            );
            try {
                $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
                $records = $response->getData();
                $page++;
                foreach ($records as $record) {
                    if (!empty($record->getFieldValue('Modelo'))) {
                        if ($record->getFieldValue('Modelo')->getEntityId() ==  $_POST["modelo"]) {
                            $resultado = 0;
                        }
                    } elseif ($record->getFieldValue('Marca')->getEntityId() ==  $_POST["marca"]) {
                        $resultado = 0;
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
                $page = 0;
            }
        } while ($page > 1);
        return $resultado;
    }

    public function lista_cotizaciones_asosiadas($resumen_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
        $param_map = array(
            "page" => 1,
            "per_page" => 200
        );
        $criteria = "Deal_Name:equals:$resumen_id";
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            return $response->getData();
        } catch (ZCRMException $ex) {
            /*
              echo $ex->getMessage();
              echo "<br>";
              echo $ex->getExceptionCode();
              echo "<br>";
              echo $ex->getFile();
             */
        }
    }

    public function lista_adjuntos($resumen_id, $num_pagina)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Deals", $resumen_id);
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => 3
        );
        try {
            $responseIns = $record->getAttachments($param_map);
            return $responseIns->getData();
        } catch (ZCRMException $ex) {
            /*
              echo $ex->getMessage();
              echo "<br>";
              echo $ex->getExceptionCode();
              echo "<br>";
              echo $ex->getFile();
             */
        }
    }

    public function lista_clientes()
    {
        $resultado = array();
        $page = 1;
        do {
            $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Clientes");
            $criteria = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
            $param_map = array(
                "page" => $page,
                "per_page" => 200
            );
            try {
                $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
                $records = $response->getData();
                $page++;
                foreach ($records as $record) {
                    $resultado[] = $record;
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
                $page = 0;
            }
        } while ($page > 1);
        return $resultado;
    }


    public function detalles_cliente($cliente_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Clientes");
        try {
            $response = $moduleIns->getRecord($cliente_id);
            return $response->getData();
        } catch (ZCRMException $ex) {
            /*
              echo $ex->getMessage();
             echo "<br>";
              echo $ex->getExceptionCode();
             echo "<br>";
              echo $ex->getFile();
              echo "<br>";
             */
        }
    }

    public function guardar_cambios_resumen($cambios_resumen, $resumen_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Deals", $resumen_id);
        foreach ($cambios_resumen as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        $responseIns = $record->update();
        /*
          echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
          echo "<br>";
          echo "Status:" . $responseIns->getStatus();
          echo "<br>";
          echo "Message:" . $responseIns->getMessage();
          echo "<br>";
          echo "Code:" . $responseIns->getCode();
          echo "<br>";
          echo "Details:" . json_encode($responseIns->getDetails());
         */
    }

    public function imagen_aseguradora($aseguradora_id)
    {
        if (!is_dir("public/img")) {
            mkdir("public/img", 0755, true);
        }
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Vendors", $aseguradora_id);
        $fileResponseIns = $record->downloadPhoto();
        /*
          echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
          echo "File Name:" . $fileResponseIns->getFileName();
         */
        $fp = fopen("public/img/" . $fileResponseIns->getFileName(), "w");
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
        return "public/img/" . $fileResponseIns->getFileName();
    }

    public function detalles_contrato($contrato_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contratos");
        try {
            $response = $moduleIns->getRecord($contrato_id);
            return $response->getData();
        } catch (ZCRMException $ex) {
            /*
              echo $ex->getMessage();
             echo "<br>";
              echo $ex->getExceptionCode();
             echo "<br>";
              echo $ex->getFile();
              echo "<br>";
             */
        }
    }

    public function detalles_aseguradora($aseguradora_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Vendors");
        try {
            $response = $moduleIns->getRecord($aseguradora_id);
            return $response->getData();
        } catch (ZCRMException $ex) {
            /*
              echo $ex->getMessage();
             echo "<br>";
              echo $ex->getExceptionCode();
             echo "<br>";
              echo $ex->getFile();
              echo "<br>";
             */
        }
    }

    public function adjuntar_resumen($resumen_id, $filePath)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Deals", $resumen_id);
        $responseIns = $record->uploadAttachment($filePath);
        /*
          echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
          echo "<br>";
          echo "Status:" . $responseIns->getStatus();
          echo "<br>";
          echo "Message:" . $responseIns->getMessage();
          echo "<br>";
          echo "Code:" . $responseIns->getCode();
          echo "<br>";
          echo "Details:" . $responseIns->getDetails()['id'];
         */
    }

    public function eliminar_cotizacion($cotizacion_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
        $recordids = array(
            $cotizacion_id
        );
        $responseIn = $moduleIns->deleteRecords($recordids);

        foreach ($responseIn->getEntityResponses() as $responseIns) {
            /*
             * echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
             * echo "Status:" . $responseIns->getStatus();
             * echo "Message:" . $responseIns->getMessage();
             * echo "Code:" . $responseIns->getCode();
             * echo "Details:" . json_encode($responseIns->getDetails());
             */
        }
    }

    public function crear_cliente($cliente_nuevo)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Clientes");
        $records = array();
        $record = ZCRMRecord::getInstance("Clientes", null);
        foreach ($cliente_nuevo as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            /*
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
            echo "Status:" . $responseIns->getStatus();
            echo "Message:" . $responseIns->getMessage();
            echo "Code:" . $responseIns->getCode();
            echo "Details:" . json_encode($responseIns->getDetails());
*/
            $details = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $details["id"];
    }

    public function crear_poliza($poliza_nueva)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("P_lizas");
        $records = array();
        $record = ZCRMRecord::getInstance("P_lizas", null);
        foreach ($poliza_nueva as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            /*
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
            echo "Status:" . $responseIns->getStatus();
            echo "Message:" . $responseIns->getMessage();
            echo "Code:" . $responseIns->getCode();
            echo "Details:" . json_encode($responseIns->getDetails());
*/
            $details = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $details["id"];
    }

    public function crear_bien($nuevo_bien)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Bienes");
        $records = array();
        $record = ZCRMRecord::getInstance("Bienes", null);
        foreach ($nuevo_bien as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            /*
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
            echo "Status:" . $responseIns->getStatus();
            echo "Message:" . $responseIns->getMessage();
            echo "Code:" . $responseIns->getCode();
            echo "Details:" . json_encode($responseIns->getDetails());
*/
            $details = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $details["id"];
    }

    public function guardar_cambios_cotizacion($cambios_cotizacion, $cotizacion_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Quotes", $cotizacion_id);
        foreach ($cambios_cotizacion as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        $responseIns = $record->update();
        /*
          echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
          echo "<br>";
          echo "Status:" . $responseIns->getStatus();
          echo "<br>";
          echo "Message:" . $responseIns->getMessage();
          echo "<br>";
          echo "Code:" . $responseIns->getCode();
          echo "<br>";
          echo "Details:" . json_encode($responseIns->getDetails());
         */
    }
}
