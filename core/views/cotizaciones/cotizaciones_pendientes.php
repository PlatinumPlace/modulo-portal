<h1 class="h3 mb-2 text-gray-800">Cotizaciones</h1>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Estado</th>
            <th>Fecha de cierre</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mydeals as $key => $value) : ?>
            <?php if ($value['Stage'] == "Cotizado") : ?>
              <?php
              $inicio = strtotime(date('Y-m-d'));
              $fin = strtotime($value["Closing_Date"]);
              $resultado = $fin - $inicio;
              $dias_restantes = ((($resultado / 60) / 60) / 24);
              ?>
              <tr>
                <td><?= $value['Stage'] ?></td>
                <td><?= $value['Closing_Date'] ?> (Quedan <?= $dias_restantes ?> dia<?= $retVal = ($dias_restantes > 1) ? "s" : ""; ?>) </td>
                <td><a href="index.php?controller=HomeController&action=cotizacion_detalles_vehiculo&id=<?= $value['id'] ?>" class="btn btn-primary">Ver</a></td>
              </tr>
            <?php endif ?>
          <?php endforeach ?>
      </table>
    </div>
  </div>
</div>