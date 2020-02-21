<?php

class deals_model extends api_model
{
    public function resumen($contacto_id)
    {
        $criterio = "Contact_Name:equals:" . $contacto_id;
        $tratos = $this->searchRecordsByCriteria("Deals", $criterio);
        $resultado['total'] = 0;
        $resultado['emisiones'] = 0;
        $resultado['vencimientos'] = 0;
        if (!empty($tratos)) {
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
        $marca = $this->getRecord("Marcas", $_POST['marca']);
        $trato["Marca"] = $marca->getFieldValue('Name');
        $modelo = $this->getRecord("Modelos", $_POST['modelo']);
        $trato["Modelo"] = $modelo->getFieldValue('Name');
        $trato["Tipo_de_vehiculo"] = $modelo->getFieldValue('Tipo');
        $trato["Nombre_del_asegurado"] = $_POST['nombre'];
        $trato["Apellido_del_asegurado"] = $_POST['apellido'];
        $trato["Placa"] = $_POST['placa'];
        $trato["Plan"] = $_POST['plan'];
        $trato["Type"] = "Vehículo";
        $trato["Activo"] = true;
        $trato["RNC_Cedula_del_asegurado"] = $_POST['cedula'];
        $trato["Telefono_del_asegurado"] = $_POST['telefono'];
        $trato["Tipo_de_poliza"] = $_POST['poliza'];
        $trato["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
        $trato["Stage"] = "Cotizando";
        if (isset($_POST['estado'])) {
            $trato["Es_nuevo"] = true;
        } else {
            $trato["Es_nuevo"] = false;
        }
        $this->createRecord("Deals", $trato);
    }

    public function detalles($trato_id)
    {
        return $this->getRecord("Deals", $trato_id);
    }

    public function lista($contacto_id)
    {
        $criterio = "Contact_Name:equals:" . $contacto_id;
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }

    public function buscar($contacto_id, $busqueda, $parametro)
    {
        switch ($parametro) {
            case 'nombre':
                $criterio = "((Contact_Name:equals:" . $contacto_id . ") and (Nombre_del_asegurado:equals:" . $busqueda . "))";
                break;
            case 'numero':
                $criterio = "((Contact_Name:equals:" . $contacto_id . ") and (No_de_cotizaci_n:equals:" . $busqueda . "))";
                break;
        }
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }

    public function editar($trato_id)
    {
        $trato["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
        $trato["Chasis"] = $_POST['chasis'];
        $trato["Color"] = $_POST['color'];
        $marca = $this->getRecord("Marcas", $_POST['marca']);
        $trato["Marca"] = $marca->getFieldValue('Name');
        $modelo = $this->getRecord("Modelos", $_POST['modelo']);
        $trato["Modelo"] = $modelo->getFieldValue('Name');
        $trato["Tipo_de_vehiculo"] = $modelo->getFieldValue('Tipo');
        $trato["Placa"] = $_POST['placa'];
        $trato["Plan"] = $_POST['plan'];
        $trato["Tipo_de_poliza"] = $_POST['poliza'];
        $trato["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
        if (isset($_POST['estado'])) {
            $trato["Es_nuevo"] = true;
        } else {
            $trato["Es_nuevo"] = false;
        }
        $this->updateRecord("Deals", $trato, $trato_id);
    }

    public function eliminar($trato_id)
    {
        $cambios["Stage"] = "Abandonado";
        $this->updateRecord("Deals", $cambios, $trato_id);
    }

    public function emitir($trato_id)
    {
        $ruta_cotizacion = "file/cotizaciones/" . $trato_id;
        if (!is_dir($ruta_cotizacion)) {
            mkdir($ruta_cotizacion, 0755, true);
        }
        if (isset($_POST['aseguradora']) and isset($_FILES["cotizacion_firmada"])) {
            $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
            if ($extension == "pdf" or $extension == "docx") {
                $nombreArchivo = $trato_id . "." . $extension;
                $nuevaUbicacion = $ruta_cotizacion . "/" . $nombreArchivo;
                if (move_uploaded_file($_FILES['cotizacion_firmada']['tmp_name'], $nuevaUbicacion)) {
                    $cambios["Aseguradora"] = $_POST["aseguradora"];
                    $cambios["Stage"] = "En trámite";
                    $this->updateRecord("Deals", $cambios, $trato_id);
                    return "Póliza emitida,descargue la cotización para obtener el carnet";
                } else {
                    return "No se pudo subir el documento,intentelo mas tarde";
                }
            } else {
                return "Error al cargar documentos,formatos adminitos: PDF,DOCX";
            }
        } 
        /*
        elseif (isset($_FILES["expedientes"])) {
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
        */
    }
}
