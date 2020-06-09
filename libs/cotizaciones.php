<?php

class cotizaciones extends api
{

    function __construct()
    {
        parent::__construct();
    }

    public function lista_cotizaciones($pagina = 1, $cantidad = 200)
    {
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        return $this->searchRecordsByCriteria("Deals", $criterio, $pagina, $cantidad);
    }

    public function buscar_cotizaciones($parametro, $busqueda)
    {
        $criterio = "((Contact_Name:equals:" .  $_SESSION["usuario"]['id'] . ") and ($parametro:equals:$busqueda))";
        return $this->searchRecordsByCriteria("Deals", $criterio, 1, 200);
    }

    public function obtener_marcas()
    {
        return $this->getRecords("Marcas");
    }

    public function crear_auto()
    {
        $nueva_cotizacion["Stage"] = "Cotizando";
        $nueva_cotizacion["Type"] = "Auto";
        $nueva_cotizacion["Lead_Source"] = "Portal GNB";
        $nueva_cotizacion["Deal_Name"] = "Cotización";
        $nueva_cotizacion["Contact_Name"] =  $_SESSION["usuario"]['id'];
        $nueva_cotizacion["Tipo_de_poliza"] = $_POST["Tipo_de_poliza"];
        $nueva_cotizacion["Plan"] = $_POST["Plan"];
        $nueva_cotizacion["Marca"] = $_POST["Marca"];
        $nueva_cotizacion["Modelo"] = $_POST["Modelo"];

        $modelo = $this->getRecord("Modelos", $_POST['Modelo']);

        $nueva_cotizacion["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
        $nueva_cotizacion["Valor_Asegurado"] = $_POST["Valor_Asegurado"];
        $nueva_cotizacion["A_o_de_Fabricacion"] = $_POST["A_o_de_Fabricacion"];
        $nueva_cotizacion["Chasis"] = (isset($_POST["Chasis"])) ? $_POST["Chasis"] : null;
        $nueva_cotizacion["Color"] = (isset($_POST["Color"])) ? $_POST["Color"] : null;
        $nueva_cotizacion["Uso"] = (isset($_POST["Uso"])) ? $_POST["Uso"] : null;
        $nueva_cotizacion["Placa"] = (isset($_POST["Placa"])) ? $_POST["Placa"] : null;
        $nueva_cotizacion["Es_nuevo"] = (isset($_POST["Es_nuevo"])) ? true : false;

        return $this->createRecord("Deals", $nueva_cotizacion);
    }

    public function lista_aseguradoras()
    {
        $criterio = "Socio:equals:" .  $_SESSION["usuario"]['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio, 1, 200);
        if (!empty($contratos)) {
            foreach ($contratos as $contrato) {
                $aseguradoras[$contrato->getEntityId()] = $contrato->getFieldValue('Aseguradora')->getLookupLabel();
            }
            return array_unique($aseguradoras);
        }
    }

    public function detalles_contrato($id)
    {
        return $this->getRecord("Contratos", $id);
    }

    public function detalles_oferta($oferta_id)
    {
        return $this->getRecord("Deals", $oferta_id);
    }

    public function detalles_cotizaciones($oferta_id)
    {
        $criterio = "Deal_Name:equals:$oferta_id";
        return $this->searchRecordsByCriteria("Quotes", $criterio, 1, 200);
    }

    public function lista_clientes($cliente_id)
    {
        $criterio = "Reporting_To:equals:" . $cliente_id;
        return $this->searchRecordsByCriteria("Contacts", $criterio, 1, 200);
    }

    public function completar_auto_cliente_existente($oferta_id, $cliente_id)
    {
        $cambios["Chasis"] = $_POST["Chasis"];
        $cambios["Color"] = $_POST["Color"];
        $cambios["Placa"] = $_POST["Placa"];

        $cliente_info = $this->getRecord("Contacts", $_POST["mis_clientes"]);

        $cambios["Direcci_n"] = $cliente_info->getFieldValue("Mailing_Street");
        $cambios["Nombre"] = $cliente_info->getFieldValue("First_Name");
        $cambios["Apellido"] = $cliente_info->getFieldValue("Last_Name");
        $cambios["RNC_Cedula"] = $cliente_info->getFieldValue("RNC_C_dula");
        $cambios["Telefono"] = $cliente_info->getFieldValue("Phone");
        $cambios["Tel_Residencia"] = $cliente_info->getFieldValue("Home_Phone");
        $cambios["Tel_Trabajo"] = $cliente_info->getFieldValue("Tel_Trabajo");
        $cambios["Fecha_de_Nacimiento"] = $cliente_info->getFieldValue("Date_of_Birth");
        $cambios["Email"] = $cliente_info->getFieldValue("Email");

        if (
            empty($cambios["RNC_Cedula"])
            or
            empty($cambios["Nombre"])
            or
            empty($cambios["Apellido"])
            or
            empty($cambios["Email"])
            or
            empty($cambios["Fecha_de_Nacimiento"])
        ) {
            return "Debes completar almenos el <b>nombre,RNC/Cedula,Email y fecha de nacimiento</b> para agregar un cliente.";
        } else {
            $this->updateRecord("Deals", $oferta_id, $cambios);
        }
    }

    public function completar_auto_cliente_nuevo($oferta_id)
    {
        $cambios["Chasis"] = $_POST["Chasis"];
        $cambios["Color"] = $_POST["Color"];
        $cambios["Placa"] = $_POST["Placa"];

        $cambios["Direcci_n"] = $_POST["Direcci_n"];
        $cambios["Nombre"] = $_POST["Nombre"];
        $cambios["Apellido"] = $_POST["Apellido"];
        $cambios["RNC_Cedula"] = $_POST["RNC_Cedula"];
        $cambios["Telefono"] = (isset($_POST["Telefono"])) ? $_POST["Telefono"] : null;
        $cambios["Tel_Residencia"] = (isset($_POST["Tel_Residencia"])) ? $_POST["Tel_Residencia"] : null;
        $cambios["Tel_Trabajo"] = (isset($_POST["Tel_Trabajo"])) ? $_POST["Tel_Trabajo"] : null;
        $cambios["Fecha_de_Nacimiento"] = $_POST["Fecha_de_Nacimiento"];
        $cambios["Email"] = $_POST["Email"];

        if (
            empty($cambios["RNC_Cedula"])
            or
            empty($cambios["Nombre"])
            or
            empty($cambios["Apellido"])
            or
            empty($cambios["Email"])
            or
            empty($cambios["Fecha_de_Nacimiento"])
        ) {
            return "Debes completar almenos el <b>nombre,RNC/Cedula,Email y fecha de nacimiento</b> para agregar un cliente.";
        } else {
            $this->updateRecord("Deals", $oferta_id, $cambios);
        }
    }

    public function imagen_aseguradora($aseguradora_id)
    {
        $ruta = "img";
        if (!is_dir($ruta)) {
            mkdir($ruta, 0755, true);
        }
        return $this->downloadPhoto("Vendors", $aseguradora_id, "$ruta/");
    }

    public function emitir($oferta_id)
    {
        $ruta = "tmp";
        if (!is_dir($ruta)) {
            mkdir($ruta, 0755, true);
        }

        $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
        $permitido = array("pdf");

        if (in_array($extension, $permitido)) {

            $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
            $name = basename($_FILES["cotizacion_firmada"]["name"]);
            move_uploaded_file($tmp_name, "$ruta/$name");
            $this->uploadAttachment("Deals", $oferta_id, "$ruta/$name");
            unlink("$ruta/$name");
            $cambios["Aseguradora"] = $_POST["aseguradora_id"];
            $cambios["Stage"] = "En trámite";
            $cambios["Deal_Name"] = "Resumen";
            $this->updateRecord("Deals", $oferta_id, $cambios);

            return "Cotizacion emitida,descargue la previsualizacion para obtener el carnet. ";
        } else {
            return "Error al cargar documentos, solo se permiten archivos PDF.";
        }
    }

    public function adjuntar_archivos($oferta_id)
    {
        $ruta = "tmp";
        if (!is_dir($ruta)) {
            mkdir($ruta, 0755, true);
        }

        foreach ($_FILES["documentos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                $name = basename($_FILES["documentos"]["name"][$key]);
                move_uploaded_file($tmp_name, "$ruta/$name");
                $this->uploadAttachment("Deals", $oferta_id, "$ruta/$name");
                unlink("$ruta/$name");
            }
        }

        return "Documentos adjuntados";
    }

    public function lista_docomentos_adjuntos($oferta_id)
    {
        return $this->getAttachments("Deals", $oferta_id);
    }

    public function exportar_csv()
    {
        if (!is_dir("files")) {
            mkdir("files", 0755, true);
        }
        $contrato =  $this->detalles_contrato($_POST["contrato_id"]);
        $lista = $this->buscar_cotizaciones("Type", ucfirst($_POST["tipo_cotizacion"]));
        if ($lista) {
            $fp = fopen("files/reporte.csv", 'w');
            $titulo = "Reporte " . ucfirst($_POST["tipo_reporte"]) . " " . ucfirst($_POST["tipo_cotizacion"]);
            $encabezado = array(
                array($contrato->getFieldValue("Socio")->getLookupLabel()),
                array($titulo),
                array("Aseguradora:", $contrato->getFieldValue("Aseguradora")->getLookupLabel()),
                array("Poliza:", $contrato->getFieldValue('No_P_liza')),
                array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
                array("Vendedor:", $_SESSION["usuario"]['nombre']),
                array("")
            );
            foreach ($encabezado as $campos) {
                fputcsv($fp, $campos);
            }
            if ($_POST["tipo_cotizacion"] == "auto") {
                $tabla_encabezado = array(
                    array(
                        "Fecha Emision",
                        "Nombre Asegurado",
                        "Cedula",
                        "Marca",
                        "Modelo",
                        "Ano",
                        "Color",
                        "Chasis",
                        "Placa",
                        "Valor Asegurado",
                        "Plan",
                        "Prima Neta",
                        "ISC",
                        "Prima Total"
                    )
                );
                if ($_POST["tipo_reporte"] == "comisiones") {
                    $tabla_encabezado[0][] = "Comision";
                }
            }
            foreach ($tabla_encabezado as $campos) {
                fputcsv($fp, $campos);
            }
            $prima_neta_sumatoria = 0;
            $isc_sumatoria = 0;
            $prima_total_sumatoria = 0;
            $valor_asegurado_sumatoria = 0;
            $comision_sumatoria = 0;
            foreach ($lista as $resumen) {
                if (
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                    and
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                    and
                    $resumen->getFieldValue("Contact_Name")->getEntityId() == $_SESSION["usuario"]["id"]
                ) {
                    $detalles = $this->detalles_cotizaciones($resumen->getEntityId());
                    foreach ($detalles as $info) {
                        if (
                            $info->getFieldValue("Aseguradora")->getEntityId() == $contrato->getFieldValue("Aseguradora")->getEntityId()
                            and
                            $info->getFieldValue('Grand_Total') > 0
                        ) {
                            $planes = $info->getLineItems();
                            foreach ($planes as $plan) {
                                $prima_neta = $plan->getTotalAfterDiscount();
                                $isc = $plan->getTaxAmount();
                                $prima_total = $plan->getNetTotal();
                            }
                            $comision = $info->getFieldValue('Comisi_n_Socio');

                            if ($_POST["tipo_reporte"] == "cotizaciones") {
                                $estado[] = "Cotizando";
                            } elseif ($_POST["tipo_reporte"] == "emisiones" or $_POST["tipo_reporte"] == "comisiones") {
                                $estado = array("En trámite", "Emitido");
                            }
                            if (in_array($resumen->getFieldValue("Stage"), $estado)) {
                                $prima_neta_tabla = "RD$" .  number_format($prima_neta, 2);
                                $isc_tabla = "RD$" . number_format($isc, 2);
                                $prima_total_tabla = "RD$" . number_format($prima_total, 2);
                                $comision_tabla = "RD$" . number_format($comision, 2);
                                $valor_asegurado_tabla = "RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2);
                                if ($_POST["tipo_cotizacion"] == "auto") {
                                    $tabla_contenido = array(
                                        array(
                                            date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))),
                                            $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellido"),
                                            $resumen->getFieldValue("RNC_Cedula"),
                                            $resumen->getFieldValue('Marca')->getLookupLabel(),
                                            $resumen->getFieldValue('Modelo')->getLookupLabel(),
                                            $resumen->getFieldValue('A_o_de_Fabricacion'),
                                            $resumen->getFieldValue('Color'),
                                            $resumen->getFieldValue('Chasis'),
                                            $resumen->getFieldValue('Placa'),
                                            $valor_asegurado_tabla,
                                            $resumen->getFieldValue('Plan'),
                                            $prima_neta_tabla,
                                            $isc_tabla,
                                            $prima_total_tabla
                                        )
                                    );
                                    $valor_asegurado_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                    $prima_neta_sumatoria += $prima_neta;
                                    $isc_sumatoria += $isc;
                                    $prima_total_sumatoria += $prima_total;
                                    if ($_POST["tipo_reporte"] == "comisiones") {
                                        $tabla_contenido[0][] = $comision_tabla;
                                        $comision_sumatoria += $comision;
                                    }
                                }
                                foreach ($tabla_contenido as $campos) {
                                    fputcsv($fp, $campos);
                                }
                            }
                        }
                    }
                }
            }
            if (!isset($tabla_contenido)) {
                fclose($fp);
                return "No existen resultados para la aseguradora seleccionada.";
            } else {
                $prima_neta_sumatoria = "RD$" . number_format($prima_neta_sumatoria, 2);
                $isc_sumatoria = "RD$" . number_format($isc_sumatoria, 2);
                $prima_total_sumatoria = "RD$" . number_format($prima_total_sumatoria, 2);
                $valor_asegurado_sumatoria = "RD$" . number_format($valor_asegurado_sumatoria, 2);
                $comision_sumatoria = "RD$" . number_format($comision_sumatoria, 2);
                if ($_POST["tipo_cotizacion"] == "auto") {
                    $pie_pagina = array(
                        array(""),
                        array("Total Primas Netas:", $prima_neta_sumatoria),
                        array("Total ISC:", $isc_sumatoria),
                        array("Total Primas Totales:", $prima_total_sumatoria),
                        array("Total Valores Asegurados:", $valor_asegurado_sumatoria)
                    );
                    if ($_POST["tipo_reporte"] == "comisiones") {
                        $pie_pagina[5] = array("Total Comisiones:", $comision_sumatoria);
                    }
                }
                foreach ($pie_pagina as $campos) {
                    fputcsv($fp, $campos);
                }
                fclose($fp);
                return 'Reporte generado correctamente,<a download="' . $titulo . '.csv" href="' . constant("url") . 'files/reporte.csv" class="btn btn-link">descargar</a>';
            }
        } else {
            return "Ha ocurrido un error,vuelva a intentarlo";
        }
    }
}
