<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />


    <title>IT - Insurance Tech</title>
    <link rel="icon" type="image/png" href="img/portal/logo.png">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary oculto-impresion">
        <a title="Panel de Control" class="navbar-brand" href="index.php">IT - Insurance Tech</a>
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            &nbsp;
        </div>
        <a title="Cerrar Sesión" onclick="return confirm('¿Deseas cerrar la sesión?');" href="?page=logout" class="btn btn-primary">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark bg-primary" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link active" href="index.php">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            Panel de Control
                        </a>
                        <a class="nav-link active" href="?page=search">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            Buscar
                        </a>
                        <a class="nav-link active" href="?page=add">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            Cotizaciones
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <?php require_once("pages/router.php") ?>
                </div>
            </main>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/scripts.js"></script>
    <script src="js/jquery-2.1.1.min.js"></script>
</body>

</html>