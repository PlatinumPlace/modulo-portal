<?php
if ($_POST) {
    $resultado = validar();
    echo '<script>alert("' . $resultado . '")</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/styles.css" rel="stylesheet" />

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="img/portal/logo.png">
</head>

<body class="bg-primary">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">IT - Insurance Tech</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="login.php">
                                <div class="form-group">
                                    <label class="small mb-1">Usuario</label>
                                    <input class="form-control py-4" type="text" name="usuario" required />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1">Contraseña</label>
                                    <input class="form-control py-4" type="password" name="clave" required />
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
    </main>
    <footer class="py-4 bg-light mt-auto fixed-bottom">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Grupo Nobe <?= date('Y') ?></div>
            </div>
        </div>
    </footer>

    <script src="js/scripts.js"></script>
    <script src="js/jquery-2.1.1.min.js"></script>
</body>

</html>