<?php if (isset($_POST['submit'])) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<div class="card shadow-lg border-0 rounded-lg">

    <div class="card-body">

        <form method="POST" action="<?= constant("url") ?>">

            <div class="form-group">
                <label class="small mb-1">Usuario</label>
                <input class="form-control py-4" type="email" name="Email" required />
            </div>

            <div class="form-group">
                <label class="small mb-1">Contraseña</label>
                <input class="form-control py-4" type="password" name="Contrase_a" required />
            </div>

            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                <button class="btn btn-primary" name="submit" type="submit">Verificar</button>
            </div>

        </form>
    </div>

</div>