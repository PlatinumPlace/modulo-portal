<?php
class Home extends Api
{
    function __construct()
    {
        // inicializamos la clase api
        parent::__construct();
    }
    public function pagina_principal()
    {
        // objeto principal con las propiedades que se mostraran en la vista
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario'];
        $tratos = $this->searchRecordsByCriteria("Deals", $criterio);
        // variable para usar en la vista
        $total = 0;
        $emisiones = 0;
        $vencimientos = 0;
        $filtro_emisiones = "";
        $filtro_vencimientos = "";
        if (!empty($tratos)) {
            foreach ($tratos as $trato) {
                // para ver la cantidad de todos los registros del contacto
                $total += 1;
                // filtra segun si tiene poliza (es decir,ya no esta "cotizando") y 
                // si la fecha de emision es igual a la fecha de del mes actual
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                    // para ver a cantidad de  todos los registros filtratos del contacto
                    $emisiones += 1;
                    // toma el estado para luego usarlo como filtro en la vista
                    $filtro_emisiones = $trato->getFieldValue("Stage");
                }
                // filtra segun si tiene poliza (es decir,ya no esta "cotizando") y 
                // si la fecha de vencimiento es igual a la fecha de del mes actual
                if ($trato->getFieldValue("P_liza") != null and date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                    // para ver a cantidad de  todos los registros filtratos del contacto
                    $vencimientos += 1;
                    // toma el estado para luego usarlo como filtro en la vista
                    $filtro_vencimientos = $trato->getFieldValue("Stage");
                }
            }
        }
        // llama a la vista
        require("pages/header.php");
        require("pages/home/pagina_principal.php");
        require("pages/footer.php");
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
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (No_Cotizaci_n:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'id':
                    // el numero cedula/rnc del registro
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (RNC_Cedula:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'nombre':
                    // el numero cedula/rnc del registro
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (Nombre:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'apellido':
                    // el numero cedula/rnc del registro
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (Apellido:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'chasis':
                    // el numero cedula/rnc del registro
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (Chasis:equals:" . $_POST['busqueda'] . "))";
                    break;
            }
        }
        // almacena los resultados en una variable de la clase view
        $resultado = $this->searchRecordsByCriteria("Deals", $criterio);
        // llamas las vistas
        require("pages/header.php");
        require("pages/home/buscar.php");
        require("pages/footer.php");
    }
    public function lista($filtro)
    {
        // asignamos los registros asociados al contacto
        $criterio = "Contact_Name:equals:" .  $_SESSION['usuario'];
        $resultado = $this->searchRecordsByCriteria("Deals", $criterio);
        // llamamos a la vista
        require("pages/header.php");
        require("pages/home/lista.php");
        require("pages/footer.php");
    }
    public function cargando($datos)
    {
        $informacion = explode("-", $datos);
        // variable con el id del registro para usarla en la vista
        $id = $informacion[0];
        // tipo del registro para redirigir al controlador correspondiente
        $origen = $informacion[1];
        // llama a la vista
        require("pages/header.php");
        require("pages/home/cargando.php");
        require("pages/footer.php");
    }
}
