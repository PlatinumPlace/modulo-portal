<?php

class HomeController
{
    public $Deals;
    public $ZohoAPI;

    function __construct()
    {
        $this->Deals = new Deals;
        $this->ZohoAPI = new ZohoAPI;
    }

    public function pagina_principal()
    {
        $tratos = $this->ZohoAPI->getMyRecords("Deals","3222373000000751142");
        //$mydeals = $this->deal->getRecords($_SESSION['user_id']);
        $tratos_totales = 0;
        $tratos_emitidos = 0;
        $tratos_vencen = 0;
        $tratos_pendientes = 0;
        if (!empty($tratos)) {
            foreach ($tratos as $trato) {

                $tratos_totales += 1;

                if ($trato["Stage"] == "En trámite" || $trato["Stage"] == "Emitido" && date("m", strtotime($trato["Closing_Date"] . "- 1 month")) == date('m')) {
                    $tratos_emitidos += 1;
                }
                if ($trato["Stage"] == "En trámite" && date("m", strtotime($trato["Closing_Date"] . "- 1 month")) == date('m')) {
                    $tratos_vencen += 1;
                }
                if ($trato["Stage"] == "Cotizado") {
                    $tratos_pendientes += 1;
                }
            }
        }

        require_once("core/views\home\inicio.php");
    }

    public function alerta()
    {
        $id = $_GET['id'];
        $origen = explode("/",$_GET['origen']);
        if (in_array("cotizaciones",$origen) && in_array("crear",$origen)) {
            $accion = "index.php?controller=".$origen[0]."&action=detalles&id=" . $id;
        }elseif (in_array("cotizaciones",$origen) && in_array("emitir_poliza",$origen)) {
            $accion = "index.php?controller=".$origen[0]."&action=detalles&id=" . $id;
        }
        else {
            $accion = "index.php";
        }
        if ($_GET['estado'] == "exitoso") {
            $titulo = "Acción realizada exitosamente";
            $alerta = "success";
            $descripcion = "";
        } elseif ($_GET['estado'] == "error") {
            $titulo = "Ha ocurrido un problema";
            $alerta = "danger";
            $descripcion = "";
            $accion = "index.php";
        }
        require_once("core/views/home/alerta.php");
    }

}
