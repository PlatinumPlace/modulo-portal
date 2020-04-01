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
            <h1><?= $this->total ?></h1>
          </div>
          <div class="col">
            <h5>
              Cotizaciones Totales
            </h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <a href="<?= constant('url') ?>cotizacion/buscar" class="card-link">Ver más</a>
      </div>
    </div>
  </div>
  <div class="col mb-4">
    <div class="card">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col">
            <h1><?= $this->emisiones ?></h1>
          </div>
          <div class="col">
            <h5>
              Emisiones al Mes
            </h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <a href="<?= constant('url') ?>cotizacion/lista/<?= $this->filtro_emisiones ?>" class="card-link">Ver más</a>
      </div>
    </div>
  </div>
  <div class="col mb-4">
    <div class="card">
      <div class="card-header text-white bg-warning">
        <div class="row">
          <div class="col">
            <h1><?= $this->vencimientos ?></h1>
          </div>
          <div class="col">
            <h5>
              Vencimientos al Mes
            </h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <a href="<?= constant('url') ?>cotizacion/lista/<?= $this->filtro_vencimientos ?>" class="card-link">Ver más</a>
      </div>
    </div>
  </div>
</div>