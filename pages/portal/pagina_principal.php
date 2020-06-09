<?php

$portal = new portal;
$resultado = $portal->resumen();
if (isset($resultado["aseguradoras"])) {
    $aseguradoras =  array_count_values($resultado["aseguradoras"]);
}

?>
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
    <p>Desde su panel de control podrá ver la infomación necesaria manejar sus pólizas y cotizaciones.</p>
</div>

<div class="card-deck">

    <div class="card">
        <div class="card-header text-white bg-primary">
            <h1><?= $resultado["total"] ?></h1>
            <br>
            <h5>Cotizaciones <br> Totales</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant("url") ?>cotizaciones/buscar" class="card-link">Ver más</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-success">
            <h1><?= $resultado["pendientes"] ?></h1>
            <br>
            <h5>Cotizaciones <br> al Mes</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant("url") ?>cotizaciones/lista/pendientes" class="card-link">Ver más</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-info">
            <h1><?= $resultado["emisiones"] ?></h1>
            <br>
            <h5>Emisiones <br> al Mes</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant("url") ?>cotizaciones/lista/emisiones_mensuales" class="card-link">Ver más</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-warning">
            <h1><?= $resultado["vencimientos"] ?></h1>
            <br>
            <h5>Vencimientos <br> al Mes</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant("url") ?>cotizaciones/lista/vencimientos_mensuales" class="card-link">Ver más</a>
        </div>
    </div>

</div>

<br>
<?php if (!empty($aseguradoras)) : ?>
    <div class="card">
        <h5 class="card-header">Cantidad de pólizas emitidas este mes</h5>
        <div class="card-body">
            <table class="table table-striped table-borderless">
                <tbody>
                    <?php foreach ($aseguradoras as $nombre => $cantidad_polizas) : ?>
                        <tr>
                            <th scope="row"><?= $nombre ?></th>
                            <td><?= $cantidad_polizas ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>