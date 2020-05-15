<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="public/css/blog-post.css" rel="stylesheet">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="public/img/logo.png">
</head>

<body>
    <div class="container">

        <div class="row">

            <div class="col-md-2">
                <img src="public/img/logo.png" height="200" width="150">
            </div>

            <div class="col-md-10">
                <div class="row justify-content-center">

                    <div class="col-8">

                        <?php if (isset($_POST['submit'])) : ?>
                            <div class="alert alert-primary" role="alert">
                                <?= $alerta ?>
                            </div>
                        <?php endif ?>

                        <div class="card shadow-lg border-0 rounded-lg">

                            <div class="card-body">

                                <form method="POST" action="<?= constant('iniciar_sesion') ?>">

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
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
    <br><br>
    <!-- Footer -->
    <footer class="py-2 bg-primary fixed-bottom">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; GrupoNobe <?= date("Y") ?></p>
        </div>
    </footer>
</body>

</html>