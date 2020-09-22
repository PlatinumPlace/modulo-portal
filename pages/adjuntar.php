<?php
$api = new api;
$detalles = $api->detalles("Deals", $_GET["id"]);
$num_pag = (isset($_GET["num"])) ? $_GET["num"] : 1;

if (empty($detalles)) {
    require_once "error.php";
    exit();
}

$adjuntos = $api->listaAdjuntos("Deals", $_GET["id"]);

if ($_FILES) {
    $ruta = "public/path";

    foreach ($_FILES["documentos"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
            $name = basename($_FILES["documentos"]["name"][$key]);
            move_uploaded_file($tmp_name, "$ruta/$name");
            $api->adjuntar("Deals", $_GET["id"], "$ruta/$name");
            unlink("$ruta/$name");
        }
    }

    header("Location:index.php?page=adjuntar&id=" . $_GET["id"]."&alert=Documentos Adjuntados");
    exit();
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
            <a class="page-link" href="<?= 'index.php?page=adjuntar&id=' . $_GET["id"] . "&num=" . ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= 'index.php?page=adjuntar&id=' . $_GET["id"] . "&num=" . ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>

</nav>

<form enctype="multipart/form-data" method="POST" action="<?= 'index.php?page=adjuntar&id=' . $_GET["id"] ?>">

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
    <a href="<?= 'index.php?page=detalles' . $detalles->getFieldValue("Type") . '&id=' . $_GET["id"] ?>" class="btn btn-info">Cancelar</a>

</form>