<?php
$api = new api();
$url = obtener_url();
$filtro = (isset($url[1])) ? $url[1] : "todos";
$num_pagina = (isset($url[2])) ? $url[2] : 1;
if ($_POST) {
    $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
} else {
    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
}
$result = $api->searchRecordsByCriteria("Quotes", $criterio, $num_pagina, 10);
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
                    <?php
                    foreach ($result as $cotizacion) {
                        if (
                            empty($filtro) or $filtro == "todos"
                            or
                            ($filtro == "emisiones_mensuales" and $cotizacion->getFieldValue("Deal_Name") != null
                                and
                                date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date("Y-m"))
                            or
                            ($filtro == "vencimientos_mensuales"
                                and
                                $cotizacion->getFieldValue("Deal_Name") != null
                                and
                                date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date("Y-m"))
                        ) {

                            if ($cotizacion->getFieldValue("Deal_Name") != null) {
                                echo '<tr class="table-success">';
                            } elseif ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date("Y-m")) {
                                echo '<tr class="table-danger">';
                            }

                            echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                            echo "<td>" . date("d-m-Y", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</td>";
                            echo "<td>" . $cotizacion->getFieldValue('RNC_C_dula') . "</td>";
                            echo "<td>" . $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') . "</td>";
                            echo "<td>RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                            echo "<td>" . $cotizacion->getFieldValue('Subject') . "</td>";
                            echo "<td>";
                            echo '<a href="' . constant("url") . 'detalles/' . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                            echo "&nbsp;";
                            if ($cotizacion->getFieldValue("Deal_Name") == null) {
                                echo '<a href="' . constant("url") . 'emitir/' . $cotizacion->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></i></a>';
                            } else {
                                echo '<a href="' . constant("url") . 'adjuntar/' . $cotizacion->getEntityId() . '" title="Adjuntar"><i class="fas fa-file-upload"></i></i></a>';
                            }
                            echo "&nbsp;";
                            echo '<a href="' . constant("url") . 'descargar/' . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
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