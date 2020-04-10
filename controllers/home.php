<?php
class Home extends Controller
{
    function __construct()
    {
        // inicializamos las clases de api y views
        parent::__construct();
    }
    public function pagina_principal()
    {
        // criterio para filtrar los registros por el id del contacto en sesion
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
                // filtra segun si tiene poliza (es decir,ya no esta "cotizando") y 
                // si la fecha de emision es igual a la fecha de del mes actual
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                    // para ver a cantidad de  todos los registros filtratos del contacto
                    $this->view->emisiones += 1;
                    // toma el estado para luego usarlo como filtro en la vista
                    $this->view->filtro_emisiones = $trato->getFieldValue("Stage");
                }
                // filtra segun si tiene poliza (es decir,ya no esta "cotizando") y 
                // si la fecha de vencimiento es igual a la fecha de del mes actual
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                    // para ver a cantidad de  todos los registros filtratos del contacto
                    $this->view->vencimientos += 1;
                    // toma el estado para luego usarlo como filtro en la vista
                    $this->view->filtro_vencimientos = $trato->getFieldValue("Stage");
                }
            }
        }
        // llama a la vista
        $this->view->render("header");
        $this->view->render("home/pagina_principal");
        $this->view->render("footer");
    }
    public function buscar()
    {
        // es el criterio base,filtra todos los registros usando el id de contacto que este en sesion
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario'];
        if (isset($_POST['submit'])) {
            // en caso de exista otro parametro de busqueda:
            // se filtra segun el id de contacto en sesion y
            switch ($_POST['parametro']) {
                case 'numero':
                    // la clave de negocio del registro
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (No_de_cotizaci_n:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'id':
                    // el numero cedula/rnc del registro
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (RNC_Cedula_del_asegurado:equals:" . $_POST['busqueda'] . "))";
                    break;
            }
        }
        // almacena los resultados en una variable de la clase view
        $this->view->resultado = $this->api->searchRecordsByCriteria("Deals", $criterio);
        // llamas las vistas
        $this->view->render("header");
        $this->view->render("home/buscar");
        $this->view->render("footer");
    }
    public function lista($filtro)
    {
        // asignamos el filtro a una varible que usaremos en la vista
        $this->view->filtro = $filtro;
        // asignamos los registros asociados al contacto
        $criterio = "Contact_Name:equals:" .  $_SESSION['usuario'];
        $this->view->resultado = $this->api->searchRecordsByCriteria("Deals", $criterio);
        // llamamos a la vista
        $this->view->render("header");
        $this->view->render("home/lista");
        $this->view->render("footer");
    }
    public function cargando($datos)
    {
        $informacion = explode("-",$datos);
        // variable con el id del registro para usarla en la vista
        $this->view->id = $informacion[0];
        // tipo del registro para redirigir al controlador correspondiente
        $this->view->origen = $informacion[1];
        // llama a la vista
        $this->view->render("header");
        $this->view->render("home/cargando");
        $this->view->render("footer");
    }
}
