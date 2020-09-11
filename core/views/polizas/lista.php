<?php
$polizas = new poliza();
$num_pag = (isset($_GET["page"])) ? $_GET["page"] : 1;
$filtro = (isset($_GET["filtro"])) ? $_GET["filtro"] : null;
$lista = $polizas->lista($num_pag, 200);
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
            <th scope="col">Póliza</th>
            <th scope="col">Cliente</th>
            <th scope="col">Plan</th>
            <th scope="col">Aseguradora</th>
            <th scope="col">Fin</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($lista as $detalles) {
            if (
                    empty($filtro)
                    or
                    ($filtro == "emisiones"
                    and
                    date("Y-m", strtotime($detalles->getFieldValue("Fecha_de_emisi_n"))) == date("Y-m"))
                    or
                    ($filtro == "vencimientos"
                    and
                    date("Y-m", strtotime($detalles->getFieldValue("Closing_Date"))) == date("Y-m"))
            ) {
                echo "<tr>";
                echo "<td>" . $detalles->getFieldValue('P_liza')->getLookupLabel() . "</td>";
                echo "<td>" . $detalles->getFieldValue('Cliente')->getLookupLabel() . "</td>";
                echo "<td>" . $detalles->getFieldValue('Deal_Name') . "</td>";
                echo "<td>" . $detalles->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";
                echo "<td>" . $detalles->getFieldValue('Closing_Date') . "</td>";
                echo "<td>";
                echo '<a href="' . constant("url") . "polizas/detalles" . $detalles->getFieldValue("Type") . "?id=" . $detalles->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                echo "&nbsp;";
                echo '<a href="' . constant("url") . "polizas/adjuntar?id=" . $detalles->getEntityId() . '" title="Adjuntar"><i class="fas fa-file-upload"></i></i></a>';
                echo "&nbsp;";
                echo '<a href="' . constant("url") . "polizas/descargar" . $detalles->getFieldValue("Type") . "?id=" . $detalles->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
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
            <a class="page-link" href="<?= constant("url") ?>polizas/buscar?page=<?= ($num_pag - 1) ?>">Anterior</a>
        </li>

        <li class="page-item">
            <a class="page-link" href="<?= constant("url") ?>polizas/buscar?page=<?= ($num_pag + 1) ?>">Siguente</a>
        </li>

    </ul>
</nav>