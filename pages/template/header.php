<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">

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
                        <a class="nav-link" href="<?= constant("url") ?>">
                            <i class="material-icons">assessment</i> Panel de Control
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant("url") ?>cotizaciones/buscar">
                            <i class="material-icons">search</i> Buscar
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant("url") ?>cotizaciones/exportar">
                            <i class="material-icons">assignment</i> Reportes
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant("url") ?>cotizaciones/crear">
                            <i class="material-icons">create</i> Cotizar
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="return confirm('¿Deseas cerrar sesión?')" href="<?= constant("url") ?>usuarios/cerrar_sesion" title="Cerrar sesión">
                            <i class="material-icons">lock_open</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <img src="<?= constant("url") ?>public/img/logo.png" height="180" width="150">
            </div>
            <div class="col-10">