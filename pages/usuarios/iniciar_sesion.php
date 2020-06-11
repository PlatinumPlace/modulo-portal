<?php

if ($_POST) {
    $usuarios = new usuarios;
    $alerta = $usuarios->validar_usuario($_POST['Email'], $_POST['Contrase_a']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">
</head>

<body>
    <div class="container">

        <br><br><br>

        <div class="row">

            <div class="col-md-2">
                <img src="<?= constant("url") ?>public/img/logo.png" height="200" width="150">
            </div>

            <div class="col-md-10">
                <div class="row justify-content-center">

                    <div class="col-8">
                        <?php if (isset($alerta)) : ?>
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
                                        <button class="btn btn-primary" type="submit">Verificar</button>
                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="py-2 bg-primary fixed-bottom">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; GrupoNobe <?= date("Y") ?></p>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>