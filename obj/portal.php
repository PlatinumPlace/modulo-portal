<?php

class portal
{
    public $cotizacion;

    function __construct()
    {
        $this->cotizaciones = new cotizacion;
    }

    public function pagina_principal()
    {
        $cotizaciones = $this->cotizaciones->resumen("3222373000000751142");
        require("template/header.php");
        require("pages/portal/index.php");
        require("template/footer.php");
    }

    public function lista_cotizaciones()
    {
        $filtro = $_GET['filter'];
        $criterio = "Contact_Name:equals:" . "3222373000000751142";
        $ofertas = $this->api->searchRecordsByCriteria("Deals", $criterio);
        require("core/views/template/header.php");
        require("core/views/home/list.php");
        require("core/views/template/footer.php");
    }

    public function buscar_cotizacion()
    {
        if ($_POST) {
            switch ($_POST['opcion']) {
                case 'nombre':
                    $criterio = "((Contact_Name:equals:" . "3222373000000751142" . ") and (Nombre_del_asegurado:equals:" . $_POST['buscar'] . "))";
                    break;
                case 'numero':
                    $criterio = "((Contact_Name:equals:" . "3222373000000751142" . ") and (No_de_cotizaci_n:equals:" . $_POST['buscar'] . "))";
                    break;
            }
            $trato_id = $_GET['id'];
        } else {
            $criterio = "Contact_Name:equals:" . "3222373000000751142";
        }
        $tratos = $this->api->searchRecordsByCriteria("Deals", $criterio);
        require("core/views/template/header.php");
        require("core/views/home/search.php");
        require("core/views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        if ($_POST) {
            $trato["Contact_Name"] = "3222373000000751142";
            $trato["Lead_Source"] = "Portal GNB";
            $trato["Deal_Name"] = "Trato creado desde el portal";
            $trato["Direcci_n_del_asegurado"] = $_POST['direccion'];
            $trato["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
            $trato["Chasis"] = $_POST['chasis'];
            $trato["Color"] = $_POST['color'];
            $trato["Email_del_asegurado"] = $_POST['email'];
            $trato["Marca"] = $_POST['marca'];
            $trato["Modelo"] = $_POST['modelo'];
            $trato["Nombre_del_asegurado"] = $_POST['nombre'];
            $trato["Apellido_del_asegurado"] = $_POST['apellido'];
            $trato["Placa"] = $_POST['placa'];
            $trato["Plan"] = $_POST['plan'];
            $trato["Type"] = "Vehículo";
            $trato["RNC_Cedula_del_asegurado"] = $_POST['cedula'];
            $trato["Telefono_del_asegurado"] = $_POST['telefono'];
            $trato["Tipo_de_poliza"] = $_POST['poliza'];
            $trato["Tipo_de_vehiculo"] = $_POST['Tipo_de_vehiculo'];
            $trato["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            if (isset($_POST['estado'])) {
                $trato["Es_nuevo"] = true;
            } else {
                $trato["Es_nuevo"] = false;
            }
            $resultado = $this->api->createRecord("Deals", $trato);
            if (!empty($resultado)) {
                $mensaje = "Cotización realizada exitosamente";
            } else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("core/views/template/header.php");
        require("core/views/home/add.php");
        require("core/views/template/footer.php");
        if ($_POST) {
            echo '
            <script>
            $(document).ready(function(){
                $("#modal").modal();
                $("#modal").modal("open"); 
             });
            </script>
            ';
        }
    }

    public function ver_cotizacion()
    {
        $trato_id = $_GET['id'];
        $trato = $this->api->getRecord("Deals", $trato_id);
        $cotizacion = $this->api->getRecord("Quotes", $trato->getFieldValue('Cotizaci_n')->getEntityId());
        require("core/views/template/header.php");
        require("core/views/home/details.php");
        require("core/views/template/footer.php");
    }

    public function descargar_cotizacion()
    {
        $trato_id = $_GET['id'];
        $trato = $this->api->getRecord("Deals", $trato_id);
        $cotizacion = $this->api->getRecord("Quotes", $trato->getFieldValue('Cotizaci_n')->getEntityId());
        require("core/views/home/download.php");
    }

    public function editar_cotizacion()
    {
        $trato_id = $_GET['id'];
        $trato = $this->api->getRecord("Deals", $trato_id);
        if ($_POST) {
            $cambios["A_o_de_Fabricacion"] = (int) $_POST['A_o_de_Fabricacion'];
            $cambios["Chasis"] = $_POST['chasis'];
            $cambios["Color"] = $_POST['color'];
            $cambios["Marca"] = $_POST['marca'];
            $cambios["Modelo"] = $_POST['modelo'];
            $cambios["Placa"] = $_POST['placa'];
            $cambios["Plan"] = $_POST['plan'];
            $cambios["Type"] = "Vehículo";
            $cambios["Tipo_de_poliza"] = $_POST['poliza'];
            $cambios["Tipo_de_vehiculo"] = $_POST['Tipo_de_vehiculo'];
            $cambios["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            if (isset($_POST['estado'])) {
                $cambios["Es_nuevo"] = true;
            } else {
                $cambios["Es_nuevo"] = false;
            }
            $resultado = $this->api->updateRecord("Deals", $cambios, $trato_id);
            if (!empty($resultado)) {
                $mensaje = "Cambios realizados exitosamente";
            } else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("core/views/template/header.php");
        require("core/views/home/edit.php");
        require("core/views/template/footer.php");

        if ($_POST) {
            echo '
            <script>
            $(document).ready(function(){
                $("#modal").modal();
                $("#modal").modal("open"); 
             });
            </script>
            ';
        }
    }

    public function emitir_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $ruta_cotizacion = "file/Cotizaciones/" . $oferta_id;
        if ($_POST) {
            $oferta = $this->api->getRecord("Deals", $oferta_id);
            if ($oferta->getFieldValue('Aseguradora') == null) {
                $ofertas_cambios["Aseguradora"] = $_POST["aseguradora"];
                $resultado = $this->api->updateRecord("Deals", $ofertas_cambios, $oferta_id);
            }
            if (isset($_FILES["cotizacion_firmada"])) {
                $rutaDeSubidas = dirname(__DIR__, 2) . "/" . $ruta_cotizacion;
                if (!is_dir($rutaDeSubidas)) {
                    mkdir($rutaDeSubidas, 0777, true);
                }
                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                $archivonombre = $_FILES["cotizacion_firmada"]["name"];
                $nombreArchivo = $archivonombre . "." . $extension;
                $nuevaUbicacion = $rutaDeSubidas . "/" . $nombreArchivo;
                move_uploaded_file($_FILES["cotizacion_firmada"]["tmp_name"], $nuevaUbicacion);
            }
            if (isset($_FILES["expedientes"])) {
                $rutaDeSubidas = dirname(__DIR__, 2) . "/" . $ruta_cotizacion;
                if (!is_dir($rutaDeSubidas)) {
                    mkdir($rutaDeSubidas, 0777, true);
                }
                foreach ($_FILES["expedientes"]['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES["expedientes"]["name"][$key]) {
                        $extension = pathinfo($_FILES["expedientes"]["name"][$key], PATHINFO_EXTENSION);
                        $archivonombre = $_FILES["expedientes"]["name"][$key];
                        $nombreArchivo = $archivonombre . "." . $extension;
                        $nuevaUbicacion = $rutaDeSubidas . "/" . $nombreArchivo;
                        move_uploaded_file($_FILES["expedientes"]["tmp_name"][$key], $nuevaUbicacion);
                    }
                }
            }
            if (!empty($resultado)) {
                $mensaje = "Acción realizada exitosamente";
            } else {
                if (isset($_FILES["expedientes"])) {
                    $mensaje = "Archivos subidos exitosamente";
                } else {
                    $mensaje = "Ha ocurrido un error,intentelo mas tarde";
                }
            }
        } else {
            $criterio = "Deal_Name:equals:" . $oferta_id;
            $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        }
        require("core/views/template/header.php");
        require("core/views/home/emit.php");
        require("core/views/template/footer.php");
        if ($_POST) {
            echo '<script>$("#Modal").modal("show")</script>';
        }
    }

    public function eliminar_cotizacion()
    {
        $trato_id = $_GET['id'];
        $cambios["Activo"] = false;
        $resultado = $this->api->updateRecord("Deals", $cambios, $trato_id);
        $this->buscar_cotizacion();
        if ($_POST) {
            echo '
            <script>
            $(document).ready(function(){
                $("#modal").modal();
                $("#modal").modal("open"); 
             });
            </script>
            ';
        }
    }
}
