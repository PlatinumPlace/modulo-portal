<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">adjuntar documentos</h1>
</div>

<?php if (isset($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<table class="table">

    <tbody>
        <?php
        foreach ($documentos_adjuntos as $documento) {
            echo "<tr>";
            echo "<td>" . $documento->getFileName() . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>

</table>

<br>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>adjuntar/<?= $id ?>/<?= $num_pagina - 1 ?>">Anterior</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>adjuntar/<?= $id ?>/<?= $num_pagina + 1 ?>">Siguente</a>
        </li>
    </ul>
</nav>

<form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>adjuntar/<?= $id ?>">

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
    | <a href="<?= constant("url") ?>detalles_<?= $tipo . "/" . $id ?>" class="btn btn-info">Cancelar</a>
</form>