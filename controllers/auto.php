<?php
class Auto extends Controller
{
    function __construct()
    {
        // Inicializar la clase controller de libs para tener acceso a las
        // propiedades de la clase api y la clase view inicializadas en ella.
        parent::__construct();
    }
    public function crear()
    {
        // asigna las propiedades de la clase api a una varible para usarlas en la vista
        $this->view->api = $this->api;
        if (isset($_POST['submit'])) {
            // crear un array donde almacenar los datos del nuevo registro
            // NOTA: los nombres de las propiedades del array deben ser iguales
            // a los nombres de los campos del modulo (nombre de api)
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
            // ademas del controlador de donde proviene
            $datos = $this->api->createRecord("Deals", $trato) . "-auto";
            // mensaje de aprobacion
            // con el id de resultado,redirige a una vista intermedia para dar tiempo
            // al crm de hacer flujos de trabajo
            echo '<script>alert("Cotización creada")</script>';
            echo '<script>window.location = "' . constant('url') . 'home/cargando/' . $datos . '"</script>';
        }
        // llama a las vistas
        $this->view->render("header");
        $this->view->render("auto/crear");
        $this->view->render("footer");
    }
    public function detalles($id)
    {
        // variable para usar en la vista con las propiedades de la clase api
        $this->view->api = $this->api;
        // variable para usar en la vista con las propiedades del objeto resultante de la funcion
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // en caso de que la consulta marque error
        if (empty($this->view->trato)) {
            require_once "controllers/error.php";
            $controlador = new Desvio;
            return false;
        }
        // variable para usar en la vista con las propiedades subformulario que se asignan usando un foreach
        $criterio = "Deal_Name:equals:" . $id;
        $this->view->cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        // llama a la vista
        $this->view->render("header");
        $this->view->render("auto/detalles");
        $this->view->render("footer");
    }
    public function completar($id)
    {
        // variable para usar en la vista con las propiedades de la clase api
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // en caso de que la consulta marque error
        if (empty($this->view->trato)) {
            require_once "controllers/error.php";
            $controlador = new Desvio;
            return false;
        }
        if (isset($_POST['submit'])) {
            // toma los valores y lo asignamos a un array
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
            // guarda los cambios en un array y lo guardamos en el registro
            $this->api->updateRecord("Deals", $cambios, $id);
            // mensaje de aprobacion
            echo '<script>alert("Cotización completada")</script>';
            echo '<script>window.location = "' . constant('url') . 'auto/detalles/' . $id . '"</script>';
        }
        // llama a la vista
        $this->view->render("header");
        $this->view->render("auto/completar");
        $this->view->render("footer");
    }
    public function descargar($id)
    {
        // variable para usar en la vista con las propiedades de la clase api
        $this->view->api = $this->api;
        // variable para usar en la vista con las propiedades del objeto resultante de la funcion
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // en caso de que la consulta marque error
        if (empty($this->view->trato)) {
            require_once "controllers/error.php";
            $controlador = new Desvio;
            return false;
        }
        // variable para usar en la vista con las propiedades subformulario que se asignan en un foreach
        $criterio = "Deal_Name:equals:" . $id;
        $this->view->cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        // llama a la vista
        $this->view->render("auto/descargar");
    }
    public function emitir($id)
    {
        // variable para usar en la vista con las propiedades de la clase api
        $this->view->api = $this->api;
        // variable para usar en la vista con las propiedades del objeto resultante de la funcion
        $this->view->trato = $this->api->getRecord("Deals", $id);
        // en caso de que la consulta marque error
        if (empty($this->view->trato)) {
            require_once "controllers/error.php";
            $controlador = new Desvio;
            return false;
        }
        // variable para usar en la vista con las propiedades subformulario que se asignan  en un foreach
        $criterio = "Deal_Name:equals:" . $id;
        $this->view->cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        if (isset($_POST['submit'])) {
            // ubicacion donde estaran los archivcos temporalmenten antes de subirlos al crm
            $ruta_cotizacion = "public/tmp";
            // comprueba si la ubicacion existe,si no, la crea
            if (!is_dir($ruta_cotizacion)) {
                mkdir($ruta_cotizacion, 0755, true);
            }
            // comprueba si se subio el archivo
            if (!empty($_FILES["cotizacion_firmada"]["name"])) {
                // toma la extension del archivo
                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                // establece que archivos esta permitidos
                $permitido = array("pdf");
                // comprueba el archivo cumple la condicion
                if (in_array($extension, $permitido)) {
                    // almacena los cambios en un array
                    // NOTA: los nombres de las propiedades del array deben ser iguales al de las api en zoho
                    $cambios["Aseguradora"] = $_POST["aseguradora"];
                    $cambios["Stage"] = "En trámite";
                    $cambios["Deal_Name"] = "Resumen";
                    // guarda los cambios en el registro del crm
                    $this->api->updateRecord("Deals", $cambios, $id);
                    // toma el archivo en su posicion temporal en el servidor
                    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                    // asigna el nombre original del archivo subido
                    $name = basename($_FILES["cotizacion_firmada"]["name"]);
                    // mueve el archivo en la ubicacion de nuestro sitio
                    move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                    // sube el archivo desde nuestra ubicacion hacia el crm
                    $this->api->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                    // borra archivo de la carpeta donde se subio en el sitio
                    unlink("$ruta_cotizacion/$name");
                    echo '<script>alert("Póliza emitida,descargue la cotización para obtener el carnet")</script>';
                    echo '<script>window.location = "' . constant('url') . 'home/cargando/' . $id . '-auto"</script>';
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
        $this->view->render("auto/emitir");
        $this->view->render("footer");
    }
}
