<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant('url') ?>public/img/logo.png">
</head>

<body class="bg-primary">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <br>
                    <?php if (isset($_POST['submit'])) : ?>
                        <div class="alert alert-primary" role="alert">
                            <?= $alerta ?>
                        </div>
                    <?php endif ?>
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <form method="POST" action="<?= constant('url') ?>login">
                                <div class="form-group">
                                    <label class="small mb-1">Usuario</label>
                                    <input class="form-control py-4" type="text" name="usuario" required />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1">Contraseña</label>
                                    <input class="form-control py-4" type="password" name="clave" required />
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
    </main>
    <footer class="py-4 bg-light mt-auto fixed-bottom">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Grupo Nobe <?= date('Y') ?></div>
            </div>
        </div>
    </footer>
</body>

</html>