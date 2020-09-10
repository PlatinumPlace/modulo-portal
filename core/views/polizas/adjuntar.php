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
            <a class="page-link" href="<?= constant("url")  . "polizas/adjuntar?id=" . $_GET["id"] . "&page=" . ($num_pag - 1) ?>">Anterior</a>
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
    <a href="<?= constant("url") . "polizas/detalles?id=" . $_GET["id"] ?>" class="btn btn-info">Cancelar</a>

</form>