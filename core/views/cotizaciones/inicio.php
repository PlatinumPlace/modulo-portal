<h1 class="h3 mb-2 text-gray-800">Cotizaciones</h1>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Estado</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($mydeals)) : ?>
            <?php foreach ($mydeals as $key => $value) : ?>
              <tr>
                <td><?= $value['Stage'] ?></td>
                <td>
                  <?php
                      if ($value['Stage'] == "Emitida") {
                        echo $value['Total'];
                      }else {
                        echo "No disponible";
                      }
                      ?>
                </td>
                <td><a href="index.php?controller=HomeController&action=cotizacion_detalles&id=<?= $value['id']?>" class="btn btn-primary">Ver</a></td>
                <td></td>
              </tr>
            <?php endforeach ?>
          <?php endif ?>
        </tbody>
      </table>
    </div>
  </div>
</div>