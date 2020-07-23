<?php

class tratos extends home
{
    public function buscar()
    {
        $api = new api;

        $url = $this->obtener_url();
        $filtro = (isset($url[0])) ? $url[0] : "todos";
        $num_pagina = (isset($url[1])) ? $url[1] : 1;

        if ($_POST) {
            $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
            $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 15);
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 15);
        }

        require_once "views/layout/header_main.php";
        require_once "views/tratos/buscar.php";
        require_once "views/layout/footer_main.php";
    }

    public function reporte()
    {
        $api = new api;

        $url = $this->obtener_url();
        $alerta = (isset($url[0])) ? $url[0] : null;

        if (isset($_POST["csv"]) and $_POST["tipo_reporte"] == "auto") {
            $alerta = $this->reporte_auto($api, $_POST);
        } elseif (isset($_POST["pdf"]) and $_POST["tipo_reporte"] == "auto") {
            $titulo = "Reporte Cotizaciones Auto";
            $prima_sumatoria = 0;
            $valor_sumatoria = 0;

            require_once "views/tratos/descargar_reporte_auto.php";
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/tratos/reporte.php";
        require_once "views/layout/footer_main.php";
    }

    public function adjuntar()
    {
        $api = new api;
        $url = $this->obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $trato = $api->detalles_registro("Deals", $id);

        if (empty($trato)) {
            $home = new home;
            $home->error();
            exit();
        }

        if (!empty($_FILES["documentos"]['name'][0])) {
            $ruta = "public/tmp";
            if (!is_dir($ruta)) {
                mkdir($ruta, 0755, true);
            }

            foreach ($_FILES["documentos"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                    $name = basename($_FILES["documentos"]["name"][$key]);
                    move_uploaded_file($tmp_name, "$ruta/$name");
                    $api->adjuntar_archivo("Deals", $id, "$ruta/$name");
                    unlink("$ruta/$name");
                }
            }

            header("Location:" . constant("url") . "tratos/detalles_" . strtolower($trato->getFieldValue('Type')) . "/" . $id . "/Documentos Adjuntados.");
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/tratos/adjuntar.php";
        require_once "views/layout/footer_main.php";
    }

    public function detalles_auto()
    {
        $api = new api;
        $url = $this->obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $num_pagina = (isset($url[1]) and is_numeric($url[1])) ? $url[1] : 1;
        $alerta = (isset($url[1]) and !is_numeric($url[1])) ? $url[1] : null;

        $trato = $api->detalles_registro("Deals", $id);
        if (empty($trato)) {
            $home = new home;
            $home->error();
            exit();
        }

        $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue('P_liza')->getEntityId());
        if (empty($poliza)) {
            $home = new home;
            $home->error();
            exit();
        }

        $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());
        if (empty($bien)) {
            $home = new home;
            $home->error();
            exit();
        }

        $cliente = $api->detalles_registro("Clientes", $trato->getFieldValue('Cliente')->getEntityId());
        if (empty($cliente)) {
            $home = new home;
            $home->error();
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/tratos/detalles_auto.php";
        require_once "views/layout/footer_main.php";
    }

    public function descargar_auto()
    {
        $api = new api;
        $url = $this->obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $trato = $api->detalles_registro("Deals", $id);
        if (empty($trato)) {
            $home = new home;
            $home->error();
            exit();
        }

        $coberturas = $api->detalles_registro("Contratos", $trato->getFieldValue('Contrato')->getEntityId());
        if (empty($coberturas)) {
            $home = new home;
            $home->error();
            exit();
        }

        $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());
        if (empty($bien)) {
            $home = new home;
            $home->error();
            exit();
        }

        $cliente = $api->detalles_registro("Clientes", $trato->getFieldValue('Cliente')->getEntityId());
        if (empty($cliente)) {
            $home = new home;
            $home->error();
            exit();
        }

        $aseguradora = $api->detalles_registro("Vendors", $trato->getFieldValue('Aseguradora')->getEntityId());
        if (empty($aseguradora)) {
            $home = new home;
            $home->error();
            exit();
        }

        $imagen_aseguradora = $api->obtener_imagen("Vendors", $trato->getFieldValue('Aseguradora')->getEntityId(), "public/img");

        require_once "views/tratos/descargar_auto.php";
    }

    public function reporte_auto($api)
    {
        $titulo = "Reporte Emisiones Auto";
        $ruta_csv = "public/tmp/" . $titulo . ".csv";

        if (!is_dir("public/tmp")) {
            mkdir("public/tmp", 0755, true);
        }

        $contenido_csv = array(
            array($_SESSION["usuario"]['empresa_nombre']),
            array($titulo),
            array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
            array("Vendedor:", $_SESSION["usuario"]['nombre']),
            array("")
        );

        $contenido_csv[] = array(
            "Emision",
            "Vigencia",
            "Póliza",
            "Nombre",
            "Apellido",
            "RNC/Cédula",
            "Marca",
            "Modelo",
            "Tipo",
            "Año",
            "Color",
            "Placa",
            "Condicion",
            "Chasis",
            "Valor",
            "Prima",
            "Aseguradora"
        );

        $prima_sumatoria = 0;
        $valor_sumatoria = 0;

        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $num_pagina = 1;

        do {
            $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 200);

            if (!empty($tratos)) {
                $num_pagina++;

                foreach ($tratos as $trato) {
                    if (
                        date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                        and
                        date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n")))  <= $_POST["hasta"]
                        and
                        $trato->getFieldValue("Type") == "Auto"
                    ) {

                        $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());

                        $cliente = $api->detalles_registro("Clientes", $trato->getFieldValue('Cliente')->getEntityId());

                        if (empty($_POST["aseguradora_id"])) {
                            $prima_sumatoria += $trato->getFieldValue('Prima_Total');
                            $valor_sumatoria += $trato->getFieldValue('Valor_Asegurado');

                            $contenido_csv[] = array(
                                date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))),
                                date("Y-m-d", strtotime($trato->getFieldValue("Closing_Date"))),
                                $trato->getFieldValue('P_liza')->getLookupLabel(),
                                $cliente->getFieldValue('Name'),
                                $cliente->getFieldValue('Apellido'),
                                $cliente->getFieldValue('RNC_C_dula'),
                                $bien->getFieldValue('Marca'),
                                $bien->getFieldValue('Modelo'),
                                $bien->getFieldValue('Tipo_de_veh_culo'),
                                $bien->getFieldValue('A_o'),
                                $bien->getFieldValue('Color'),
                                $bien->getFieldValue('Placa'),
                                $bien->getFieldValue('Condicion'),
                                $bien->getFieldValue('Chasis'),
                                number_format($trato->getFieldValue('Valor_Asegurado'), 2),
                                number_format($trato->getFieldValue('Prima_Total'), 2),
                                $trato->getFieldValue('Aseguradora')->getLookupLabel()
                            );
                        } elseif ($_POST["aseguradora_id"] == $trato->getFieldValue('Aseguradora')->getEntityId()) {
                            $prima_sumatoria += $trato->getFieldValue('Prima_Total');
                            $valor_sumatoria += $trato->getFieldValue('Valor_Asegurado');

                            $contenido_csv[] = array(
                                date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))),
                                date("Y-m-d", strtotime($trato->getFieldValue("Closing_Date	"))),
                                $trato->getFieldValue('P_liza')->getLookupLabel(),
                                $cliente->getFieldValue('Name'),
                                $cliente->getFieldValue('Apellido'),
                                $cliente->getFieldValue('RNC_C_dula'),
                                $bien->getFieldValue('Marca'),
                                $bien->getFieldValue('Modelo'),
                                $bien->getFieldValue('Tipo_de_veh_culo'),
                                $bien->getFieldValue('A_o'),
                                $bien->getFieldValue('Color'),
                                $bien->getFieldValue('Placa'),
                                $bien->getFieldValue('Condicion'),
                                $bien->getFieldValue('Chasis'),
                                number_format($trato->getFieldValue('Valor_Asegurado'), 2),
                                number_format($trato->getFieldValue('Prima_Total'), 2),
                                $trato->getFieldValue('Aseguradora')->getLookupLabel()
                            );
                        }
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);


        $contenido_csv[] = array("");
        $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2,));
        $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2));

        if ($valor_sumatoria > 0) {
            $fp = fopen($ruta_csv, 'w');
            foreach ($contenido_csv as $campos) {
                fputcsv($fp, $campos);
            }
            fclose($fp);
        }

        $fileName = basename($ruta_csv);
        if (!empty($fileName) and file_exists($ruta_csv)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($ruta_csv));
            readfile($ruta_csv);
            unlink($ruta_csv);
            exit;
        } else {
            return 'No se encontraton resultados.';
        }
    }
}
