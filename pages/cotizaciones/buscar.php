<?php
$cotizaciones = new cotizaciones();

$url = obtener_url();
$filtro = (isset($url[0])) ? $url[0] : null;
$num_pagina = (isset($url[1])) ? $url[1] : 1;

if ($_POST) {
    $lista_resumenes = $cotizaciones->buscar_resumenes($num_pagina, $_POST['parametro'], $_POST['busqueda']);
} else {
    $lista_resumenes = $cotizaciones->lista_resumenes($num_pagina);
}

require_once 'pages/layout/header_main.php';
?>
<h1 class="mt-4 text-uppercase">
    <?php
    if ($filtro == "pendientes") {
        echo "cotizaciones pendientes";
    } elseif ($filtro == "emisiones_mensuales") {
        echo "emisiones del mes";
    } elseif ($filtro == "vencimientos_mensuales") {
        echo "vencimientos del mes";
    } else {
        echo "buscar cotizaciones";
    }
    ?>
</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item active">Cotizaciones</li>
</ol>
<div class="card mb-4 col-xl-8">
    <div class="card-body">
        <form class="form-inline" method="post" action="<?= constant("url") ?>cotizaciones/buscar">
            <div class="form-group mb-2 mr-sm-2">
                <select class="form-control" name="parametro" required>
                    <option value="No_Cotizaci_n" selected>No. de cotización</option>
                    <option value="RNC_Cedula">RNC/Cédula</option>
                    <option value="Nombre">Nombre</option>
                    <option value="Apellidos">Apellidos</option>
                    <option value="Chasis">Chasis</option>
                </select>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <input type="text" class="form-control" name="busqueda" required>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <button type="submit" class="btn btn-primary">Buscar</button>
                | <a href="<?= constant("url") ?>cotizaciones/buscar/<?= $filtro ?>" class="btn btn-info">Limpiar</a>
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
                        <th>No. <br> Cotización
                        </th>
                        <th>Nombre <br> Asegurado
                        </th>
                        <th>Bien <br> Asegurado
                        </th>
                        <th>Suma <br> Asegurada
                        </th>
                        <th>Estado</th>
                        <th>Fecha <br> Cierre
                        </th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lista_resumenes)) : ?>
                        <?php foreach ($lista_resumenes as $resumen) : ?>
                            <tr>
                                <?php
                                if (empty($filtro) or $filtro == "todos") {
                                    echo "<td>" . $resumen->getFieldValue('No_Cotizaci_n') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Nombre') . " " . $resumen->getFieldValue('Apellidos') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Type') . "</td>";
                                    echo "<td>RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Stage') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Closing_Date') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/detalles/' . $resumen->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    if (!empty($resumen->getFieldValue('Nombre'))) {
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/emitir/' . $resumen->getEntityId() . '" title="Emitir"><i class="fas fa-file-upload"></i></a>';
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/descargar/' . $resumen->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                                    }
                                    echo "</td>";
                                } elseif ($filtro == "pendientes" and $resumen->getFieldValue("Stage") == "Cotizando" and date("Y-m", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) == date("Y-m")) {
                                    echo "<td>" . $resumen->getFieldValue('No_Cotizaci_n') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Nombre') . " " . $resumen->getFieldValue('Apellidos') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Type') . "</td>";
                                    echo "<td>RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Stage') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Closing_Date') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/detalles/' . $resumen->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    if (!empty($resumen->getFieldValue('Nombre'))) {
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/emitir/' . $resumen->getEntityId() . '" title="Emitir"><i class="fas fa-file-upload"></i></a>';
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/descargar/' . $resumen->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                                    }
                                    echo "</td>";
                                } elseif ($filtro == "emisiones_mensuales" and in_array($resumen->getFieldValue("Stage"), array("Emitido", "En trámite")) and date("Y-m", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) == date("Y-m")) {
                                    echo "<td>" . $resumen->getFieldValue('No_Cotizaci_n') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Nombre') . " " . $resumen->getFieldValue('Apellidos') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Type') . "</td>";
                                    echo "<td>RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Stage') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Closing_Date') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/detalles/' . $resumen->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    if (!empty($resumen->getFieldValue('Nombre'))) {
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/emitir/' . $resumen->getEntityId() . '" title="Emitir"><i class="fas fa-file-upload"></i></a>';
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/descargar/' . $resumen->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                                    }
                                    echo "</td>";
                                } elseif ($filtro == "vencimientos_mensuales" and in_array($resumen->getFieldValue("Stage"), array("Emitido", "En trámite")) and date("Y-m", strtotime($resumen->getFieldValue("Closing_Date"))) == date("Y-m")) {
                                    echo "<td>" . $resumen->getFieldValue('No_Cotizaci_n') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Nombre') . " " . $resumen->getFieldValue('Apellidos') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Type') . "</td>";
                                    echo "<td>RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Stage') . "</td>";
                                    echo "<td>" . $resumen->getFieldValue('Closing_Date') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/detalles/' . $resumen->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    if (!empty($resumen->getFieldValue('Nombre'))) {
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/emitir/' . $resumen->getEntityId() . '" title="Emitir"><i class="fas fa-file-upload"></i></a>';
                                        echo '<a href="' . constant("url") . strtolower($resumen->getFieldValue('Type')) . '/descargar/' . $resumen->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                                    }
                                    echo "</td>";
                                }
                                ?>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <br>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item"><a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar/<?= (!empty($filtro)) ? $filtro  : "todos"; ?>/<?= $num_pagina - 1 ?>">Anterior</a>
                </li>
                <li class="page-item"><a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar/<?= (!empty($filtro)) ? $filtro  : "todos"; ?>/<?= $num_pagina + 1 ?>">Siguente</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php require_once 'pages/layout/footer_main.php'; ?>