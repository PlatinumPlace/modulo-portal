<div class="row">

  <div class="col s12 m3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Cotizaciones totales</span>
        <p><?= $ofertas_totales ?></p>
      </div>
      <div class="card-action">
        <a href="?pagina=lista">Ver mas</a>
      </div>
    </div>
  </div>

  <div class="col s12 m3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Emisiones del Mes</span>
        <p><?= $ofertas_emitidos ?></p>
      </div>
      <div class="card-action">
        <a href="?pagina=lista&filtro=<?= $filtro_1 ?>">Ver mas</a>
      </div>
    </div>
  </div>

  <div class="col s12 m3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Vencimientos del Mes</span>
        <p><?= $ofertas_vencen ?></p>
      </div>
      <div class="card-action">
        <a href="?pagina=lista&filtro=<?= $filtro_2 ?>">Ver mas</a>
      </div>
    </div>
  </div>

</div>