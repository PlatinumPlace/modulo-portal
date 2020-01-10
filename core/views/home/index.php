
<div class="container">
<div class="row">

  <div class="col s12 m3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Cotizaciones totales</span>
        <p><?= $tratos_totales ?></p>
      </div>
      <div class="card-action">
        <a href="?page=list">Ver mas</a>
      </div>
    </div>
  </div>

  <div class="col s12 m3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Cotizaciones pendientes</span>
        <p><?= $tratos_pendientes ?></p>
      </div>
      <div class="card-action">
        <a href="?page=list&filter=Cotizando">Ver mas</a>
      </div>
    </div>
  </div>

  <div class="col s12 m3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Pólizas emitidas en este mes</span>
        <p><?= $tratos_emitidos ?></p>
      </div>
      <div class="card-action">
        <a href="?page=list&filter=En trámite">Ver mas</a>
      </div>
    </div>
  </div>

  <div class="col s12 m3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Pólizas vencidas en este mes</span>
        <p><?= $tratos_vencen ?></p>
      </div>
      <div class="card-action">
        <a href="?page=list&filter=En trámite">Ver mas</a>
      </div>
    </div>
  </div>

</div>
</div>