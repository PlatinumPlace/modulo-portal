<?php
$cotizaciones = new cotizaciones();
$url = obtener_url();
$filtro = (isset($url[1])) ? $url[1] : "todos";
$num_pagina = (isset($url[2])) ? $url[2] : 1;
require_once 'views/layout/header.php';
?>
<h1 class="mt-4 text-uppercase text-center">
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

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>buscar">Cotizaciones</a></li>
</ol>

<div class="card mb-4 col-xl-8">
    <div class="card-body">
        <form class="form-inline" method="post" action="<?= constant("url") ?>buscar">

            <div class="form-group mb-2 mr-sm-2">
                <select class="form-control" name="parametro" required>
                    <option value="Quote_Number" selected>No. de cotización</option>
                    <option value="Nombre">Deudor</option>
                    <option value="RNC_C_dula">RNC/Cédula</option>
                </select>
            </div>

            <div class="form-group mb-2 mr-sm-2">
                <input type="text" class="form-control" name="busqueda" required>
            </div>

            <div class="form-group mb-2 mr-sm-2">
                <button type="submit" class="btn btn-primary">Buscar</button>
                | <a href="<?= constant("url") ?>buscar/<?= $filtro ?>" class="btn btn-info">Limpiar</a>
            </div>

        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. Cotización</th>
                        <th>Fecha Emision</th>
                        <th>RNC/Cédula</th>
                        <th>Deudor</th>
                        <th>Suma Asegurada</th>
                        <th>Plan</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $cotizaciones->buscar($filtro, $num_pagina) ?>
                </tbody>
            </table>
        </div>

        <br>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item"><a class="page-link" href="<?= constant("url") ?>buscar/<?= $filtro . "/" . ($num_pagina - 1) ?>">Anterior</a>
                </li>
                <li class="page-item"><a class="page-link" href="<?= constant("url") ?>buscar/<?= $filtro . "/" . ($num_pagina + 1) ?>">Siguente</a>
                </li>
            </ul>
        </nav>

    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>