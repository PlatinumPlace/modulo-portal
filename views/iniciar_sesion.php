<?php
if ($_POST) {
    $usuarios = new usuarios();
    $usuarios->ingresar_usuario();
    $alerta = "Usuario o contraseña incorrectos.";
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>IT - Insurance Tech</title>
        <link rel="icon" type="image/png" href="<?= constant("url") ?>public/icons/logo.png">

        <link href="<?= constant("url") ?>public/vendor/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>


    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">

                            <?php if (isset($alerta)) : ?>
                                <div class="alert alert-primary" role="alert">
                                    <?= $alerta ?>
                                </div>
                            <?php endif ?>

                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <div class="text-center">
                                        <img src="<?= constant("url") ?>public/icons/logo.png" height="150" width="150">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <form method="POST" action="<?= constant("url") ?>">
                                        <div class="form-group">
                                            <label class="small mb-1">Usuario</label> <input class="form-control py-4" type="email" name="email" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1">Contraseña</label> <input class="form-control py-4" type="password" name="pass" required />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Ingresar</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; GrupoNobe <?= date("Y") ?></div>
                        </div>
                    </div>
                </footer>
            </div>

        </div>

    </body>

</html>