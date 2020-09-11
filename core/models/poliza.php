<?php

class poliza {

    public function __construct() {
        $this->api = new api;
    }

    public function lista($num_pag, $cantidad) {
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        return $this->api->searchRecordsByCriteria("Deals", $criteria, $num_pag, $cantidad);
    }

    public function detalles() {
        return $this->api->getRecord("Deals", $_GET["id"]);
    }

    public function imagenAseguradora($aseguradora_id) {
        return $this->api->downloadPhoto("Vendors", $aseguradora_id);
    }

    public function detallesCliente($id) {
        return $this->api->getRecord("Contacts", $id);
    }

    public function detallesBien($id) {
        return $this->api->getRecord("Bienes", $id);
    }

    public function detallesAseguradora($id) {
        return $this->api->getRecord("Vendors", $id);
    }

    public function coberturas($contrato_id) {
        $contrato = $this->api->getRecord("Contratos", $contrato_id);
        return $this->api->getRecord("Coberturas", $contrato->getFieldValue('Coberturas')->getEntityId());
    }

    public function documentoAdjuntos($modulo, $id) {
        return $this->api->getAttachments($modulo, $id);
    }

    public function descargarAdjuntoContrato($id) {
        $documento = $this->api->downloadAttachment("Contratos", $id, $_GET["attachment_id"]);
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

    public function adjuntarTrato($ruta) {
        return $this->api->uploadAttachment("Deals", $_GET["id"], $ruta);
    }

}
