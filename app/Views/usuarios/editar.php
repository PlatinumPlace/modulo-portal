<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cambiar contraseña</h1>
</div>

<?php if (!empty($alerta)) : ?>
    <div class="alert alert-info" role="alert"> <?= $alerta ?></div>
<?php endif ?>

<div class="card mb-4">
    <div class="card-body">
        <form action="<?= site_url("usuarios/cambiar") ?>" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="mb-3 col">
                    <label for="exampleInputPassword1" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="contrase_a_vieja">
                </div>

                <div class="mb-3 col">
                    <label for="exampleInputPassword2" class="form-label">Contraseña nueva</label>
                    <input type="password" class="form-control" id="exampleInputPassword2" name="contrase_a_nueva">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">cambiar</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>