<?php

class cotizacion extends api
{
    public $usuario;

    function __construct()
    {
        $this->usuario = json_decode($_COOKIE["usuario"], true);

        parent::__construct();
    }

    public function lista()
    {
        $criterio = "Contact_Name:equals:" . $this->usuario['id'];
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }

    public function buscar($parametro, $busqueda)
    {
        $criterio = "((Contact_Name:equals:" .  $this->usuario['id'] . ") and ($parametro:equals:$busqueda))";
        return $this->searchRecordsByCriteria("Deals", $criterio);
    }

    public function crear($cotizacion)
    {
        return $this->createRecord("Deals", $cotizacion);
    }

    public function detalles($id)
    {
        $resultado["oferta"] = $this->getRecord("Deals", $id);

        $criterio = "Deal_Name:equals:" . $id;
        $resultado["cotizaciones"] = $this->searchRecordsByCriteria("Quotes", $criterio);

        return $resultado;
    }

    public function actualizar($id, $cotizacion)
    {
        return $this->updateRecord("Deals", $id, $cotizacion);
    }

    public function adjuntar_archivos($id, $ruta_archivo)
    {
        return $this->uploadAttachment("Deals", $id, $ruta_archivo);
    }

    public function lista_documentos_adjuntos($id)
    {
        return $this->getAttachments("Deals", $id);
    }

    public function lista_marcas()
    {
        return $this->getRecords("Marcas");
    }

    public function detalles_modelo($modelo_id)
    {
        return $this->getRecord("Modelos", $modelo_id);
    }

    public function lista_aseguradoras()
    {
        $criterio = "Socio:equals:" .  $this->usuario['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);

        foreach ($contratos as $contrato) {
            $aseguradoras[$contrato->getEntityId()] = $contrato->getFieldValue('Aseguradora')->getLookupLabel();
        }

        return array_unique($aseguradoras);
    }

    public function lista_clientes()
    {
        $criterio = "Reporting_To:equals:" . $this->usuario["id"];
        return $this->searchRecordsByCriteria("Contacts", $criterio);
    }

    public function cliente_detalles($id)
    {
        return $this->getRecord("Contacts", $id);
    }

    public function foto_aseguradora($id)
    {
        if (!is_dir("public/img")) {
            mkdir("public/img", 0755, true);
        }

        return $this->downloadPhoto("Vendors", $id, "public/img/");
    }

    public function contrato_detalles($id)
    {
        return $this->getRecord("Contratos", $id);
    }

    public function exportar_emisiones_csv($tipo_cotizacion, $contrato_id, $desde, $hasta)
    {
        $contrato = $this->getRecord("Contratos", $contrato_id);
        $emitida = array("Emitido", "En trámite");

        $emisiones = $this->buscar("Aseguradora", $contrato->getFieldValue("Aseguradora")->getEntityId());

        if (!empty($emisiones)) {

            if (!is_dir("public/file")) {
                mkdir("public/file", 0755, true);
            }

            $fp = fopen('public/file/reporte.csv', 'w');

            $titulo = "Reporte Emisiones $tipo_cotizacion";

            $lista = array(
                array($contrato->getFieldValue("Socio")->getLookupLabel()),
                array($titulo),
                array("Aseguradora:", $contrato->getFieldValue("Aseguradora")->getLookupLabel()),
                array("Poliza:", $contrato->getFieldValue('No_P_liza')),
                array("Desde:", $desde, "Hasta:", $hasta),
                array("Vendedor:", $this->usuario['nombre']),
                array("Formato de moneda:", "RD$"),
                array("")
            );
            foreach ($lista as $campos) {
                fputcsv($fp, $campos);
            }


            $lista = array(
                array(
                    "Fecha de emision",
                    "Nombre Asegurado",
                    "Cedula",
                    "Bien Asegurado",
                    "Valor Asegurado",
                    "Plan",
                    "Prima Neta",
                    "Prima Total",
                    "Comision"
                )
            );
            foreach ($lista as $campos) {
                fputcsv($fp, $campos);
            }

            $total_neta = 0;
            $total_prima = 0;
            $total_comision = 0;
            $total_valor = 0;
            foreach ($emisiones as $emision) {

                if (
                    $emision->getFieldValue("Contact_Name")->getEntityId() == $this->usuario['id']
                    and
                    date("Y-m-d", strtotime($emision->getFieldValue("Fecha_de_emisi_n")))  > $desde
                    and
                    date("Y-m-d", strtotime($emision->getFieldValue("Fecha_de_emisi_n"))) < $hasta
                    and
                    in_array($emision->getFieldValue("Stage"), $emitida)
                    and
                    $emision->getFieldValue("Type") == $tipo_cotizacion
                ) {
                    $total_neta += $emision->getFieldValue('Prima_Neta');
                    $total_prima += $emision->getFieldValue('Prima_Total');
                    $total_comision += $emision->getFieldValue('Comisi_n_Socio');
                    $total_valor += $emision->getFieldValue('Valor_Asegurado');

                    $lista = array(
                        array(
                            date("Y-m-d", strtotime($emision->getFieldValue("Fecha_de_emisi_n"))),
                            $emision->getFieldValue("Nombre") . " " . $emision->getFieldValue("Apellido"),
                            $emision->getFieldValue("RNC_Cedula"),
                            $emision->getFieldValue("Type"),
                            $emision->getFieldValue('Valor_Asegurado'),
                            $emision->getFieldValue('Plan'),
                            $emision->getFieldValue('Prima_Neta'),
                            $emision->getFieldValue('Prima_Total'),
                            $emision->getFieldValue('Comisi_n_Socio')
                        )
                    );
                    foreach ($lista as $campos) {
                        fputcsv($fp, $campos);
                    }
                }
            }

            $lista = array(
                array(""),
                array("Total de las Primas Neta:", $total_neta),
                array("Total de las Primas:", $total_prima),
                array("Total de las Comisiones:", $total_comision),
                array("Total de los Valores Asegurados:", $total_valor)
            );
            foreach ($lista as $campos) {
                fputcsv($fp, $campos);
            }

            fclose($fp);

            return $titulo;
        }
    }

    public function exportar_cotizaciones_csv($tipo_cotizacion, $contrato_id, $desde, $hasta)
    {
        $contrato = $this->getRecord("Contratos", $contrato_id);

        $criterio = "Contrato:equals:" .  $contrato_id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);

        if (!empty($cotizaciones)) {

            if (!is_dir("public/file")) {
                mkdir("public/file", 0755, true);
            }

            $fp = fopen('public/file/reporte.csv', 'w');

            $titulo = "Reporte Cotizaciones $tipo_cotizacion";

            $lista = array(
                array($contrato->getFieldValue("Socio")->getLookupLabel()),
                array($titulo),
                array("Aseguradora:", $contrato->getFieldValue("Aseguradora")->getLookupLabel()),
                array("Poliza:", $contrato->getFieldValue('No_P_liza')),
                array("Desde:", $desde, "Hasta:", $hasta),
                array("Vendedor:", $this->usuario['nombre']),
                array("Formato de moneda:", "RD$"),
                array("")
            );
            foreach ($lista as $campos) {
                fputcsv($fp, $campos);
            }


            if ($tipo_cotizacion == "Auto") {
                $lista = array(
                    array(
                        "Fecha de emision",
                        "Nombre Asegurado",
                        "Cedula",
                        "Marca",
                        "Modelo",
                        "Ano",
                        "Color",
                        "Chasis",
                        "Placa",
                        "Valor Asegurado",
                        "Plan"
                    )
                );
            }
            foreach ($lista as $campos) {
                fputcsv($fp, $campos);
            }

            $total_valor = 0;
            foreach ($cotizaciones as $cotizacion) {

                $resumen = $this->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());

                if (
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  > $desde
                    and
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) < $hasta
                    and
                    $resumen->getFieldValue("Stage") == "Cotizando"
                    and
                    $resumen->getFieldValue("Type") == $tipo_cotizacion
                ) {

                    $total_valor += $resumen->getFieldValue('Valor_Asegurado');

                    $lista = array(
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
                            $resumen->getFieldValue('Valor_Asegurado'),
                            $resumen->getFieldValue('Plan'),
                        )
                    );
                    foreach ($lista as $campos) {
                        fputcsv($fp, $campos);
                    }
                }
            }


            $lista = array(
                array(""),
                array("Total de los Valores Asegurados:", $total_valor)
            );
            foreach ($lista as $campos) {
                fputcsv($fp, $campos);
            }

            fclose($fp);

            return $titulo;
        }
    }
}
