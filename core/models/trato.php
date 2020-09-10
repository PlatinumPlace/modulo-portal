<?php

class trato
{
    public $api;

    public function __construct()
    {
        $this->api = new api;
    }

    public function lista($num_pag, $cantidad)
    {
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        return $this->api->searchRecordsByCriteria("Deals", $criteria, $num_pag, $cantidad);
    }

    public function buscar($num_pag, $cantidad, $parametro, $busqueda)
    {
        $criteria = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and ($parametro:equals:$busqueda))";
        return $this->api->searchRecordsByCriteria("Deals", $criteria, $num_pag, $cantidad);
    }

    public function resumenMensual()
    {
        $num_pag = 1;
        $result["emisiones"] = 0;
        $result["vencimientos"] = 0;

        do {
            $tratos = $this->lista($num_pag, 200);
            if (!empty($tratos)) {
                $num_pag++;

                foreach ($tratos as $trato) {
                    if (date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                        $result["emisiones"] += 1;
                        $result["aseguradoras"][] = $trato->getFieldValue('Aseguradora')->getLookupLabel();
                    }

                    if (date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                        $result["vencimientos"] += 1;
                    }
                }
            } else {
                $num_pag = 0;
            }
        } while ($num_pag > 1);

        return $result;
    }

    public function detalles()
    {
        return $this->api->getRecord("Deals", $_GET["id"]);
    }

    public function imagenAseguradora($aseguradora_id)
    {
        return $this->api->downloadPhoto("Vendors", $aseguradora_id);
    }

    public function detallesCliente($id)
    {
        return $this->api->getRecord("Contacts", $id);
    }

    public function detallesBien($id)
    {
        return $this->api->getRecord("Bienes", $id);
    }

    public function detallesAseguradora($id)
    {
        return $this->api->getRecord("Vendors", $id);
    }

    public function coberturas($contrato_id)
    {
        $contrato = $this->api->getRecord("Contratos", $contrato_id);
        return $this->api->getRecord("Coberturas", $contrato->getFieldValue('Coberturas')->getEntityId());
    }
}
