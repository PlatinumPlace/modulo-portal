<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="<?= constant("url") ?>">IT - Insurance Tech</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>


    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a href="<?= constant("url") ?>cerrar_sesion" class="nav-link" onclick="return confirm('¿Deseas cerrar Sesión?')"><?= $_SESSION["usuario"]['nombre'] ?></a>
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

                <h6 class="sidebar-heading">&nbsp;</h6>

                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link active" href="<?= constant("url") ?>">
                            <i class="fas fa-chart-area"></i>
                            Panel de Control
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= constant("url") ?>crear">
                            <i class="fas fa-plus-square"></i>
                            Crear Cotización
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= constant("url") ?>buscar"> <i class="fas fa-search"></i>
                            Buscar Cotización
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= constant("url") ?>reportes">
                            <i class="fas fa-book-open"></i>
                            Reportes
                        </a>
                    </li>

                </ul>

            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">