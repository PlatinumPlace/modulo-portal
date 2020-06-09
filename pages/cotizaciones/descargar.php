<?php

$portal = new portal;
$cotizaciones = new cotizaciones;

$url = $portal->obtener_url();
$post = json_decode($url[0], true);
$contrato =  $cotizaciones->detalles_contrato($post["contrato_id"]);
$lista = $cotizaciones->buscar_cotizaciones("Type", ucfirst($post["tipo_cotizacion"]));

if (!$lista) {
  $alerta = "No existen registros.";
  header("Location:" . constant("url") . "cotizaciones/exportar/$alerta");
  exit;
} else {
  $titulo = "Reporte " . ucfirst($post["tipo_reporte"]) . " " . ucfirst($post["tipo_cotizacion"]);
}

$prima_neta_sumatoria = 0;
$isc_sumatoria = 0;
$prima_total_sumatoria = 0;
$valor_asegurado_sumatoria = 0;
$comision_sumatoria = 0;

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title><?= $titulo ?></title>
  <link rel="icon" type="image/png" href="<?= constant("url") ?>img/logo.png">
</head>

<body>
  <div class="container">

    <div class="row">
      <div class="col-4">
        <img src="<?= constant("url") ?>img/logo.png" height="200" width="150">
      </div>

      <div class="col-8">
        <div class="row">
          <div class="col-6">
            <b><?= $contrato->getFieldValue("Socio")->getLookupLabel() ?></b> <br>
            <b><?= $titulo ?></b> <br>
            <b>Aseguradora:</b> <br>
            <b>Póliza:</b> <br>
            <b>Desde:</b> <br>
            <b>Hasta:</b> <br>
            <b>Vendedor:</b>
          </div>

          <div class="col-6">
            &nbsp; <br>
            &nbsp; <br>
            <?= $contrato->getFieldValue("Aseguradora")->getLookupLabel() ?> <br>
            <?= $contrato->getFieldValue('No_P_liza') ?> <br>
            <?= $post["desde"] ?> <br>
            <?= $post["hasta"] ?> <br>
            <?= $_SESSION["usuario"]['nombre'] ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      &nbsp;
    </div>

    <div class="col-12">
      <table class="table">
        <thead>
          <tr class="bg-primary text-white">
            <?php if ($post["tipo_cotizacion"] == "auto") : ?>

              <th scope="col">Fecha Emision</th>
              <th scope="col">Marca</th>
              <th scope="col">Modelo</th>
              <th scope="col">Año</th>
              <th scope="col">Valor Asegurado</th>
              <th scope="col">Plan</th>
              <th scope="col">Prima Neta</th>
              <th scope="col">ISC</th>
              <th scope="col">Prima Total</th>

              <?php if ($post["tipo_reporte"] == "comisiones") : ?>
                <th scope="col">Comisión</th>
              <?php endif ?>

            <?php endif ?>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($lista as $resumen) {
            if (
              date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $post["desde"]
              and
              date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $post["hasta"]
              and
              $resumen->getFieldValue("Contact_Name")->getEntityId() == $_SESSION["usuario"]["id"]
            ) {
              $detalles = $cotizaciones->detalles_cotizaciones($resumen->getEntityId());
              foreach ($detalles as $info) {
                if (
                  $info->getFieldValue("Aseguradora")->getEntityId() == $contrato->getFieldValue("Aseguradora")->getEntityId()
                  and
                  $info->getFieldValue('Grand_Total') > 0
                ) {
                  $planes = $info->getLineItems();
                  foreach ($planes as $plan) {
                    $prima_neta = $plan->getTotalAfterDiscount();
                    $isc = $plan->getTaxAmount();
                    $prima_total = $plan->getNetTotal();
                  }
                  $comision = $info->getFieldValue('Comisi_n_Socio');
                  if ($post["tipo_reporte"] == "cotizaciones") {
                    $estado[] = "Cotizando";
                  } elseif ($post["tipo_reporte"] == "emisiones" or $post["tipo_reporte"] == "comisiones") {
                    $estado = array("En trámite", "Emitido");
                  }
                  if (in_array($resumen->getFieldValue("Stage"), $estado)) {
                    echo "<tr>";
                    if ($post["tipo_cotizacion"] == "auto") {
                      echo '<th scope="row">' . date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) . '</th>';
                      echo "<td>" . $resumen->getFieldValue('Marca')->getLookupLabel() . "</td>";
                      echo "<td>" . $resumen->getFieldValue('Modelo')->getLookupLabel() . "</td>";
                      echo "<td>" . $resumen->getFieldValue('A_o_de_Fabricacion') . "</td>";
                      echo "<td>RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                      echo "<td>" . $resumen->getFieldValue('Plan') . "</td>";
                      echo "<td>RD$" . number_format($prima_neta, 2) . "</td>";
                      echo "<td>RD$" . number_format($isc, 2) . "</td>";
                      echo "<td>RD$" . number_format($prima_total, 2) . "</td>";
                      $valor_asegurado_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                      $prima_neta_sumatoria += $prima_neta;
                      $isc_sumatoria += $isc;
                      $prima_total_sumatoria += $prima_total;
                      if ($post["tipo_reporte"] == "comisiones") {
                        echo "<td>RD$" . number_format($comision, 2) . "</td>";
                        $comision_sumatoria += $comision;
                      }
                    }
                    echo "</tr>";
                  }
                }
              }
            }
          }
          ?>
        </tbody>
      </table>
    </div>

    <div class="col-12">
      &nbsp;
    </div>

    <div class="row col-6">
      <div class="col">
        <b>Total Primas Netas:</b> <br>
        <b>Total ISC:</b> <br>
        <b>Total Primas Totales:</b> <br>
        <b>Total Valores Asegurados:</b> <br>
        <?php if ($post["tipo_reporte"] == "comisiones") : ?>
          <b>Total Comisiones:</b> <br>
        <?php endif ?>
      </div>

      <div class="col">
        RD$<?= number_format($prima_neta_sumatoria, 2) ?> <br>
        RD$<?= number_format($isc_sumatoria, 2) ?> <br>
        RD$<?= number_format($prima_total_sumatoria, 2) ?> <br>
        RD$<?= number_format($valor_asegurado_sumatoria, 2) ?> <br>
        <?php if ($post["tipo_reporte"] == "comisiones") : ?>
          RD$<?= number_format($comision_sumatoria, 2) ?>
        <?php endif ?>
      </div>
    </div>

    <?php
    if ($valor_asegurado_sumatoria == 0) {
      $alerta = "No existen resultados para la aseguradora seleccionada.";
      header("Location:" . constant("url") . "cotizaciones/exportar/$alerta");
      exit;
    }
    ?>

    <script>
      var time = 500;
      var url = "<?= constant("url") ?>";
      setTimeout(function() {
        window.print();
        window.location = url + "cotizaciones/exportar";
      }, time);
    </script>

  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>