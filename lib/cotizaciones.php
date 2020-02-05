<?php

class cotizaciones
{
    public $api;

    function __construct()
    {
        $this->api = new api;
    }

    public function resumen()
    {
        $tratos = $this->lista();
        $resultado['total'] = 0;
        $resultado['emisiones'] = 0;
        $resultado['vencimientos'] = 0;
        foreach ($tratos as $trato) {
            $resultado['total'] += 1;
            if (
                $trato->getFieldValue("Aseguradora") != null
                and
                date(
                    "Y-m",
                    strtotime($trato->getFieldValue("Closing_Date") . "- 1 year")
                ) == date('Y-m')
            ) {
                $resultado['emisiones'] += 1;
                $resultado['filtro_emisiones'] = $trato->getFieldValue("Stage");
            }
            if (
                $trato->getFieldValue("Aseguradora") != null
                and
                date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')
            ) {
                $resultado['vencimientos'] += 1;
                $resultado['filtro_vencimientos'] = date("Y-m", strtotime($trato->getFieldValue("Closing_Date")));
            }
        }
        return $resultado;
    }

    public function crear()
    {
        $trato["Contact_Name"] = $_SESSION['usuario']['id'];
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
        $trato["Activo"] = true;
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
        return $resultado = $this->api->createRecord("Deals", $trato);
    }

    public function buscar()
    {
        switch ($_POST['opcion']) {
            case 'nombre':
                $criterio = "((Contact_Name:equals:" . $_SESSION['usuario']['id'] . ") and (Nombre_del_asegurado:equals:" . $_POST['buscar'] . "))";
                break;
            case 'numero':
                $criterio = "((Contact_Name:equals:" . $_SESSION['usuario']['id'] . ") and (No_de_cotizaci_n:equals:" . $_POST['buscar'] . "))";
                break;
        }
        return $tratos = $this->api->searchRecordsByCriteria("Deals", $criterio);
    }

    public function lista()
    {
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario']['id'];
        return $tratos = $this->api->searchRecordsByCriteria("Deals", $criterio);
    }

    public function detalles()
    {
        $resultado['trato'] = $this->api->getRecord("Deals", $_GET['id']);
        $resultado['cotizacion'] = $this->api->getRecord("Quotes", $resultado['trato']->getFieldValue('Cotizaci_n')->getEntityId());
        return $resultado;
    }

    public function imagen_asegradora($plan_id)
    {
        $plan_detalles = $this->api->getRecord("Products", $plan_id);
        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
            $ruta_imagen = $this->api->downloadRecordPhoto(
                "Vendors",
                $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                "img/Aseguradoras/"
            );
        } else {
            $ruta_imagen = null;
        }
        return $ruta_imagen;
    }

    public function coberturas($plan_id, $cuenta_id)
    {
        $plan_detalles = $this->api->getRecord("Products", $plan_id);
        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
            $criterio = "((Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId() . ") and (Socio_IT:equals:" . $cuenta_id . "))";
            $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
        } else {
            $coberturas = null;
        }
        return $coberturas;
    }

    public function editar()
    {
        $cambios["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
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
        $resultado = $this->api->updateRecord("Deals", $cambios, $_GET['id']);
        if (!empty($resultado)) {
            $mensaje = "Cambios realizados exitosamente";
        } else {
            $mensaje = "Ha ocurrido un error,intentelo mas tarde";
        }
        return $mensaje;
    }

    public function eliminar()
    {
        $cambios["Activo"] = false;
        $this->api->updateRecord("Deals", $cambios, $_GET['id']);
    }

    public function emitir()
    {
        $trato = $this->detalles();
        $ruta_cotizacion = "file/cotizaciones/" . $_GET['id'];
        if (!is_dir($ruta_cotizacion)) {
            mkdir($ruta_cotizacion, 0755, true);
        }
        if ($_POST['aseguradora']) {
            $cambios["Aseguradora"] = $_POST["aseguradora"];
            $resultado = $this->api->updateRecord("Deals", $cambios, $_GET['id']);
        }
        if (isset($_FILES["cotizacion_firmada"])) {
            $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
            $archivonombre = "Cotización No. " . $trato['trato']->getFieldValue('No_de_cotizaci_n');
            $nombreArchivo = $archivonombre . "." . $extension;
            $nuevaUbicacion = $ruta_cotizacion . "/" . $nombreArchivo;
            move_uploaded_file($_FILES["cotizacion_firmada"]["tmp_name"], $nuevaUbicacion);
        }
        if (isset($_FILES["expedientes"])) {
            foreach ($_FILES["expedientes"]['tmp_name'] as $key => $tmp_name) {
                if ($_FILES["expedientes"]["name"][$key]) {
                    $extension = pathinfo($_FILES["expedientes"]["name"][$key], PATHINFO_EXTENSION);
                    $archivonombre = $_FILES["expedientes"]["name"][$key];
                    $nombreArchivo = $archivonombre . "." . $extension;
                    $nuevaUbicacion = $ruta_cotizacion . "/" . $nombreArchivo;
                    move_uploaded_file($_FILES["expedientes"]["tmp_name"][$key], $nuevaUbicacion);
                }
            }
        }
        $mensaje = "Cambios realizados exitosamente";
        return $mensaje;
    }

    public function aseguradora($plan_id)
    {
        $plan_detalles = $this->api->getRecord("Products", $plan_id);
        $resultado['nombre'] = $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel();
        $resultado['id'] = $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
        return $resultado;
    }
}