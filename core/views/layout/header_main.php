<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">

    <link href="<?= constant("url") ?>public/template/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">

        <a class="navbar-brand" href="<?= constant("url") ?>">IT - Insurance Tech</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            &nbsp;
        </div>

        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" onclick="return confirm('¿Deseas cerrar sesión?')" href="<?= constant("url") ?>usuarios/cerrar_sesion">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <div class="sb-sidenav-menu-heading text-center">
                            <img src="<?= constant("url") ?>public/img/logo.png" height="100" width="100">
                        </div>


                        <div class="sb-sidenav-menu-heading"></div>

                        <a class="nav-link active" href="<?= constant("url") ?>">

                            <div class="sb-nav-link-icon">
                                <i class="fas fa-chart-area"></i>
                            </div>

                            Panel de Control
                        </a>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">

                            <div class="sb-nav-link-icon">
                                <i class="fas fa-book-open"></i>
                            </div>

                            Cotizaciones

                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= constant("url") ?>cotizaciones/crear">Crear</a>
                                <a class="nav-link" href="<?= constant("url") ?>cotizaciones/buscar">Buscar</a>
                                <a class="nav-link" href="<?= constant("url") ?>cotizaciones/exportar">Exportar</a>
                            </nav>
                        </div>
                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">