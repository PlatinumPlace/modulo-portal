<?php

include "models/api_model.php";
include "api/vendor/autoload.php";

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;


$mensaje = "";
if ($_POST) {
    $api = new api_model;
    ZCRMRestClient::initialize($api->configuration);
    $criterio = "((Usuario:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
    $contactos = $api->searchRecordsByCriteria("Contacts", $criterio);
    if (!empty($contactos)) {
        foreach ($contactos as $contacto) {
            if ($contacto->getFieldValue("Estado") == true) {
                session_start();
                $_SESSION["usuario"]["nombre"] = $contacto->getFieldValue("First_Name");
                $_SESSION["usuario"]["id"] = $contacto->getEntityId();
                header("Location: index.php");
            } else {
                $mensaje = "El usuario no esta activado.";
            }
        }
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
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
    <link rel="icon" type="image/png" href="img/portal/logo.png">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header text-center font-weight-light my-4">
                                    <h3>IT - Insurance Tech</h3>
                                    <p><?= $mensaje ?></p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="login.php">
                                        <div class="form-group">
                                            <label class="small mb-1">Usuario</label>
                                            <input class="form-control py-4" type="text" name="usuario" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Contraseña</label>
                                            <input class="form-control py-4" type="password" name="clave" />
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
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            Copyright &copy; Grupo Nobe <?= date('Y') ?>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>