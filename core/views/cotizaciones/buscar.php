<?php
$cotizaciones = new cotizacion();
$num_pag = (isset($_GET["page"])) ? $_GET["page"] : 1;

if ($_POST) {
    $lista = $cotizaciones->buscar($num_pag, 10, $_POST['parametro'], $_POST['busqueda']);
} else {
    $lista = $cotizaciones->lista($num_pag, 10);
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">buscar cotizaciones</h1>
</div>

<form class="form-inline" method="post" action="<?= constant("url") ?>cotizaciones/buscar">

    <div class="form-group mb-2">
        <select class="form-control" name="parametro" required>
            <option value="Quote_Number" selected>No. de cotización</option>
            <option value="RNC_C_dula">RNC/Cédula</option>
            <option value="Nombre">Cliente</option>
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
            <th scope="col">No. Cotización</th>
            <th scope="col">RNC/Cédula</th>
            <th scope="col">Cliente</th>
            <th scope="col">Plan</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($lista)) {
            foreach ($lista as $detalles) {
                echo "<tr>";
                echo "<td>" . $detalles->getFieldValue('Quote_Number') . "</td>";
                echo "<td>" . $detalles->getFieldValue('RNC_C_dula') . "</td>";
                echo "<td>" . $detalles->getFieldValue('Nombre') . "</td>";
                echo "<td>" . $detalles->getFieldValue('Subject') . "</td>";
                echo "<td>";

                switch ($detalles->getFieldValue("Plan")) {
                    case 'Full':
                        $tipo = "Auto";
                        break;

                    case 'Ley':
                        $tipo = "Auto";
                        break;

                    case 'Vida':
                        $tipo = "Vida";
                        break;
                }

                echo '<a href="' . constant("url") . "cotizaciones/detalles$tipo?id=" . $detalles->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                echo "&nbsp;";

                if ($detalles->getFieldValue("Deal_Name") == null) {
                    echo '<a href="' . constant("url") . "cotizaciones/emitir$tipo?id=" . $detalles->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></i></a>';
                    echo "&nbsp;";
                }

                echo '<a href="' . constant("url") . "cotizaciones/descargar$tipo?id=" . $detalles->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                echo "</td>";
                echo "</tr>";
            }
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