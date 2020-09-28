<?php
$url = explode("/", $_GET["url"]);
$num_pag = (isset($url[3])) ? $url[3] : 1;
$filtro = (isset($url[2])) ? $url[2] : null;
$criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
$lista = listaPorCriterio("Deals", $criteria, $num_pag, 200);
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
        }
        ?>
    </h1>
</div>

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
        foreach ($lista as $trato) {
            if (
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
                echo "<tr>";
                echo "<td>" . $trato->getFieldValue('No') . "</td>";
                echo "<td>" . $trato->getFieldValue('Nombre') . "</td>";
                echo "<td>" . $trato->getFieldValue('Plan') . "</td>";
                echo "<td>RD$" . number_format($trato->getFieldValue('Suma_asegurada'), 2) . "</td>";
                echo "<td>" . $trato->getFieldValue('Fecha') . "</td>";
                echo "<td>" . $trato->getFieldValue('Closing_Date') . "</td>";
                echo "<td>";
                echo '<a href="' . constant("url") . 'emisiones/detalles' . $trato->getFieldValue('Type') . "/" . $trato->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
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
            <a class="page-link" href="<?= constant("url") ?>emisiones/lista/<?= $filtro . "/" . ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>emisiones/lista/<?= $filtro . "/" . ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>