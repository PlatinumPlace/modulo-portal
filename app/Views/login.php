<?= $this->extend('app') ?>

<?= $this->section('content') ?>

<div id="layoutAuthentication">
  <div id="layoutAuthentication_content">
    <main>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <?php if (session()->has('alerta')) : ?>
              <div class="alert alert-danger" role="alert"> <?= session('alerta') ?> </div>
            <?php endif ?>

            <div class="text-center">
              <img src="<?= base_url("img/logo.png") ?>" alt="" width="160" height="160">
            </div>

            <div class="card shadow-lg border-0 rounded-lg mt-5">
              <div class="card-body">
                <form action="<?= site_url("login/post") ?>" method="post">
                  <?= csrf_field() ?>

                  <div class="form-group">
                    <label class="small mb-1" for="inputEmailAddress">Correo electrónico</label>
                    <input class="form-control py-4" id="inputEmailAddress" type="email" name="email" required autofocus />
                  </div>

                  <div class="form-group">
                    <label class="small mb-1" for="inputPassword">Contraseña</label>
                    <input class="form-control py-4" id="inputPassword" type="password" name="contrase_a" required />
                  </div>

                  <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                    <button class="w-100 btn btn-primary" type="submit">Ingresar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <div id="layoutAuthentication_footer">
    <footer class="py-4 bg-light mt-auto">
      <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
          <div class="text-muted">Copyright &copy; Grupo Nobe <?= date("Y") ?></div>
        </div>
      </div>
    </footer>
  </div>
</div>

<?= $this->endSection() ?>