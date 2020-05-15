<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="public/css/blog-post.css" rel="stylesheet">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="public/img/logo.png">

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
                        <a class="nav-link" href="<?= constant('pagina_principal') ?>">
                            <i class="material-icons">assessment</i> Panel de Control
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('buscar_cotizaciones') ?>">
                            <i class="material-icons">search</i> Buscar
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('crear_cotizacion_auto') ?>">
                            <i class="material-icons">directions_car</i> Auto
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('exportar_cotizaciones') ?>">
                            <i class="material-icons">assignment</i> Reportes
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="return confirm('¿Deseas cerrar sesión?')" href="<?= constant('cerrar_sesion') ?>" title="Cerrar sesión">
                            <i class="material-icons">lock_open</i>
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
                <img src="public/img/logo.png" height="200" width="150">
            </div>
            <div class="col-md-10">