<div class="section no-pad-bot" id="index-banner">
  <div class="container">
    <h1 class="header center blue-text">Dashboard</h1>
  </div>
</div>

<div class="container">
  <div class="section">

    <div class="row">

      <div class="col s12 m4">
        <div class="card">
          <div class="card-content center">
            <span class="card-title">Cotizaciones Totales</span>
            <h5><?= $cotizaciones['total'] ?></h5>
          </div>
          <div class="card-action">
            <a href="?pagina=buscar">Ver más</a>
          </div>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="card">
          <div class="card-content center">
            <span class="card-title">Emisiones al Mes</span>
            <h5><?= $cotizaciones['emisiones'] ?></h5>
          </div>
          <div class="card-action">
            <a href="?pagina=lista&filtro=<?= $cotizaciones['filtro_emisiones'] ?>">Ver más</a>
          </div>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="card">
          <div class="card-content center">
            <span class="card-title">Vencimientos al Mes</span>
            <h5><?= $cotizaciones['vencimientos'] ?></h5>
          </div>
          <div class="card-action">
            <a href="?pagina=lista&filtro=<?= $cotizaciones['filtro_vencimientos'] ?>">Ver más</a>
          </div>
        </div>
      </div>

    </div>

  </div>
  <br><br>
</div>