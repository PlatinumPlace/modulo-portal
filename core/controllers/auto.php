<?php

class auto
{
    public function crear()
    {
        $cotizacion = new cotizacion;
        $marcas = $cotizacion->listaMarcas();

        if ($_POST) {
            $id = $cotizacion->crearAuto();
            header("Location:" . constant("url") . "auto/detalles?id=" . $id);
            exit();
        }

        require_once "core/views/layout/header.php";
        require_once "core/views/auto/crear.php";
        require_once "core/views/layout/footer.php";
    }

    public function detalles()
    {
        $cotizacion = new cotizacion;
        $detalles = $cotizacion->detalles();

        if (empty($detalles)) {
            require_once "error.php";
            exit();
        }

        if ($detalles->getFieldValue("Deal_Name") != null) {
            header("Location:" . constant("url") . "polizas/detalles?id=" . $detalles->getFieldValue("Deal_Name")->getEntityId());
            exit();
        }

        if (isset($_GET["contract_id"]) and isset($_GET["attachment_id"])) {
            $cotizacion->descargarAdjuntoContrato();
        }

        require_once "core/views/layout/header.php";
        require_once "core/views/auto/detalles.php";
        require_once "core/views/layout/footer.php";
    }

    public function descargar()
    {
        $cotizacion = new cotizacion;
        $detalles = $cotizacion->detalles();

        if (empty($detalles)) {
            require_once "error.php";
            exit();
        }

        require_once "core/views/auto/descargar.php";
    }

    public function emitir()
    {
        $cotizacion = new cotizacion;
        $detalles = $cotizacion->detalles();

        if (empty($detalles)) {
            require_once "error.php";
            exit();
        }

        if ($detalles->getFieldValue("Deal_Name") != null) {
            header("Location:" . constant("url") . "polizas/detalles?id=" . $detalles->getFieldValue("Deal_Name")->getEntityId());
            exit();
        }

        if ($_POST) {
            $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
            $permitido = array("pdf");

            if (!in_array($extension, $permitido)) {
                header("Location:" . constant("url") . "auto/emitir?id=" . $_GET["id"] . "&alert=Para emitir solo se admiten documentos PDF");
                exit();
            } else {
                $id = $cotizacion->emitirAuto($detalles);
                header("Location:" . constant("url") . "polizas/detalles?id=$id&alert=Cotizacion emitida exitosamente");
                exit();
            }
        }

        require_once "core/views/layout/header.php";
        require_once "core/views/auto/emitir.php";
        require_once "core/views/layout/footer.php";
    }
}
