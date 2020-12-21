<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> <?= (!empty($titulo)) ? $titulo : "IT - Insurance Tech" ?> </title>
    <link rel="icon" href="<?= base_url("favicon.ico") ?>" type="image/x-icon" />

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url("css/bootstrap.min.css") ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url("css/dashboard.css") ?>" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="<?= site_url() ?>">IT - Insurance Tech</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link active" href="<?= site_url("login/salir") ?>" onclick="return confirm('¿Deseas cerrar sesión?')"><?= session()->get("nombre") ?></a>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <div class="text-center">
                        <img src="<?= base_url("img/logo.png") ?>" alt="" width="150" height="150">
                    </div>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span><?= session("empresa") ?></span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url() ?>">
                                <span data-feather="home"></span>
                                Panel de control
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url("usuarios/editar") ?>">
                                <span data-feather="users"></span>
                                Cambiar contraseña
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Cotizaciones</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url("cotizaciones") ?>">
                                <span data-feather="bar-chart-2"></span>
                                Lista
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url("cotizaciones/cotizar") ?>">
                                <span data-feather="file"></span>
                                Cotizar
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Pólizas</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url("polizas") ?>">
                                <span data-feather="bar-chart-2"></span>
                                Lista
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url("polizas/reportes") ?>">
                                <span data-feather="file-text"></span>
                                Reportes
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="<?= base_url("js/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= base_url("js/dashboard.js") ?>"></script>
</body>

</html>