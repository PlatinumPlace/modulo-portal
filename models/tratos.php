<?php

class tratos extends api
{
    public function selecionarPlan($contrato)
    {
        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $this->searchRecordsByCriteria("Products", $criterio);
        foreach ($planes as $plan) {
            return $plan;
        }
    }

    public function descargarAdjunto()
    {
        $documento = $this->downloadAttachment("Contratos", $_GET["contratoid"], $_GET["adjuntoid"]);
        $fileName = basename($documento);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: ');
        header('Content-Length: ' . filesize($documento));
        readfile($documento);
        unlink($documento);
        exit();
    }
}
