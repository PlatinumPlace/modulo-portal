<?= $this->extend('base') ?>

<?= $this->section('content') ?>

<style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

<!-- Custom styles for this template -->
<link href="<?= base_url("css/signin.css") ?>" rel="stylesheet">

<body class="text-center">
    <main class="form-signin">
        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-danger" role="alert"> <?= $alerta ?> </div>
        <?php endif ?>

        <form action="<?= site_url("login/ingresar") ?>" method="post">
            <?= csrf_field() ?>

            <img class="mb-4" src="<?= base_url("img/logo.png") ?>" alt="" width="150" height="150">

            <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Correo electrónico" required autofocus>

            <input type="password" id="inputPassword" class="form-control" name="contrase_a" placeholder="Contraseña" required>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>

            <p class="mt-5 mb-3 text-muted">Copyright &copy; Grupo Nobe <?= date('Y') ?></p>
        </form>
    </main>
</body>

<?= $this->endSection() ?>