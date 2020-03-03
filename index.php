<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="all" />
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all" />

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="img/portal/logo.png">
</head>

<body>
    <header>
        <nav class="oculto-impresion">
            <div class="nav-wrapper blue">
                <a href="index.php" class="brand-logo center">IT - Insurance Tech</a>
                <?php if (isset($_SESSION["usuario"])) : ?>
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li><a href="?page=add" class="tooltipped" data-position="bottom" data-tooltip="Crear Cotización"><i class="material-icons">add</i></a></li>
                        <li><a href="?page=search" class="tooltipped" data-position="bottom" data-tooltip="Buscar Cotización"><i class="material-icons">search</i></a></li>
                    </ul>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="#cerrar_sesion" class="modal-trigger tooltipped" data-position="bottom" data-tooltip="Cerrar Sesión"><i class="material-icons">exit_to_app</i></a></li>
                    </ul>
                <?php endif ?>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <?php require_once("pages/router.php") ?>
        </div>
    </main>

    <footer class="page-footer blue oculto-impresion">
        <div class="footer-copyright">
            <div class="container">
                Copyright &copy; Grupo Nobe <?= date('Y') ?>
            </div>
        </div>
    </footer>

    <div id="cerrar_sesion" class="modal">
        <div class="modal-content">
            <h4>Estas seguro de continuar?</h4>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">No</a>
            <a href="?page=logout" class="modal-close waves-effect waves-green btn-flat">Si</a>
        </div>
    </div>

    <!--  Scripts-->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/init.js"></script>

</body>

</html>

