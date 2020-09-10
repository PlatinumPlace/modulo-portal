<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">buscar pólizas</h1>
</div>

<form class="form-inline" method="post" action="<?= constant("url") ?>polizas/buscar">

    <div class="form-group mb-2">
        <select class="form-control" name="parametro" required>
            <option value="No_orden" selected>No.</option>
        </select>
    </div>

    <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="busqueda" required value="<?= (!empty($_POST['busqueda'])) ? $_POST['busqueda'] : "" ?>">
    </div>

    <button type="submit" class="btn btn-primary mb-2">Buscar</button>
    | <a href="<?= constant("url") ?>polizas/buscar" class="btn btn-info mb-2">Limpiar</a>

</form>

<table class="table">

    <thead class="thead-dark">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Póliza</th>
            <th scope="col">Cliente</th>
            <th scope="col">Plan</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($lista as $detalles) {
            echo "<tr>";
            echo "<td>" . $detalles->getFieldValue('No_orden') . "</td>";
            echo "<td>" . $detalles->getFieldValue('P_liza')->getLookupLabel() . "</td>";
            echo "<td>" . $detalles->getFieldValue('Cliente')->getLookupLabel() . "</td>";
            echo "<td>" . $detalles->getFieldValue('Deal_Name') . "</td>";
            echo "<td>";
            echo '<a href="' . constant("url") . "polizas/detalles?id=" . $detalles->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
            echo "&nbsp;";
            echo '<a href="' . constant("url") . "polizas/adjuntar?id=" . $detalles->getEntityId() . '" title="Adjuntar"><i class="fas fa-file-upload"></i></i></a>';
            echo "&nbsp;";
            echo '<a href="' . constant("url") . "polizas/descargar?id=" . $detalles->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>

</table>

<br>

<nav>
    <ul class="pagination justify-content-end">

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar?page=<?= ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar?page=<?= ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>