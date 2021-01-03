<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Cambiar contraseña</h1>
<hr>

<?php if (!empty($alerta)) : ?>
    <div class="alert alert-info" role="alert"> <?= $alerta ?></div>
<?php endif ?>

<form action="<?= site_url("editar/post") ?>" method="post">
    <?= csrf_field() ?>

    <div class="card mb-4">
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="exampleInputPassword1" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="contrase_a_vieja" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="exampleInputPassword2" class="form-label">Contraseña nueva</label>
                    <input type="password" class="form-control" id="exampleInputPassword2" name="contrase_a_nueva" required>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>

<?= $this->endSection() ?>