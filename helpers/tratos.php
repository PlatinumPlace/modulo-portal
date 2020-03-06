<?php

class tratos extends api
{
    public function resumen($contacto_id)
    {
        $criterio = "Contact_Name:equals:" . $contacto_id;
        $tratos = $this->searchRecordsByCriteria("Deals", $criterio);
        $resultado['total'] = 0;
        $resultado['emisiones'] = 0;
        $resultado['vencimientos'] = 0;
        $resultado['filtro_emisiones'] = "";
        $resultado['filtro_vencimientos'] = "";
        if (!empty($tratos)) {
            foreach ($tratos as $trato) {
                $resultado['total'] += 1;
                if (
                    date(
                        "m",
                        strtotime($trato->getFieldValue("Closing_Date"))
                    ) == date('m')
                ) {
                    $resultado['emisiones'] += 1;
                    $resultado['filtro_emisiones'] = $trato->getFieldValue("Stage");
                }
                if (
                    date(
                        "Y-m",
                        strtotime($trato->getFieldValue("Closing_Date"))
                    ) == date('Y-m')
                ) {
                    $resultado['vencimientos'] += 1;
                    $resultado['filtro_vencimientos'] = $trato->getFieldValue("Stage");
                }
            }
        }
        return $resultado;
    }

    public function crear()
    {
        $trato["Contact_Name"] = $_SESSION['usuario']['id'];
        $trato["Lead_Source"] = "Portal GNB";
        $trato["Deal_Name"] = "Cotización";
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
        $trato["Type"] = $_POST['cotizacion'];
        $trato["Per_odo"] = $_POST['periodo'];
        $trato["Uso"] = $_POST['uso'];
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
        return $this->createRecord("Deals", $trato);
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
        $trato["Type"] = $_POST['cotizacion'];
        $trato["Per_odo"] = $_POST['periodo'];
        $trato["Uso"] = $_POST['uso'];
        if (isset($_POST['estado'])) {
            $trato["Es_nuevo"] = true;
        } else {
            $trato["Es_nuevo"] = false;
        }
        return $this->updateRecord("Deals", $trato, $trato_id);
    }

    public function eliminar($trato_id)
    {
        $cambios["Stage"] = "Abandonado";
        $this->updateRecord("Deals", $cambios, $trato_id);
    }

    public function emitir($trato_id)
    {
        $ruta_cotizacion = "tmp";
        if (!is_dir($ruta_cotizacion)) {
            mkdir($ruta_cotizacion, 0755, true);
        }
        if (isset($_FILES["cotizacion_firmada"])) {
            $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
            $permitido = array("pdf");
            if (in_array($extension, $permitido)) {
                $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                $name = basename($_FILES["cotizacion_firmada"]["name"]);
                move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                $this->uploadAttachment("Deals", $trato_id, "$ruta_cotizacion/$name");
                unlink("$ruta_cotizacion/$name");
                $cambios["Aseguradora"] = $_POST["aseguradora"];
                $cambios["Stage"] = "En trámite";
                return $this->updateRecord("Deals", $cambios, $trato_id);
            } else {
                return "Error al cargar documentos,formatos adminitos: PDF";
            }
        }
        if (isset($_FILES["documentos"])) {
            foreach ($_FILES["documentos"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                    $name = basename($_FILES["documentos"]["name"][$key]);
                    move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                    $this->uploadAttachment("Deals", $trato_id, "$ruta_cotizacion/$name");
                    unlink("$ruta_cotizacion/$name");
                }
            }
            return "Archivos subidos";
        }
    }

    public function ver_coberturas($plan_id, $cuenta_id)
    {
        $plan_detalles = $this->getRecord("Products", $plan_id);
        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
            $criterio = "((Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId() . ") and (Socio_IT:equals:" . $cuenta_id . "))";
            return $this->searchRecordsByCriteria("Coberturas", $criterio);
        } else {
            return null;
        }
    }

    public function generar_imagen_aseguradora($plan_id)
    {
        $plan_detalles = $this->getRecord("Products", $plan_id);
        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
            return $this->downloadPhoto(
                "Vendors",
                $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                "img/Aseguradoras/"
            );
        } else {
            return null;
        }
    }
}
