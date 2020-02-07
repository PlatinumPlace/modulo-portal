<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
      <div class="card-body">
        <h5>Cotizaciones Totales</h5>
        <p><?= $tratos['total'] ?></p>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-between">
        <a class="small text-white stretched-link" href="?pagina=buscar">Ver mas</a>
        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card bg-warning text-white mb-4">
      <div class="card-body">
        <h5>Emisiones al Mes</h5>
        <p><?= $tratos['emisiones'] ?></p>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-between">
        <a class="small text-white stretched-link" href="?pagina=lista&filtro=<?= $tratos['filtro_emisiones'] ?>">Ver mas</a>
        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card bg-success text-white mb-4">
      <div class="card-body">
        <h5>Vencimientos al Mes</h5>
        <p><?= $tratos['vencimientos'] ?></p>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-between">
        <a class="small text-white stretched-link" href="?pagina=lista&filtro=<?= $tratos['filtro_vencimientos'] ?>">Ver mas</a>
        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
      </div>
    </div>
  </div>
</div>