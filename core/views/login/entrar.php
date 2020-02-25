<?php
if ($_POST) {
    require_once('core/helpers/iniciar_sesion.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="public/css/simple-sidebar.css" rel="stylesheet">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="public/img/portal/logo.png">
</head>

<body class="bg-primary">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header text-center font-weight-light my-4">
                            <h3>IT - Insurance Tech</h3>
                            <?php if (isset($mensaje)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $mensaje ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="index.php">
                                <div class="form-group">
                                    <label class="small mb-1">Usuario</label>
                                    <input class="form-control py-4" type="text" name="usuario" />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPassword">Contraseña</label>
                                    <input class="form-control py-4" type="password" name="clave" />
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 center">
                                    <button class="btn btn-primary" type="submit">Ingresar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="fixed-bottom py-4 bg-light mt-auto">
        <div class="container">
            <div class="text-muted">
                Copyright &copy; Grupo Nobe <?= date('Y') ?>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>