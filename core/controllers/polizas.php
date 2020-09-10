<?php

class polizas
{
    public function lista()
    {
        $trato = new trato;
        $num_pag = (isset($_GET["page"])) ? $_GET["page"] : 1;
        $filtro = (isset($_GET["filtro"])) ? $_GET["filtro"] : null;
        $lista = $trato->lista($num_pag, 200);

        require_once "core/views/layout/header.php";
        require_once "core/views/polizas/lista.php";
        require_once "core/views/layout/footer.php";
    }

    public function detalles()
    {
        $trato = new trato;
        $detalles = $trato->detalles();

        if (empty($detalles)) {
            require_once "error.php";
            exit();
        }

        $cliente = $trato->detallesCliente($detalles->getFieldValue('Cliente')->getEntityId());
        $adjuntos = $trato->documentoAdjuntos("Contratos", $detalles->getFieldValue('Contrato')->getEntityId());

        if (isset($_GET["attachment_id"])) {
            $trato->descargarAdjuntoContrato($detalles->getFieldValue('Contrato')->getEntityId());
        }

        require_once "core/views/layout/header.php";

        if ($detalles->getFieldValue("Type") == "Auto") {
            $bien = $trato->detallesBien($detalles->getFieldValue('Bien')->getEntityId());
            require_once "core/views/polizas/detalles_auto.php";
        }

        require_once "core/views/layout/footer.php";
    }

    public function descargar()
    {
        $trato = new trato;
        $detalles = $trato->detalles();

        if (empty($detalles)) {
            require_once "error.php";
            exit();
        }

        $imagen_aseguradora = $trato->imagenAseguradora($detalles->getFieldValue('Aseguradora')->getEntityId());
        $cliente = $trato->detallesCliente($detalles->getFieldValue('Cliente')->getEntityId());

        if ($detalles->getFieldValue("Type") == "Auto") {
            $bien = $trato->detallesBien($detalles->getFieldValue('Bien')->getEntityId());
            $aseguradora = $trato->detallesAseguradora($detalles->getFieldValue('Aseguradora')->getEntityId());
            $coberturas = $trato->coberturas($detalles->getFieldValue('Contrato')->getEntityId());

            require_once "core/views/polizas/descargar_auto.php";
        }
    }

    public function adjuntar()
    {
        $trato = new trato;
        $num_pag = (isset($_GET["page"])) ? $_GET["page"] : 1;
        $detalles = $trato->detalles();
        $adjuntos = $trato->documentoAdjuntos("Deals", $_GET["id"]);

        if ($_FILES) {
            $ruta = "public/path";
            if (!is_dir($ruta)) {
                mkdir($ruta, 0755, true);
            }

            foreach ($_FILES["documentos"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                    $name = basename($_FILES["documentos"]["name"][$key]);
                    move_uploaded_file($tmp_name, "$ruta/$name");
                    $trato->adjuntar("Deals", $_GET["id"], "$ruta/$name");
                    unlink("$ruta/$name");
                }
            }

            header("Location:" . constant('url') . "polizas/adjuntar?id=" . $_GET["id"]. "&alert=Documentos Adjuntados");
            exit();
        }

        require_once "core/views/layout/header.php";
        require_once "core/views/polizas/adjuntar.php";
        require_once "core/views/layout/footer.php";
    }
}
