<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

class dealsAPI
{
    public $Contact_Name;
    public $Direcci_n_del_asegurado;
    public $A_o_de_Fabricacion;
    public $Chasis;
    public $Color;
    public $Condiciones;
    public $Email_del_asegurado;
    public $Marca;
    public $Modelo;
    public $Nombre_del_asegurado;
    public $Placa;
    public $Plan;
    public $Plan_de_pago;
    public $Type;
    public $RNC_Cedula_del_asegurado;
    public $Telefono_del_asegurado;
    public $Tipo_de_poliza;
    public $Tipo_de_vehiculo;
    public $Valor_Asegurado;
    public $Es_nuevo;
    public $Stage;
    public $Aseguradora;

    public function getRecords($myid, $page = 1, $per_page = 100)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $criteria = "Contact_Name:equals:" . $myid;
        $cont = 0;
        try {
            $param_map = array("page" => $page, "per_page" => $per_page);
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                $result[$cont]['id'] = $record->getEntityId();
                $result[$cont]['Stage'] = $record->getFieldValue("Stage");
                $result[$cont]['Amount'] = $record->getFieldValue("Amount");
                $result[$cont]['Closing_Date'] = $record->getFieldValue("Closing_Date");
                $cont++;
            }
            return $result;
        } catch (ZCRMException $ex) {
            //echo $ex->getMessage(); // To get ZCRMException error message
            //echo $ex->getExceptionCode(); // To get ZCRMException error code
            //echo $ex->getFile(); // To get the file name that throws the Exception
        }
    }

    public function createRecord()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $records = array();
        $record = ZCRMRecord::getInstance("Deals", null);
        $record->setFieldValue("Deal_Name", "Trato realizado desde el portal");
        $record->setFieldValue("Lead_Source", "Portal GNB");
        $record->setFieldValue("Contact_Name", $this->Contact_Name);
        $record->setFieldValue("Stage", $this->Stage);
        $record->setFieldValue("Direcci_n_del_asegurado", $this->Direcci_n_del_asegurado);
        $record->setFieldValue("A_o_de_Fabricacion", $this->A_o_de_Fabricacion);
        $record->setFieldValue("Chasis", $this->Chasis);
        $record->setFieldValue("Color", $this->Color);
        $record->setFieldValue("Email_del_asegurado", $this->Email_del_asegurado);
        $record->setFieldValue("Marca", $this->Marca);
        $record->setFieldValue("Modelo", $this->Modelo);
        $record->setFieldValue("Nombre_del_asegurado", $this->Nombre_del_asegurado);
        $record->setFieldValue("Placa", $this->Placa);
        $record->setFieldValue("Plan", $this->Plan);
        $record->setFieldValue("Type", $this->Type);
        $record->setFieldValue("RNC_Cedula_del_asegurado", $this->RNC_Cedula_del_asegurado);
        $record->setFieldValue("Telefono_del_asegurado", $this->Telefono_del_asegurado);
        $record->setFieldValue("Valor_Asegurado", $this->Valor_Asegurado);
        $record->setFieldValue("Tipo_de_vehiculo", $this->Tipo_de_vehiculo);
        $record->setFieldValue("Tipo_de_poliza", $this->Tipo_de_poliza);
        $record->setFieldValue("Es_nuevo", $this->Es_nuevo);

        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            $detail = json_decode(json_encode($responseIns->getDetails()), true);
            $result = $detail['id'];
        }

        return $result;
    }

    public function getRecord($id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Deals");
        $result = null;
        try {
            $response = $moduleIns->getRecord($id);
            $record = $response->getData();
            $result['Plan'] = $record->getFieldValue("Plan");
            $result['Nombre_del_asegurado'] = $record->getFieldValue("Nombre_del_asegurado");
            $result['Direcci_n_del_asegurado'] = $record->getFieldValue("Direcci_n_del_asegurado");
            $result['A_o_de_Fabricacion'] = $record->getFieldValue("A_o_de_Fabricacion");
            $result['Chasis'] = $record->getFieldValue("Chasis");
            $result['Color'] = $record->getFieldValue("Color");
            $result['Email_del_asegurado'] = $record->getFieldValue("Email_del_asegurado");
            $result['Marca'] = $record->getFieldValue("Marca");
            $result['Modelo'] = $record->getFieldValue("Modelo");
            $result['Placa'] = $record->getFieldValue("Placa");
            $result['Type'] = $record->getFieldValue("Type");
            $result['RNC_Cedula_del_asegurado'] = $record->getFieldValue("RNC_Cedula_del_asegurado");
            $result['Telefono_del_asegurado'] = $record->getFieldValue("Telefono_del_asegurado");
            $result['Tipo_de_poliza'] = $record->getFieldValue("Tipo_de_poliza");
            $result['Tipo_de_vehiculo'] = $record->getFieldValue("Tipo_de_vehiculo");
            $result['Valor_Asegurado'] = $record->getFieldValue("Valor_Asegurado");
            $result['Es_nuevo'] = $record->getFieldValue("Es_nuevo");
            $result['Stage'] = $record->getFieldValue("Stage");
        } catch (ZCRMException $ex) {
            //echo $ex->getMessage(); // To get ZCRMException error message
            //echo $ex->getExceptionCode(); // To get ZCRMException error code
            //echo $ex->getFile(); // To get the file name that throws the Exception
        }
        return $result;
    }

    public function updateRecord($id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance("Deals", $id);
        $record->setFieldValue("Aseguradora", $this->Aseguradora);
        $record->setFieldValue("Stage", $this->Stage);
        $responseIns = $record->update();
    }
}
