<?php
class Cotizacion extends Controller
{
    function __construct()
    {
        // Inicializar la clase controller de libs para tener acceso a las
        // propiedades de la clase api y la clase view inicializadas en ella.
        parent::__construct();
    }
    public function buscar()
    {
        // si existe post
        if (isset($_POST['submit'])) {
            // segun la respuesta de post se escoge un criterio de busqueda
            switch ($_POST['parametro']) {
                case 'numero':
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (No_de_cotizaci_n:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'id':
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (RNC_Cedula_del_asegurado:equals:" . $_POST['busqueda'] . "))";
                    break;
            }
            // almacenamos la consulta en una propiedad de la clase view que luego llamaremos
            $this->view->resultado = $this->api->searchRecordsByCriteria("Deals", $criterio);
        } else {
            // en caso de no haber una opcion,dejamos una consulata para que muestre todos los registros
            $criterio = "Contact_Name:equals:" . $_SESSION['usuario'];
            $this->view->resultado = $this->api->searchRecordsByCriteria("Deals", $criterio);
        }
        // usamos el metodo render de la clase view para llamar las vistas
        $this->view->render("header");
        $this->view->render("cotizacion/buscar");
        $this->view->render("footer");
    }
    public function detalles($id)
    {
        // creamos una priedad api a las vista para usar funciones de la api en ella
        $this->view->api = $this->api;
        // asignamos la consulta a la variable que usaremos en la vista
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // las propiedades del subformulario se asignan como array
        $this->view->cotizaciones = $this->view->trato->getFieldValue('Aseguradoras_Disponibles');
        function calcular($valor, $porciento)
        {
            return $valor * ($porciento / 100);
        }
        // usamos el metodo render de la clase view para llamar las vistas
        $this->view->render("header");
        $this->view->render("cotizacion/detalles");
        $this->view->render("footer");
    }
    public function completar($id)
    {
        // asignamos la consulta a la variable que usaremos en la vista
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // si existe post
        if (isset($_POST['submit'])) {
            // tomamos los valores y lo asignamos a un array
            // NOTA: las propiedades del array deben tener el mismo nombre que en la api de zoho
            $cambios["Chasis"] = $_POST['chasis'];
            $cambios["Color"] = $_POST['color'];
            $cambios["Placa"] = $_POST['placa'];
            $cambios["Uso"] = $_POST['uso'];
            if (isset($_POST['estado'])) {
                $cambios["Es_nuevo"] = true;
            } else {
                $cambios["Es_nuevo"] = false;
            }
            $cambios["Direcci_n"] = $_POST['direccion'];
            $cambios["Email"] = $_POST['email'];
            $cambios["Nombre"] = $_POST['nombre'];
            $cambios["Apellido"] = $_POST['apellido'];
            $cambios["RNC_Cedula"] = $_POST['cedula'];
            $cambios["Telefono"] = $_POST['telefono'];
            $cambios["Tel_Residencia"] = $_POST['telefono_2'];
            $cambios["Tel_Trabajo"] = $_POST['telefono_1'];
            $cambios["Fecha_de_Nacimiento"] = $_POST['Fecha_de_Nacimiento'];
            // guardamos los cambios en un array y lo guardamos en el registro
            $this->api->updateRecord("Deals", $cambios, $id);
            echo '<script>alert("Cotización completada")</script>';
            echo '<script>window.location = "' . constant('url') . 'cotizacion/detalles/' . $id . '"</script>';
        }
        // usamos el metodo render de la clase view para llamar las vistas
        $this->view->render("header");
        $this->view->render("cotizacion/completar");
        $this->view->render("footer");
    }
    public function crear()
    {
        // asignar una variable con las propiedasdes de la api para usarlas en la vista
        $this->view->api = $this->api;
        // si existe post
        if (isset($_POST['submit'])) {
            // crear un array donde almacenar los datos del nuevo registro
            // NOTA: los nombres de las propiedades del array deben ser iguales al de las api en zoho
            $trato["Contact_Name"] =  $_SESSION['usuario'];
            $trato["Lead_Source"] = "Portal GNB";
            $trato["Deal_Name"] = "Cotización";
            $trato["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
            $trato["Chasis"] = $_POST['chasis'];
            $trato["Color"] = $_POST['color'];
            $marca = $this->api->getRecord("Marcas", $_POST['marca']);
            $trato["Marca"] = $marca->getFieldValue('Name');
            $modelo = $this->api->getRecord("Modelos", $_POST['modelo']);
            $trato["Modelo"] = $modelo->getFieldValue('Name');
            $trato["Tipo_de_vehiculo"] = $modelo->getFieldValue('Tipo');
            $trato["Placa"] = $_POST['placa'];
            $trato["Plan"] = $_POST['plan'];
            $trato["Type"] = $_POST['cotizacion'];
            $trato["Uso"] = $_POST['uso'];
            $trato["Tipo_de_poliza"] = $_POST['poliza'];
            $trato["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $trato["Stage"] = "Cotizando";
            if (isset($_POST['estado'])) {
                $trato["Es_nuevo"] = true;
            } else {
                $trato["Es_nuevo"] = false;
            }
            // creamos el nuevo registro,este devuelve el id del nuevo registro dentro del crm
            $id = $this->api->createRecord("Deals", $trato);
            echo '<script>alert("Cotización creada")</script>';
            echo '<script>window.location = "' . constant('url') . 'cotizacion/cargando/' . $id . '"</script>';
        }
        // usamos el metodo dela vista para mostrar nuestras vistas
        $this->view->render("header");
        $this->view->render("cotizacion/crear");
        $this->view->render("footer");
    }
    public function cargando($id)
    {
        // toma el id y lo pasa a una propiedad de la vista para usarla dentro de ella
        $this->view->id = $id;
        // muestra las vistas usando el metodo de la clase view
        $this->view->render("header");
        $this->view->render("cotizacion/cargando");
        $this->view->render("footer");
    }
    public function descargar($id)
    {
        // asignamos las propiedades del api con el registro a una variable que usaremos en la vista
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // las propiedades del subformulario se asignan como array
        $this->view->cotizaciones = $this->view->trato->getFieldValue('Aseguradoras_Disponibles');
        // asignar una variable con las propiedasdes de la api para usarlas en la vista
        $this->view->api = $this->api;
        // toma el id y lo pasa a una propiedad de la vista para usarla dentro de ella
        $this->view->id = $id;
        function calcular_1($valor, $porciento)
        {
            return $valor * ($porciento / 100);
        }
        // llamamos a la vista
        $this->view->render("cotizacion/descargar");
    }
    public function emitir($id)
    {
        // asignar las propiedades del registro a una variable que se usara en la vista
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // las propiedades del subformulario se asignan como array
        $this->view->cotizaciones = $this->view->trato->getFieldValue('Aseguradoras_Disponibles');
        // asignar una variable con las propiedasdes de la api para usarlas en la vista
        $this->view->api = $this->api;
        // toma el id y lo pasa a una propiedad de la vista para usarla dentro de ella
        $this->view->id = $id;
        // si existe post
        if (isset($_POST['submit'])) {
            // ubicacion donde estaran los archivcos temporalmenten antes de subirlos al crm
            $ruta_cotizacion = "public/tmp";
            // se comprueba si la ubicacion existe,si no, la crea
            if (!is_dir($ruta_cotizacion)) {
                mkdir($ruta_cotizacion, 0755, true);
            }
            // comprobamos si se subio el archivo
            if (!empty($_FILES["cotizacion_firmada"]["name"])) {
                // se toma la extension del archivo
                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                // se establecen que archivos esta permitidos
                $permitido = array("pdf");
                // se comprueban el archivo cumple la condicion
                if (in_array($extension, $permitido)) {
                    // se almacenan los cambios en un array
                    // NOTA: los nombres de las propiedades del array deben ser iguales al de las api en zoho
                    $cambios["Aseguradora"] = $_POST["aseguradora"];
                    $cambios["Stage"] = "En trámite";
                    $cambios["Deal_Name"] = "Resumen";
                    // se guardan los cambios en el registro del crm
                    $this->api->updateRecord("Deals", $cambios, $id);
                    // tomamos archivo en su posicion temporal en el servidor
                    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                    // asignamos el nombre original del archivo subido
                    $name = basename($_FILES["cotizacion_firmada"]["name"]);
                    // movemos el archivo en la ubicacion de nuestro sitio
                    move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                    // subimos el archivo desde nuestra ubicacion hacia el crm
                    $this->api->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                    // borramos archivo dela carpeta en nuetro sitio
                    unlink("$ruta_cotizacion/$name");
                    echo '<script>alert("Póliza emitida,descargue la cotización para obtener el carnet")</script>';
                    echo '<script>window.location = "' . constant('url') . 'cotizacion/cargando/' . $id . '"</script>';
                } else {
                    echo '<script>alert("Error al cargar documentos,formatos adminitos: PDF");</script>';
                }
            }
            // comprobamos si se subio el archivo
            if (!empty($_FILES["documentos"]['name'][0])) {
                // tomamos todos los archivos subidos
                foreach ($_FILES["documentos"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        // tomamos archivo en su posicion temporal en el servidor
                        $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                        // asignamos el nombre original del archivo subido
                        $name = basename($_FILES["documentos"]["name"][$key]);
                        // movemos el archivo en la ubicacion de nuestro sitio
                        move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                        // subimos el archivo desde nuestra ubicacion hacia el crm
                        $this->api->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                        // borramos archivo dela carpeta en nuetro sitio
                        unlink("$ruta_cotizacion/$name");
                    }
                }
            }
        }
        // llamamos a la vista
        $this->view->render("header");
        $this->view->render("cotizacion/emitir");
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
        $this->view->render("cotizacion/lista");
        $this->view->render("footer");
    }
}
