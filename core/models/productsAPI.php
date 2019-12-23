<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class productsAPI
{

    public function getRecord($id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Products"); // To get module instance
        $response = $moduleIns->getRecord($id); // To get module records
        $record = $response->getData(); // To get response data
        try {

            $result['Vendor_Name']= $record->getFieldValue("Vendor_Name")->getLookupLabel();
            $result['Vendor_Name_id']= $record->getFieldValue("Vendor_Name")->getEntityId();
            $result['Asistencia_vial']= $record->getFieldValue("Asistencia_vial");
            $result['Colisi_n_y_vuelco']= $record->getFieldValue("Colisi_n_y_vuelco");
            $result['Da_os_Propiedad_ajena']= $record->getFieldValue("Da_os_Propiedad_ajena");
            $result['Fianza_judicial']= $record->getFieldValue("Fianza_judicial");
            $result['Incendio_y_robo']= $record->getFieldValue("Incendio_y_robo");
            $result['Lesiones_Muerte_1_pasajero']= $record->getFieldValue("Lesiones_Muerte_1_pasajero");
            $result['Lesiones_Muerte_1_Pers']= $record->getFieldValue("Lesiones_Muerte_1_Pers");
            $result['Lesiones_Muerte_m_s_de_1_pasajero']= $record->getFieldValue("Lesiones_Muerte_m_s_de_1_pasajero");
            $result['Lesiones_Muerte_m_s_de_1_Pers']= $record->getFieldValue("Lesiones_Muerte_m_s_de_1_Pers");
            $result['Renta_Veh_culo']= $record->getFieldValue("Renta_Veh_culo");
            $result['Reporte_de_accidente']= $record->getFieldValue("Reporte_de_accidente");
            $result['Riesgos_comprensivos']= $record->getFieldValue("Riesgos_comprensivos");
            $result['Riesgos_comprensivos_Deducible']= $record->getFieldValue("Riesgos_comprensivos_Deducible");
            $result['Riesgos_conductor']= $record->getFieldValue("Riesgos_conductor");
            $result['Rotura_de_Cristales_Deducible']= $record->getFieldValue("Rotura_de_Cristales_Deducible");
            
            return $result;
            
        } catch (ZCRMException $ex) {
            echo $ex->getMessage(); // To get ZCRMException error message
            echo $ex->getExceptionCode(); // To get ZCRMException error code
            echo $ex->getFile(); // To get the file name that throws the Exception
        }
    }
}
