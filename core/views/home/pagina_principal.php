<div class="row">

  <div class="col s12 m4">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Cotizaciones totales</span>
        <p><?= $ofertas_totales ?></p>
      </div>
      <div class="card-action">
        <a href="?pagina=buscar_cotizaciones">Ver mas</a>
      </div>
    </div>
  </div>

  <div class="col s12 m4">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Emisiones del Mes</span>
        <p><?= $ofertas_emisiones ?></p>
      </div>
      <div class="card-action">
        <a href="?pagina=lista_cotizaciones&filtro=<?= $filtro_emisiones ?>">Ver mas</a>
      </div>
    </div>
  </div>

  <div class="col s12 m4">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Vencimientos del Mes</span>
        <p><?= $ofertas_vencimientos ?></p>
      </div>
      <div class="card-action">
        <a href="?pagina=lista_cotizaciones&filtro=<?= $filtro_vencimientos ?>">Ver mas</a>
      </div>
    </div>
  </div>



</div>