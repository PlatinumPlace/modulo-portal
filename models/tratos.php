<?php

class tratos extends api
{
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
