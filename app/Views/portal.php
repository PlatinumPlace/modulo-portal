<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?= base_url("css/styles.css") ?>" rel="stylesheet" />

    <title>IT - Insurance Tech</title>
    <link rel="icon" href="<?= base_url("favicon.ico") ?>" type="image/x-icon" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="<?= site_url() ?>">IT - Insurance Tech</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            &nbsp;
        </div>

        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i> </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?= site_url("usuarios/clave") ?>">Cambiar contraseña</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url("login/logout") ?>" onclick="return confirm('¿Continuar?')">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="text-center">
                            <img src="<?= base_url("img/logo.png") ?>" alt="" width="150" height="150">
                        </div>

                        <div class="sb-sidenav-menu-heading">&nbsp;</div>
                        <a class="nav-link" href="<?= site_url() ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Panel de control
                        </a>

                        <div class="sb-sidenav-menu-heading">Cotizaciones</div>
                        <a class="nav-link" href="<?= site_url("cotizaciones") ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Lista
                        </a>

                        <a class="nav-link" href="<?= site_url("cotizaciones/cotizar") ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Cotizar
                        </a>

                        <div class="sb-sidenav-menu-heading">Pólizas</div>
                        <a class="nav-link" href="<?= site_url("polizas") ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Lista
                        </a>

                        <a class="nav-link" href="<?= site_url("polizas/reportes") ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Reportes
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small"><?= session("empresa") ?></div>
                    <?= session()->get("nombre") ?>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Grupo Nobe <?= date("Y") ?></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url("assets/demo/datatables-demo.js") ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <script src="<?= base_url("js/scripts.js") ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>