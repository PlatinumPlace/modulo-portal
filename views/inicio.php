<?php
$api = new api;
$criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
$num_pag = 1;
$total = 0;
$emisiones = 0;
$vencimientos = 0;
$pendientes = 0;
$aseguradoras = array();

do {
    $tratos = $api->searchRecordsByCriteria("Deals", $criterio, $num_pag);
    if (!empty($tratos)) {

        $num_pag++;
        
        foreach ($tratos as $trato) {
            $total++;

            if ($trato->getFieldValue("P_liza") != null) {
                if (date("Y-m", strtotime($trato->getFieldValue("Fecha"))) == date('Y-m')) {
                    $emisiones++;
                    $aseguradoras[] = $trato->getFieldValue('Aseguradora')->getLookupLabel();
                }

                if (date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                    $vencimientos++;
                }
            }

            if (
                $trato->getFieldValue("P_liza") == null
                and
                date("Y-m", strtotime($trato->getFieldValue("Fecha"))) == date('Y-m')
            ) {
                $pendientes++;
            }
        }
    } else {
        $num_pag = 0;
    }
} while ($num_pag > 1);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">panel de control</h1>
</div>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>

    <p>Desde su panel de control podrás ver la infomación necesaria para manejar sus pólizas y cotizaciones.</p>
</div>

<div class="card-deck">

    <div class="card text-white bg-primary mb-5" style="max-width: 18rem;">
        <div class="card-header">Cotizaciones Totales</div>

        <div class="card-body">
            <h5 class="card-title"><?= $total ?></h5>

            <a href="?pagina=buscar" class="stretched-link"> </a>
        </div>
    </div>

    <div class="card text-white bg-info mb-5" style="max-width: 18rem;">
        <div class="card-header">Cotizaciones Pendientes</div>

        <div class="card-body">
            <h5 class="card-title"><?= $pendientes ?></h5>

            <a href="?pagina=buscar&filtro=pendientes" class="stretched-link"></a>
        </div>
    </div>

    <div class="card text-white bg-success mb-5" style="max-width: 18rem;">
        <div class="card-header">Emisiones del Mes</div>

        <div class="card-body">
            <h5 class="card-title"><?= $emisiones ?></h5>

            <a href="?pagina=buscar&filtro=emisiones" class="stretched-link"></a>
        </div>
    </div>

    <div class="card text-white bg-danger mb-5" style="max-width: 18rem;">
        <div class="card-header">Vencimientos del Mes</div>

        <div class="card-body">
            <h5 class="card-title"><?= $vencimientos ?></h5>

            <a href="?pagina=buscar&filtro=vencimientos" class="stretched-link"></a>
        </div>
    </div>

</div>

<?php if (!empty($aseguradoras)) : ?>
    <h4>Pólizas emitidas este mes</h4>
    <table class="table">

        <thead class="thead-dark">
            <tr>
                <th scope="col">Aseguradora</th>
                <th scope="col">Cantidad</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $aseguradoras = array_count_values($aseguradoras);
            foreach ($aseguradoras as $nombre => $cantidad) {
                echo "<tr>";
                echo "<td>$nombre</td>";
                echo "<td>$cantidad</td>";
                echo "</tr>";
            }
            ?>
        </tbody>

    </table>
<?php endif ?>