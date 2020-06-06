<?php

if (isset($_POST['submit'])) {

    $api = new api;

    $criterio = "((Email:equals:" . $_POST['Email'] . ") and (Contrase_a:equals:" . $_POST['Contrase_a'] . "))";
    $usuarios = $api->searchRecordsByCriteria("Contacts", $criterio);

    if (!empty($usuarios)) {
        foreach ($usuarios as $usuario) {
            if ($usuario->getFieldValue("Estado") == true) {

                $sesion['id'] = $usuario->getEntityId();
                $sesion['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                $sesion['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();

                setcookie("usuario", json_encode($sesion), time() + 3600, "/");

                header("Location:" . constant("url"));
                exit();
            } else {
                $alerta = "El usuario no esta disponible.";
            }
        }
    } else {
        $alerta = "El usuario o contraseña incorrectos.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link href="<?= constant("url") ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= constant("url") ?>css/blog-post.css" rel="stylesheet">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>img/logo.png">
</head>

<body>
    <div class="container">

        <div class="row">

            <div class="col-md-2">
                <img src="<?= constant("url") ?>img/logo.png" height="200" width="150">
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