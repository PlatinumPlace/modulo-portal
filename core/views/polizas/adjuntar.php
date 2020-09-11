<?php
$polizas = new poliza();

$detalles = $polizas->detalles();
$num_pag = (isset($_GET["page"])) ? $_GET["page"] : 1;
$cliente = $polizas->detallesCliente($detalles->getFieldValue('Cliente')->getEntityId());
$adjuntos = $polizas->documentoAdjuntos("Deals", $_GET["id"]);

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

            $polizas->adjuntarTrato("$ruta/$name");
            unlink("$ruta/$name");
        }
    }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">adjuntar documentos</h1>
</div>

<?php if (isset($_GET["alert"])) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $_GET["alert"] ?>
    </div>
<?php endif ?>

<table class="table">

    <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($adjuntos as $adjunto) {
            echo "<tr>";
            echo "<td>" . $adjunto->getFileName() . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>

</table>

<br>
<nav>

    <ul class="pagination justify-content-end">

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") . "polizas/adjuntar?id=" . $_GET["id"] . "&page=" . ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") . "polizas/adjuntar?id=" . $_GET["id"] . "&page=" . ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>

</nav>

<form enctype="multipart/form-data" method="POST" action="<?= constant("url") . "polizas/adjuntar?id=" . $_GET["id"] ?>">

    <div class="form-group">
        <label>
            <b>
                Documentos <br> <small>(Manten presionado Ctrl para seleccionar varios archivos)</small>
            </b>
        </label>

        <input type="file" class="form-control-file" multiple name="documentos[]" required>
    </div>

    <br>
    <button type="submit" class="btn btn-success">Adjuntar</button>
    |
    <a href="<?= constant("url") . "polizas/detalles" . $detalles->getFieldValue("Type") . "?id=" . $_GET["id"] ?>" class="btn btn-info">Cancelar</a>

</form>

<?php if (empty($detalles)): ?>
    <script>
        var url = "<?= constant("url") ?>";
        window.location = url + "home/error";
    </script>
<?php endif; ?>

<?php if ($_FILES): ?>
    <script>
        var url = "<?= constant("url") ?>";
        var id = "<?= $_GET["id"] ?>";
        window.location = url + "polizas/adjuntar?id=" + id + "&alert=Documentos Adjuntados";
    </script>
<?php endif; ?>