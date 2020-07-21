<h1 class="mt-4 text-uppercase">
    <?php
    if ($filtro == "pendientes") {
        echo "cotizaciones pendientes";
    } else {
        echo "buscar cotizaciones";
    }
    ?>
</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
</ol>
<div class="card mb-4 col-xl-8">
    <div class="card-body">
        <form class="form-inline" method="post" action="<?= constant("url") ?>cotizaciones/buscar">
            <div class="form-group mb-2 mr-sm-2">
                <select class="form-control" name="parametro" required>
                    <option value="Quote_Number" selected>No. de cotización</option>
                </select>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <input type="text" class="form-control" name="busqueda" required>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <button type="submit" class="btn btn-primary">Buscar</button>
                |
                <a href="<?= constant("url") ?>cotizaciones/buscar/<?= $filtro ?>" class="btn btn-info">Limpiar</a>
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
                        <th>No. <br> Cotización</th>
                        <th>Bien <br> Asegurado</th>
                        <th>Suma <br> Asegurada</th>
                        <th>Estado</th>
                        <th>Fecha <br> Cierre </th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cotizaciones)) : ?>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <tr>
                                <?php
                                if (empty($filtro) or $filtro == "todos") {
                                    echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                                    echo "<td>" . $cotizacion->getFieldValue('Tipo') . "</td>";
                                    echo "<td>RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    echo "<td>" . $cotizacion->getFieldValue('Quote_Stage') . "</td>";
                                    echo "<td>" . $cotizacion->getFieldValue('Valid_Till') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . 'cotizaciones/detalles_' . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    echo "&nbsp;";
                                    if ($cotizacion->getFieldValue("Quote_Stage") == "Negociación") {
                                        echo '<a href="' . constant("url") . 'cotizaciones/emitir_' . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></i></a>';
                                        echo "&nbsp;";
                                    }
                                    echo '<a href="' . constant("url") . 'cotizaciones/descargar_' . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                                    echo "</td>";
                                } elseif ($filtro == "pendientes" and $cotizacion->getFieldValue("Quote_Stage") == "Negociación" and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date("Y-m")) {
                                    echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                                    echo "<td>" . $cotizacion->getFieldValue('Tipo') . "</td>";
                                    echo "<td>RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    echo "<td>" . $cotizacion->getFieldValue('Quote_Stage') . "</td>";
                                    echo "<td>" . $cotizacion->getFieldValue('Valid_Till') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . 'cotizaciones/detalles_' . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    echo "&nbsp;";
                                    if ($cotizacion->getFieldValue("Quote_Stage") == "Negociación") {
                                        echo '<a href="' . constant("url") . 'cotizaciones/emitir_' . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></i></a>';
                                        echo "&nbsp;";
                                    }
                                    echo '<a href="' . constant("url") . 'cotizaciones/descargar_' . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
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