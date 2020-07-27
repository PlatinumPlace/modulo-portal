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
    <li class="breadcrumb-item active">Emisiones</li>
</ol>

<div class="card mb-4 col-xl-8">
    <div class="card-body">
        <form class="form-inline" method="post" action="<?= constant("url") ?>tratos/buscar">
            <div class="form-group mb-2 mr-sm-2">
                <select class="form-control" name="parametro" required>
                    <option value="No_Emisi_n" selected>No. de emisión</option>
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
                        <th>No. Emisión</th>
                        <th>Póliza</th>
                        <th>Cliente</th>
                        <th>Bien Asegurado</th>
                        <th>Suma Asegurada</th>
                        <th>Estado</th>
                        <th>Fecha de Cierre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tratos)) : ?>
                        <?php foreach ($tratos as $trato) : ?>
                            <tr>
                                <?php
                                if (
                                    empty($filtro)
                                    or
                                    $filtro == "todos"
                                    or
                                    ($filtro == "emisiones_mensuales"
                                        and
                                        date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date("Y-m"))
                                    or
                                    ($filtro == "vencimientos_mensuales" 
                                    and 
                                    date("Y-m", strtotime($cotizacion->getFieldValue("Closing_Date"))) == date("Y-m"))
                                ) {
                                    echo "<td>" . $trato->getFieldValue('No_Emisi_n') . "</td>";
                                    echo "<td>" . $trato->getFieldValue('P_liza')->getLookupLabel() . "</td>";
                                    echo "<td>" . $trato->getFieldValue('Cliente')->getLookupLabel() . "</td>";
                                    echo "<td>" . $trato->getFieldValue('Type') . "</td>";
                                    echo "<td>RD$" . number_format($trato->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                    echo "<td>" . $trato->getFieldValue('Stage') . "</td>";
                                    echo "<td>" . $trato->getFieldValue('Closing_Date') . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . constant("url") . "tratos/detalles_" . strtolower($trato->getFieldValue('Type')) . '/' . $trato->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                                    echo "&nbsp;";
                                    echo '<a href="' . constant("url") . "tratos/adjuntar" . '/' . $trato->getEntityId() . '" title="Adjuntar Documentos"><i class="fas fa-file-upload"></i></a>';
                                    echo "&nbsp;";
                                    echo '<a href="' . constant("url") . "tratos/descargar_" . strtolower($trato->getFieldValue('Type')) . '/' . $trato->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
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