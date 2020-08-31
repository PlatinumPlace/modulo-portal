<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">
        <?php

        switch ($filtro) {
            case 'emisiones_mensuales':
                echo "emisiones del mes";
                break;

            case 'vencimientos_mensuales':
                echo "vencimientos del mes";
                break;

            default:
                echo "buscar cotizaciones";
                break;
        }
        ?>
    </h1>
</div>

<form class="form-inline" method="post" action="<?= constant("url") ?>?page=buscar&filter=<?= $filtro ?>">

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
    | <a href="<?= constant("url") ?>?page=buscar&filter=all" class="btn btn-info mb-2">Limpiar</a>

</form>

<table class="table">

    <thead class="thead-dark">
        <tr>
            <th scope="col">No. Cotización</th>
            <th scope="col">Fecha Emisión</th>
            <th scope="col">RNC/Cédula</th>
            <th scope="col">Cliente</th>
            <th scope="col">Plan</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($lista_cotizaciones as $cotizacion) {
            if (
                empty($filtro) or $filtro == "all"
                or
                ($filtro == "emisiones_mensuales"
                    and
                    $cotizacion->getFieldValue("Deal_Name") != null
                    and
                    date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date("Y-m"))
                or
                ($filtro == "vencimientos_mensuales"
                    and
                    $cotizacion->getFieldValue("Deal_Name") != null
                    and
                    date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date("Y-m"))
            ) {
                echo "<tr>";
                echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                echo "<td>" . date("d-m-Y", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</td>";
                echo "<td>" . $cotizacion->getFieldValue('RNC_C_dula') . "</td>";
                echo "<td>" . $cotizacion->getFieldValue('Nombre') . "</td>";
                echo "<td>" . $cotizacion->getFieldValue('Subject') . "</td>";
                echo "<td>";
                echo '<a href="' . constant("url") . "?page=detalles&id=" . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                echo "&nbsp;";

                if ($cotizacion->getFieldValue("Deal_Name") == null) {
                    echo '<a href="' . constant("url") . "?page=emitir&id=" . $cotizacion->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></i></a>';
                } else {
                    echo '<a href="' . constant("url") . "?page=adjuntar&id=" . $cotizacion->getEntityId() . '" title="Adjuntar"><i class="fas fa-file-upload"></i></i></a>';
                }

                echo "&nbsp;";
                echo '<a href="' . constant("url") . "?page=descargar&id=" . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
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
            <a class="page-link" href="<?= constant("url") ?>?page=buscar&filter=<?= $filtro . "&num=" . ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>?page=buscar&filter=<?= $filtro . "&num=" . ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>