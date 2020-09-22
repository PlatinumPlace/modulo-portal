<?php
$api = new api;
$num_pag = (isset($_GET["num"])) ? $_GET["num"] : 1;
$filtro = (isset($_GET["filter"])) ? $_GET["filter"] : null;
$cantidad = (isset($_GET["filter"])) ? 200 : 15;

if ($_POST) {
    $criteria = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
    $cantidad = 200;
} else {
    $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
}

$tratos = $api->listaFiltrada("Deals", $criteria, $num_pag, $cantidad);
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

            default:
                echo " buscar cotizaciones";
                break;
        }
        ?>
</div>

<form class="form-inline" method="post" action="index.php?page=buscar">

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
    | <a href="index.php?page=buscar" class="btn btn-info mb-2">Limpiar</a>

</form>

<table class="table">

    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Cliente</th>
            <th scope="col">Plan</th>
            <th scope="col">Suma Asegurada</th>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        sort($tratos);
        foreach ($tratos as $trato) {
            if (
                empty($filtro)
                or
                ($filtro == "emisiones"
                    and
                    $trato->getFieldValue('Aseguradora') != null
                    and
                    date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date("Y-m"))
                or
                ($filtro == "vencimientos"
                    and
                    $trato->getFieldValue('Aseguradora') != null
                    and
                    date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date("Y-m"))
            ) {
                echo "<tr>";
                echo "<td>" . $trato->getFieldValue('No') . "</td>";
                echo "<td>" . $trato->getFieldValue('Nombre') . "</td>";
                echo "<td>" . $trato->getFieldValue('Plan') . "</td>";
                echo "<td>" . $trato->getFieldValue('Suma_asegurada') . "</td>";
                echo "<td>" . $trato->getFieldValue('Fecha_de_emisi_n') . "</td>";
                echo "<td>" . $trato->getFieldValue('Closing_Date') . "</td>";
                echo "<td>";
                echo '<a href="index.php?page=detalles' . $trato->getFieldValue('Type') . "&id=" . $trato->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                echo "&nbsp;";
                if (date("Y-m-d", strtotime($trato->getFieldValue("Closing_Date"))) > date('Y-m-d')) {
                    echo '<a href="index.php?page=emitir' . $trato->getFieldValue('Type') . "&id=" . $trato->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></i></a>';
                    echo "&nbsp;";
                    echo '<a href="index.php?page=descargar' . $trato->getFieldValue('Type') . "&id=" . $trato->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                    echo "&nbsp;";
                }
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
            <a class="page-link" href="index.php?page=buscar&num=<?= ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="index.php?page=buscar&num=<?= ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>