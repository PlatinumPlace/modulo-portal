<div class="section no-pad-bot" id="index-banner">
  <div class="container">
    <h1 class="header center orange-text">Dashboard</h1>
  </div>
</div>

<div class="container">
  <div class="section">

    <div class="row">

      <div class="col s12 m4">
        <div class="card">
          <div class="card-content">
            <span class="card-title">Cotizaciones totales</span>
            <p><?= $cotizaciones['total'] ?></p>
          </div>
          <div class="card-action">
            <a href="?pagina=buscar">Ver más</a>
          </div>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="card">
          <div class="card-content">
            <span class="card-title">Emisiones del Mes</span>
            <p><?= $cotizaciones['emisiones'] ?></p>
          </div>
          <div class="card-action">
            <a href="?pagina=lista&filtro=<?= $cotizaciones['filtro_emisiones'] ?>">Ver más</a>
          </div>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="card">
          <div class="card-content">
            <span class="card-title">Vencimientos del Mes</span>
            <p><?= $cotizaciones['vencimientos'] ?></p>
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