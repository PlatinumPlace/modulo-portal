<?php
class Home extends Controller
{
    function __construct()
    {
        // inicializamos la clase controller
        parent::__construct();
        // creamos un criterio para filtrar por los registros del contacto
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario'];
        $tratos = $this->api->searchRecordsByCriteria("Deals", $criterio);
        // variable para usar en la vista
        $this->view->total = 0;
        $this->view->emisiones = 0;
        $this->view->vencimientos = 0;
        $this->view->filtro_emisiones = "";
        $this->view->filtro_vencimientos = "";
        if (!empty($tratos)) {
            foreach ($tratos as $trato) {
                // para ver la cantidad de todos los registros del contacto
                $this->view->total += 1;
                // filtrar segun si tiene poliza (es decir,ya no esta "cotizando") y 
                // si la fecha de emision es igual a la fecha de del mes actual
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                    // para ver a cantidad de  todos los registros filtratos del contacto
                    $this->view->emisiones += 1;
                    // se toma el estado para luego usarlo como filtro en la vista
                    $this->view->filtro_emisiones = $trato->getFieldValue("Stage");
                }
                // filtrar segun si tiene poliza (es decir,ya no esta "cotizando") y 
                // si la fecha de vencimiento es igual a la fecha de del mes actual
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                    // para ver a cantidad de  todos los registros filtratos del contacto
                    $this->view->vencimientos += 1;
                    // se toma el estado para luego usarlo como filtro en la vista
                    $this->view->filtro_vencimientos = $trato->getFieldValue("Stage");
                }
            }
        }
        // llamamos a la vista
        $this->view->render("header");
        $this->view->render("home/index");
        $this->view->render("footer");
    }
}
