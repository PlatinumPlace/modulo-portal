<?php
$num_pag = (isset($_GET["num"])) ? $_GET["num"] : 1;
$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$trato = detalles("Deals", $id);

if (empty($trato)) {
    require_once "views/portal/error.php";
    exit();
}

if ($trato->getFieldValue("P_liza") == null) {
    header("Location:" . constant("url") . "cotizaciones/detalles?tipo=auto&id=$id");
    exit();
}

$adjuntos = listaAdjuntos("Deals", $id, $num_pag, 10);

if ($_FILES) {
    $ruta = "public/path";

    foreach ($_FILES["documentos"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
            $name = basename($_FILES["documentos"]["name"][$key]);
            move_uploaded_file($tmp_name, "$ruta/$name");
            adjuntar("Deals", $id, "$ruta/$name");
            unlink("$ruta/$name");
        }
    }

    header("Location:" . constant("url") . "emisiones/adjuntar?id=$id");
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">adjuntar documentos</h1>
</div>

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
            <a class="page-link" href="<?= constant("url") ?>emisiones/adjuntar?id=<?= $id . "&num=" . ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>emisiones/adjuntar?id=<?= $id . "&num=" . ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>

<form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>emisiones/adjuntar?id=<?= $id ?>">

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
    <a href="<?= constant("url") ?>emisiones/detalles?tipo=<?= strtolower($trato->getFieldValue("Type")) . "&id=" . $id ?>" class="btn btn-info">Cancelar</a>

</form>

<br><br>