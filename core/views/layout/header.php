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

    <body>

        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="<?= constant("url") ?>">IT - Insurance Tech</a>

            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a href="<?= constant("url") ?>usuarios/salir" class="nav-link" onclick="return confirm('¿Deseas cerrar sesión?')">
                        <?= $_SESSION["usuario"]['nombre'] ?>
                    </a>
                </li>
            </ul>

        </nav>

        <div class="container-fluid">
            <div class="row">

                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="sidebar-sticky pt-3">

                        <div class="text-center">
                            <img src="<?= constant("url") ?>public/icons/logo.png" height="100" width="100">
                        </div>

                        <br>

                        <ul class="nav flex-column">

                            <li class="nav-item">
                                <a class="nav-link" href="<?= constant("url") ?>">
                                    <i class="fas fa-chart-area"></i>
                                    Panel de Control
                                </a>
                            </li>

                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Cotizaciones</span>
                        </h6>

                        <ul class="nav flex-column">

                            <li class="nav-item">
                                <a class="nav-link" href="<?= constant("url") ?>cotizaciones/crear">
                                    <i class="fas fa-plus-square"></i>
                                    Crear
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= constant("url") ?>cotizaciones/buscar">
                                    <i class="fas fa-search"></i>
                                    Buscar
                                </a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Pólizas</span>
                        </h6>

                        <ul class="nav flex-column">

                            <li class="nav-item">
                                <a class="nav-link" href="<?= constant("url") ?>polizas/reportes"> 
                                    <i class="fas fa-book-open"></i>
                                    Reportes
                                </a>
                            </li>

                        </ul>

                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">