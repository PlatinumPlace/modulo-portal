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
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario']['id'];
        $tratos = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $resultado = array();
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
                    strtotime($trato->getFieldValue("Closing_Date") . "- 1 month")
                ) == date('Y-m')
            ) {
                $resultado['emisiones'] += 1;
                $resultado['filtro_emisiones'] = $trato->getFieldValue("Stage");
            }
            if (
                $trato->getFieldValue("Aseguradora") != null
                and
                date("Y-m", strtotime($trato->getFieldValue("Closing_Date") . "- 1 years")) == date('Y-m')
            ) {
                $resultado['vencimientos'] += 1;
                $resultado['filtro_vencimientos'] = $trato->getFieldValue("Stage");
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
            return $mensaje = "Cotización realizada exitosamente";
        } else {
            return $mensaje = "Ha ocurrido un error,intentelo mas tarde";
        }
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
}
