<?php
$tratos = new tratos();
$resumen = $tratos->resumen($_SESSION['usuario']['id']);
?>
<div class="section no-pad-bot" id="index-banner">
  <h2 class="header center blue-text">¡Bienvenido al Insurance Tech de Grupo Nobe!</h2>
  <div class="row center">
    <h5 class="header col s12 light">Desde su panel de control podrá ver la infomación necesaria manejar sus pólizas y cotizaciones.</h5>
  </div>
</div>
<div class="row">
  <div class="col s12 m4">
    <div class="card blue darken-1">
      <div class="card-content white-text">
        <span class="card-title">Cotizaciones Totales</span>
        <p><?= $resumen['total'] ?></p>
      </div>
      <div class="card-action white">
        <a href="index.php?page=search">Ver más</a>
      </div>
    </div>
  </div>
  <div class="col s12 m4">
    <div class="card blue darken-1">
      <div class="card-content white-text">
        <span class="card-title">Emisiones al Mes</span>
        <p><?= $resumen['emisiones'] ?></p>
      </div>
      <div class="card-action white">
        <a href="index.php?page=list&filter=<?= $resumen['filtro_emisiones'] ?>">Ver más</a>
      </div>
    </div>
  </div>
  <div class="col s12 m4">
    <div class="card orange darken-1">
      <div class="card-content white-text">
        <span class="card-title">Vencimientos al Mes</span>
        <p><?= $resumen['vencimientos'] ?></p>
      </div>
      <div class="card-action white">
        <a href="index.php?page=list&filter=<?= $resumen['filtro_vencimientos'] ?>">Ver más</a>
      </div>
    </div>
  </div>
</div>