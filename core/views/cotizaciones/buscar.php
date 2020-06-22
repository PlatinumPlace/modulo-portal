<h1 class="mt-4">Buscar cotizaciones</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Cotizaciones</li>
</ol>

<div class="card mb-4">
    <div class="card-body">

        <form class="form-inline" method="post" action="<?= constant("url") ?>cotizaciones/buscar">

            <div class="form-group mb-2">
                <select class="form-control" name="parametro" required>
                    <option value="No_Cotizaci_n" selected>No. de cotización</option>
                    <option value="RNC_Cedula">RNC/Cédula</option>
                    <option value="Nombre">Nombre</option>
                    <option value="Apellido">Apellido</option>
                    <option value="Chasis">Chasis</option>
                </select>
            </div>

            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" name="busqueda" required>
            </div>

            <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            |
            <a href="<?= constant("url") ?>cotizaciones/buscar" class="btn btn-info mb-2">Limpiar</a>

        </form>

    </div>
</div>


<?php if (empty($lista)) : ?>

    <div class="alert alert-info" role="alert">
        No se encontraron cotizaciones
    </div>

<?php endif ?>

<div class="card mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. <br> Cotización</th>
                        <th>Nombre <br> Asegurado</th>
                        <th>Bien <br> Asegurado</th>
                        <th>Suma <br> Asegurada</th>
                        <th>Estado</th>
                        <th>Fecha <br> Cierre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lista)) : ?>
                        <?php foreach ($lista as $cotizacion) : ?>
                            <tr>
                                <td><?= $cotizacion->getFieldValue('No_Cotizaci_n')  ?></td>
                                <td><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></td>
                                <td><?= $cotizacion->getFieldValue('Type')  ?></td>
                                <td>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                <td><?= $cotizacion->getFieldValue("Stage") ?></td>
                                <td><?= date("d/m/Y", strtotime($cotizacion->getFieldValue("Closing_Date"))) ?></td>
                                <td>
                                    <?php if ($cotizacion->getFieldValue("Stage") != "Abandonado") : ?>
                                        <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/detalles/' . $cotizacion->getEntityId() ?>" title="Detalles">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                        <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/emitir/' . $cotizacion->getEntityId() ?>" title="Emitir">
                                                <i class="fas fa-file-upload"></i>
                                            </a>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/descargar/' . $cotizacion->getEntityId() ?>" title="Descargar">
                                                <i class="fas fa-file-download"></i>
                                            </a>
                                        <?php endif ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar/<?= $num_pagina - 1 ?>">Anterior</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?= constant("url") ?>cotizaciones/buscar/<?= $num_pagina + 1 ?>">Siguente</a>
                        </li>
                    </ul>
                </nav>
            </table>
        </div>
    </div>
</div>