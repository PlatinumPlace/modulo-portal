<?php

class router
{
    function iniciar_sesion()
    {
        if ($_POST) {
            validar_usuario();

            if (isset($_SESSION["usuario"])) {
                header("Location:" . constant("url"));
                exit();
            } else {
                $alerta = "Usuario o contraseña incorrectos";
            }
        }

        require_once 'pages/layout/header.php';
        require_once 'pages/usuarios/index.php';
        require_once 'pages/layout/footer.php';
    }

    function cerrar_sesion()
    {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }

    function inicio()
    {
        $resumen = resumen_cotizaciones();
        require_once 'pages/layout/header.php';
        require_once 'pages/layout/sub_header.php';
        require_once 'pages/cotizaciones/index.php';
        require_once 'pages/layout/sub_footer.php';
        require_once 'pages/layout/footer.php';
    }

    function error()
    {
        require_once 'pages/layout/header.php';
        require_once 'pages/error.php';
        require_once 'pages/layout/footer.php';
    }

    function buscar()
    {
        $filtro = (isset($_GET["filter"])) ? $_GET["filter"] : "all";
        $num_pag = (isset($_GET["num"])) ? $_GET["num"] : 1;
        $lista_cotizaciones = buscar_cotizacion($num_pag);
        require_once 'pages/layout/header.php';
        require_once 'pages/layout/sub_header.php';
        require_once 'pages/cotizaciones/buscar.php';
        require_once 'pages/layout/sub_footer.php';
        require_once 'pages/layout/footer.php';
    }

    function reportes()
    {
        $alerta = (isset($_GET["alert"])) ? $_GET["alert"] : null;
        $aseguradoras = lista_aseguradoras();

        if (isset($_POST["csv"])) {
            exportar_cotizaciones_csv();
        }
        require_once 'pages/layout/header.php';
        require_once 'pages/layout/sub_header.php';
        require_once 'pages/cotizaciones/reportes.php';
        require_once 'pages/layout/sub_footer.php';
        require_once 'pages/layout/footer.php';
    }

    function crear()
    {
        $tipo = (isset($_GET["type"])) ? $_GET["type"] : null;
        $contratos = filtro_contratos();

        switch ($tipo) {
            case 'auto':
                $lista_marcas = lista_registros("Marcas");

                if ($_POST) {
                    crear_cotizacion_auto();
                }
                break;

            case 'vida':
                if ($_POST) {
                    crear_cotizacion_vida();
                }
                break;
        }

        require_once 'pages/layout/header.php';
        require_once 'pages/layout/sub_header.php';

        if (!empty($tipo)) {
            require_once "pages/cotizaciones/$tipo/crear.php";
        } else {
            require_once 'pages/cotizaciones/crear.php';
        }

        require_once 'pages/layout/sub_footer.php';
        require_once 'pages/layout/footer.php';
    }

    function detalles()
    {
        $id = (isset($_GET["id"])) ? $_GET["id"] : null;
        $alerta = (isset($_GET["alert"])) ? $_GET["alert"] : null;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            $alerta = "Cotización Vencida.";
        }

        if (isset($_GET["contract_id"]) and isset($_GET["attachment_id"])) {
            descargar_adjunto_contrato();
        }

        require_once 'pages/layout/header.php';
        require_once 'pages/layout/sub_header.php';

        switch ($cotizacion->getFieldValue("Plan")) {
            case 'Full':
                require_once 'pages/cotizaciones/auto/detalles.php';
                break;

            case 'Ley':
                require_once 'pages/cotizaciones/auto/detalles.php';
                break;

            case 'Vida':
                require_once 'pages/cotizaciones/vida/detalles.php';
                break;
        }

        require_once 'pages/layout/sub_footer.php';
        require_once 'pages/layout/footer.php';
    }

    function descargar()
    {
        $id = (isset($_GET["id"])) ? $_GET["id"] : null;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            $alerta = "Cotización Vencida.";
        }

        if ($cotizacion->getFieldValue("Deal_Name") != null) {
            $imagen_aseguradora = obtener_imagen_registro("Vendors", $cotizacion->getFieldValue("Aseguradora")->getEntityId());

            switch ($cotizacion->getFieldValue("Plan")) {
                case 'Full':
                    $trato = detalles_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                    $cliente = detalles_registro("Contacts", $trato->getFieldValue("Contact_Name")->getEntityId());
                    $bien = detalles_registro("Bienes", $trato->getFieldValue("Bien")->getEntityId());
                    $coberturas = detalles_registro("Contratos", $trato->getFieldValue("Contrato")->getEntityId());
                    $aseguradora = detalles_registro("Vendors", $cotizacion->getFieldValue("Aseguradora")->getEntityId());
                    break;

                case 'Ley':
                    $trato = detalles_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                    $cliente = detalles_registro("Contacts", $trato->getFieldValue("Contact_Name")->getEntityId());
                    $bien = detalles_registro("Bienes", $trato->getFieldValue("Bien")->getEntityId());
                    $coberturas = detalles_registro("Contratos", $trato->getFieldValue("Contrato")->getEntityId());
                    $aseguradora = detalles_registro("Vendors", $cotizacion->getFieldValue("Aseguradora")->getEntityId());
                    break;
            }
        }

        require_once 'pages/layout/header.php';

        switch ($cotizacion->getFieldValue("Plan")) {
            case 'Full':
                if ($cotizacion->getFieldValue("Deal_Name") == null) {
                    require_once "pages/cotizaciones/auto/descargar_cotizando.php";
                } else {
                    require_once "pages/cotizaciones/auto/descargar_emitido.php";
                }
                break;

            case 'Ley':
                if ($cotizacion->getFieldValue("Deal_Name") == null) {
                    require_once "pages/cotizaciones/auto/descargar_cotizando.php";
                } else {
                    require_once "pages/cotizaciones/auto/descargar_emitido.php";
                }
                break;

            case 'Vida':
                require_once 'pages/cotizaciones/vida/descargar.php';
                break;
        }

        require_once 'pages/layout/footer.php';
    }

    function emitir()
    {
        $id = (isset($_GET["id"])) ? $_GET["id"] : null;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (
            date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))
            or
            $cotizacion->getFieldValue("Deal_Name") != null
        ) {
            header("Location:" . constant("url") . "?page=detalles_auto&id=" . $id);
            exit();
        }

        if ($_POST) {
            $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
            $permitido = array("pdf");

            if (!in_array($extension, $permitido)) {
                $alerta = "Para emitir solo se admiten documentos PDF";
            } else {

                switch ($cotizacion->getFieldValue("Plan")) {
                    case 'Full':
                        emitir_cotizacion_auto($cotizacion);
                        break;

                    case 'Ley':
                        emitir_cotizacion_auto($cotizacion);
                        break;

                    case 'Vida':
                        emitir_cotizacion_vida($cotizacion);
                        break;
                }
            }
        }
        require_once 'pages/layout/header.php';
        require_once 'pages/layout/sub_header.php';

        switch ($cotizacion->getFieldValue("Plan")) {
            case 'Full':
                require_once 'pages/cotizaciones/auto/emitir.php';
                break;

            case 'Ley':
                require_once 'pages/cotizaciones/auto/emitir.php';
                break;

            case 'Vida':
                require_once 'pages/cotizaciones/vida/emitir.php';
                break;
        }

        require_once 'pages/layout/sub_footer.php';
        require_once 'pages/layout/footer.php';
    }

    function adjuntar()
    {
        $id = (isset($_GET["id"])) ? $_GET["id"] : null;
        $alerta = (isset($_GET["alert"])) ? $_GET["alert"] : null;
        $cotizacion = detalles_registro("Quotes", $id);
        $num_pag = (isset($_GET["num"])) ? $_GET["num"] : 1;

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        switch ($cotizacion->getFieldValue('Plan')) {
            case 'Full':
                $tipo = "auto";
                break;

            case 'Ley':
                $tipo = "auto";
                break;
        }

        if ($cotizacion->getFieldValue("Deal_Name") == null) {
            header("Location:" . constant("url") . "?page=detalles_$tipo/$id");
            exit();
        }

        $documentos_adjuntos = lista_adjuntos("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());

        if ($_FILES) {
            adjuntar_trato($cotizacion);
        }
        require_once 'pages/layout/header.php';
        require_once 'pages/layout/sub_header.php';
        require_once 'pages/cotizaciones/adjuntar.php';
        require_once 'pages/layout/sub_footer.php';
        require_once 'pages/layout/footer.php';
    }
}
