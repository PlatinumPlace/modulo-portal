<h1 class="mt-4 text-uppercase">
    <?php
    if ($filtro == "emisiones_mensuales") {
        echo "emisiones del mes";
    } elseif ($filtro == "vencimientos_mensuales") {
        echo "vencimientos del mes";
    } else {
        echo "buscar Emisiones";
    }
    ?>
</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item active">Cotizaciones</li>
</ol>
<div class="card mb-4 col-xl-8">
    <div class="card-body">
        <form class="form-inline" method="post" action="<?= constant("url") ?>tratos/buscar">
            <div class="form-group mb-2 mr-sm-2">
                <select class="form-control" name="parametro" required>

                </select>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <input type="text" class="form-control" name="busqueda" required>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <button type="submit" class="btn btn-primary">Buscar</button>
                |
                <a href="<?= constant("url") ?>tratos/buscar/<?= $filtro ?>" class="btn btn-info">Limpiar</a>
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
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cotizaciones)) : ?>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <tr>
                                <?php
                                if (empty($filtro) or $filtro == "todos") {
                                    //echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Tipo') . "</td>";
                                    //echo "<td>RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Quote_Stage') . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Valid_Till') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . "tratos/detalles_" . strtolower($cotizacion->getFieldValue('Type')) . '/' . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    echo '<a href="' . constant("url") . "tratos/adjuntar" . '/' . $cotizacion->getEntityId() . '" title="Adjuntar Documentos"><i class="fas fa-file-upload"></i></a>';
                                    echo '<a href="' . constant("url") . "tratos/descargar_" . strtolower($cotizacion->getFieldValue('Type')) . '/' . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                                    echo "</td>";
                                } elseif ($filtro == "emisiones_mensuales" and !empty($cotizacion->getFieldValue('Deal_Name')) and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date("Y-m")) {
                                    //echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Tipo') . "</td>";
                                    //echo "<td>RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Quote_Stage') . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Valid_Till') . "</td>";
                                    //echo "<td>";
                                    echo '<a href="' . constant("url") . "tratos/detalles_" . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    echo '<a href="' . constant("url") . "tratos/adjuntar" . '/' . $cotizacion->getEntityId() . '" title="Adjuntar Documentos"><i class="fas fa-file-upload"></i></a>';
                                    echo '<a href="' . constant("url") . "tratos/descargar_" . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                                    echo "</td>";
                                } elseif ($filtro == "vencimientos_mensuales" and !empty($cotizacion->getFieldValue('Deal_Name')) and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date("Y-m")) {
                                    //echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Tipo') . "</td>";
                                    //echo "<td>RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Quote_Stage') . "</td>";
                                    //echo "<td>" . $cotizacion->getFieldValue('Valid_Till') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . "tratos/detalles_" . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    echo '<a href="' . constant("url") . "tratos/adjuntar" . '/' . $cotizacion->getEntityId() . '" title="Adjuntar Documentos"><i class="fas fa-file-upload"></i></a>';
                                    echo '<a href="' . constant("url") . "tratos/descargar_" . strtolower($cotizacion->getFieldValue('Tipo')) . '/' . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
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