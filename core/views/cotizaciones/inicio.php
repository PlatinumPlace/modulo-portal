<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Todas las cotizaciones</h1>
  <a href="index.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left"></i> Regresar al dashboard</a>
</div>

<hr>

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
          <?php
          if (!empty($tratos)) {
            foreach ($tratos as $key => $trato) {
              $estado = explode("/", $filtro);
              if (in_array($trato["Stage"], $estado)) {
                echo '
                <tr>
                  <td>' . $trato['Stage'] . '</td>
                  <td>' . $trato['Closing_Date'] . '</td>
                  <td><a href="index.php?controller=cotizaciones&action=detalles&id=' . $trato['id'] . '" class="btn btn-primary">Ver</a></td>
                </tr>
                ';
              }
            }
          }
          ?>
      </table>
    </div>
  </div>
</div>