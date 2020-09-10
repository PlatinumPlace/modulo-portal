<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <title>IT - Insurance Tech</title>

    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/icons/logo.png">
</head>

<body class="bg-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">

                <?php if (isset($_GET["alert"])) : ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $_GET["alert"] ?>
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
                                <label class="small mb-1 font-weight-bold">Usuario</label>

                                <input class="form-control py-4" type="email" name="email" required />
                            </div>

                            <div class="form-group">
                                <label class="small mb-1 font-weight-bold">Contraseña</label>

                                <input class="form-control py-4" type="password" name="pass" required />
                            </div>

                            <button class="btn btn-primary" type="submit">Ingresar</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

    <footer class="py-4 bg-light mt-auto fixed-bottom">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; GrupoNobe <?= date("Y") ?></div>
            </div>
        </div>
    </footer>

</body>

</html>