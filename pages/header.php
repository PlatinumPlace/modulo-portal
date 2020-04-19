<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- https://ionicons.com/ Icons -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant('url') ?>public/img/logo.png">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="<?= constant('url') ?>">IT - Insurance Tech</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= constant('url') ?>">
                            <ion-icon name="bar-chart" size="small"></ion-icon> Panel de Control
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= constant('url') ?>home/buscar">
                            <ion-icon name="search" size="small"></ion-icon> Buscar
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <ion-icon name="clipboard" size="small"></ion-icon> Cotizaciones
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= constant('url') ?>auto/crear">
                                Para Auto
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= constant('url') ?>reporte/exportarCSV">
                            <ion-icon name="stats-chart"></ion-icon> Reportes
                        </a>
                    </li>
                </ul>
                <a title="Cerrar Sesión" onclick="return confirm('¿Deseas cerrar la sesión?');" href="<?= constant('url') ?>login/cerrar_sesion" class="btn btn-primary">
                    <ion-icon name="exit" size="large"></ion-icon>
                </a>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <br>