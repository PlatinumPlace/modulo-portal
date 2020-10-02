<?php
$tratos = new tratos;
$num_pag = (isset($_GET["num"])) ? $_GET["num"] : 1;
$filtro = (isset($_GET["filtro"])) ? $_GET["filtro"] : null;

if ($_POST) {
    $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
    $cantidad = 200;
} else {
    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
    $cantidad = 15;
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">
        <?php
        switch ($filtro) {
            case 'emisiones':
                echo "emisiones del mes";
                break;

            case 'vencimientos':
                echo "vencimientos del mes";
                break;

            case 'pendientes':
                echo "pendientes del mes";
                break;

            default:
                echo "buscar cotizaciones";
                break;
        }
        ?>
    </h1>
</div>

<form class="form-inline" method="post" action="?pagina=buscar">

    <div class="form-group mb-2">
        <select class="form-control" name="parametro" required>
            <option value="Deal_Name">Nombre del cliente</option>
            <option value="No">No. de cotización</option>
        </select>
    </div>

    <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="busqueda" required value="<?= (!empty($_POST['busqueda'])) ? $_POST['busqueda'] : "" ?>">
    </div>

    <button type="submit" class="btn btn-primary mb-2">Buscar</button>
    | <a href="?pagina=buscar" class="btn btn-info mb-2">Limpiar</a>

</form>

<table class="table">

    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Cliente</th>
            <th scope="col">Plan</th>
            <th scope="col">Suma Asegurada</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $lista = $tratos->searchRecordsByCriteria("Deals", $criterio, $num_pag, $cantidad);
        foreach ($lista as $trato) {
            if (
                empty($filtro)
                or
                ($filtro == "pendientes"
                    and
                    $trato->getFieldValue('P_liza') == null
                    and
                    date("Y-m", strtotime($trato->getFieldValue("Fecha"))) == date("Y-m"))
                or
                ($filtro == "emisiones"
                    and
                    $trato->getFieldValue('P_liza') != null
                    and
                    date("Y-m", strtotime($trato->getFieldValue("Fecha"))) == date("Y-m"))
                or
                ($filtro == "vencimientos"
                    and
                    $trato->getFieldValue('P_liza') != null
                    and
                    date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date("Y-m"))
            ) {
                if ($trato->getFieldValue("P_liza") == null) {
                    $tipo = "_1";
                } else {
                    $tipo = "_2";
                }

                echo "<tr>";
                echo "<td>" . $trato->getFieldValue('No') . "</td>";
                echo "<td>" . $trato->getFieldValue('Deal_Name') . "</td>";
                echo "<td>" . $trato->getFieldValue('Plan') . "</td>";
                echo "<td>RD$" . number_format($trato->getFieldValue('Suma_asegurada'), 2) . "</td>";
                echo "<td>" . $trato->getFieldValue('Stage') . "</td>";
                echo "<td>" . $trato->getFieldValue('Fecha') . "</td>";
                echo "<td>";
                echo '<a href="?pagina=detalles' . $trato->getFieldValue('Type') . $tipo . '&id=' . $trato->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                echo "&nbsp;";

                if ($trato->getFieldValue("P_liza") == null) {
                    echo '<a href="?pagina=emitir' . $trato->getFieldValue('Type')  . '&id=' . $trato->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></a>';
                } else {
                    echo '<a href="?pagina=adjuntar&id=' . $trato->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></a>';
                }

                echo "&nbsp;";
                echo '<a href="?pagina=descargar' . $trato->getFieldValue('Type')  . $tipo . '&id=' . $trato->getEntityId() . '" title="Descargar"><i class="fas fa-download"></i></a>';
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
            <a class="page-link" href="?pagina=buscar&filtro=<?= $filtro . "&num=" . ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="?pagina=buscar&filtro=<?= $filtro . "&num=" . ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>