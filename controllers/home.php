<?php
class Home extends Controller
{
    function __construct()
    {
        parent::__construct();
        $criterio = "Contact_Name:equals:" . "3222373000002913137";
        $tratos = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $this->view->total = 0;
        $this->view->emisiones = 0;
        $this->view->vencimientos = 0;
        $this->view->filtro_emisiones = "";
        $this->view->filtro_vencimientos = "";
        if (!empty($tratos)) {
            foreach ($tratos as $trato) {
                $this->view->total += 1;
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                    $this->view->emisiones += 1;
                    $this->view->filtro_emisiones = $trato->getFieldValue("Stage");
                }
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                    $this->view->vencimientos += 1;
                    $this->view->filtro_vencimientos = $trato->getFieldValue("Stage");
                }
            }
        }
        $this->view->render("header");
        $this->view->render("home/index");
        $this->view->render("footer");
    }
}
