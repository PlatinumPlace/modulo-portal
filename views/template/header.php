<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="<?= constant('url') ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= constant('url') ?>public/css/blog-post.css" rel="stylesheet">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant('url') ?>public/img/logo.png">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('url') ?>">
                            <i class="tiny material-icons">dashboard</i> Panel de Control
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('url') ?>cotizaciones/buscar" title="ssss">
                            <i class="tiny material-icons">search</i> Buscar
                        </a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="tiny material-icons">payment</i> Cotizaciones
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= constant('url') ?>cotizaciones/crear_auto">
                                Auto
                            </a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('url') ?>reportes/index">
                            <i class="tiny material-icons">event</i> Reportes
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="return confirm('¿Deseas cerrar sesión?')" href="<?= constant('url') ?>usuarios/salir" title="Cerrar sesión">
                            <i class="tiny material-icons">lock_open</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
&nbsp;
            </div>
            <div class="col-md-10">