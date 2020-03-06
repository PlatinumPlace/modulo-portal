<?php
$tratos = new tratos();
$resumen = $tratos->resumen($_SESSION['usuario']['id']);
?>
<h1 class="mt-4">Panel de Control</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Panel de Control</li>
</ol>
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
  <p>Desde su panel de control podrá ver la infomación necesaria manejar sus pólizas y cotizaciones.</p>
</div>
<div class="row row-cols-2 row-cols-md-3">
  <div class="col mb-4">
    <div class="card">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col">
            <h1><?= $resumen['total'] ?></h1>
          </div>
          <div class="col">
            <h5>
              Cotizaciones Totales
            </h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <a href="index.php?page=search" class="card-link">Ver más</a>
      </div>
    </div>
  </div>

  <div class="col mb-4">
    <div class="card">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col">
            <h1><?= $resumen['emisiones'] ?></h1>
          </div>
          <div class="col">
            <h5>
              Emisiones al Mes
            </h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <a href="index.php?page=list&filter=<?= $resumen['filtro_emisiones'] ?>" class="card-link">Ver más</a>
      </div>
    </div>
  </div>
  <div class="col mb-4">
    <div class="card">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col">
            <h1><?= $resumen['vencimientos'] ?></h1>
          </div>
          <div class="col">
            <h5>
              Vencimientos al Mes
            </h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <a href="index.php?page=list&filter=<?= $resumen['filtro_vencimientos'] ?>" class="card-link">Ver más</a>
      </div>
    </div>
  </div>
</div>