<?php

class home
{
    public function verificar_token()
    {
        if (!file_exists("php_sdk/zcrm_oauthtokens.txt") or filesize("php_sdk/zcrm_oauthtokens.txt") == 0) {
            require_once 'php_sdk/token.php';
            exit();
        }
    }

    public function verificar_sesion()
    {
        if (!isset($_SESSION["usuario"])) {
            require_once "controllers/contactos.php";
            $contactos = new contactos;
            $contactos->iniciar_sesion();
            exit();
        } else {
            if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
                session_destroy();
                header("Location:" . constant("url"));
                exit();
            }
        }
        $_SESSION["usuario"]["tiempo_activo"] = time();
    }

    public function obtener_url()
    {
        $url = rtrim($_GET['url'], "/");
        $url =  explode('/', $url);
        $resultado = array();
        $cont = 0;
        foreach ($url as $posicion => $valor) {
            if ($posicion > 1) {
                $resultado[$cont] = $valor;
                $cont++;
            }
        }
        return $resultado;
    }

    public function buscar_pagina()
    {
        if (isset($_GET['url'])) {

            $url = rtrim($_GET['url'], "/");
            $url = explode('/', $url);

            if (isset($url[0]) and isset($url[1])) {
                $ubicacion_archivo = "controllers/" . $url[0] . ".php";
                if (file_exists($ubicacion_archivo)) {
                    require_once $ubicacion_archivo;
                    $controlador = new $url[0];

                    if (method_exists($controlador, $url[1])) {
                        $controlador->{$url[1]}();
                    } else {
                        $this->error();
                        exit();
                    }
                } else {
                    $this->error();
                    exit();
                }
            } else {
                $this->error();
                exit();
            }
        } else {
            $this->index();
            exit();
        }
    }

    public function error()
    {
        require_once "views/error.php";
    }

    public function index()
    {
        $api = new api;

        $cotizaciones_total = 0;
        $cotizaciones_pendientes = 0;
        $tratos_emitidos = 0;
        $tratos_venciendo = 0;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

        $num_pagina = 1;
        do {
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 200);
            if (!empty($cotizaciones)) {
                $num_pagina++;

                foreach ($cotizaciones as $cotizacion) {
                    $cotizaciones_total += 1;

                    if (
                        date('Y-m') >= date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))
                        and
                        date('Y-m') <= date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till")))
                        and
                        $cotizacion->getFieldValue("Deal_Name") == null
                    ) {
                        $cotizaciones_pendientes += 1;
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);


        $num_pagina = 1;
        do {
            $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 200);
            if (!empty($tratos)) {
                $num_pagina++;

                foreach ($tratos as $trato) {
                    if ($trato->getFieldValue('Stage') != "Cotizando") {
                        if (date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                            $tratos_emitidos += 1;
                            $aseguradoras[] = $trato->getFieldValue('Aseguradora')->getLookupLabel();
                        }

                        if (date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                            $tratos_venciendo += 1;
                        }
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);

        require_once "views/layout/header_main.php";
        require_once "views/index.php";
        require_once "views/layout/footer_main.php";
    }
}
