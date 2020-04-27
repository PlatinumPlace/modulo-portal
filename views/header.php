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
    <!-- https://ionicons.com/ Icons -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant('url') ?>public/img/logo.png">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= constant('url') ?>"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('url') ?>">
                            <ion-icon name="bar-chart" size="small"></ion-icon> Panel de Control
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('url') ?>home/buscar">
                            <ion-icon name="search" size="small"></ion-icon> Buscar
                        </a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <ion-icon name="clipboard" size="small"></ion-icon> Cotizaciones
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= constant('url') ?>auto/crear">
                                Auto
                            </a>
                            <a class="dropdown-item disabled" href="#">
                                Incendio
                            </a>
                            <a class="dropdown-item disabled" href="#">
                                Vida
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <ion-icon name="stats-chart" size="small"></ion-icon> Reportes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item disabled" href="<?= constant('url') ?>reporte/poliza">
                                Póliza
                            </a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="return confirm('¿Deseas cerrar sesión?')" href="<?= constant('url') ?>login/cerrar_sesion">
                            <ion-icon name="lock-open" size="small"></ion-icon>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <br>