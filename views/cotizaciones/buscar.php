<?php
$num_pag = (isset($_GET["num"])) ? $_GET["num"] : 1;

if ($_POST) {
    $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
    $cantidad = 200;
} else {
    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
    $cantidad = 15;
}

$lista = listaPorCriterio("Deals", $criterio, $num_pag, $cantidad);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">buscar cotizaciones</h1>
</div>

<form class="form-inline" method="post" action="<?= constant("url") ?>cotizaciones/buscar">

    <div class="form-group mb-2">
        <select class="form-control" name="parametro" required>
            <option value="Nombre">Nombre del cliente</option>
            <option value="No">No. de orden</option>
        </select>
    </div>

    <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="busqueda" required value="<?= (!empty($_POST['busqueda'])) ? $_POST['busqueda'] : "" ?>">
    </div>

    <button type="submit" class="btn btn-primary mb-2">Buscar</button>
    | <a href="<?= constant("url") ?>cotizaciones/buscar" class="btn btn-info mb-2">Limpiar</a>

</form>

<table class="table">

    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Cliente</th>
            <th scope="col">Plan</th>
            <th scope="col">Suma Asegurada</th>
            <th scope="col">Estado</th>
            <th scope="col">Inicio</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($lista as $trato) {
            echo "<tr>";
            echo "<td>" . $trato->getFieldValue('No') . "</td>";
            echo "<td>" . $trato->getFieldValue('Nombre') . "</td>";
            echo "<td>" . $trato->getFieldValue('Plan') . "</td>";
            echo "<td>RD$" . number_format($trato->getFieldValue('Suma_asegurada'), 2) . "</td>";
            echo "<td>" . $trato->getFieldValue('Stage') . "</td>";
            echo "<td>" . $trato->getFieldValue('Fecha') . "</td>";
            echo "<td>";
            echo '<a href="' . constant("url") . 'cotizaciones/detalles?tipo=' . strtolower($trato->getFieldValue('Type')) . "&id=" . $trato->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
            echo "&nbsp;";
            echo '<a href="' . constant("url") . 'cotizaciones/emitir?tipo=' . strtolower($trato->getFieldValue('Type')) . "&id=" . $trato->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></a>';
            echo "&nbsp;";
            echo '<a href="' . constant("url") . 'cotizaciones/descargar?tipo=' . strtolower($trato->getFieldValue('Type')) . "&id=" . $trato->getEntityId() . '" title="Descargar"><i class="fas fa-download"></i></a>';
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
            <a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar?num=<?= ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar?num=<?= ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>