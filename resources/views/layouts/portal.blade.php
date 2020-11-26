<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title',"IT - Insurance Tech")</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous">
    </script>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="{{ url('/') }}">IT - Insurance Tech</a>
        
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            &nbsp;
        </div>

        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" id="userDropdown" href="#" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ session('nombre') }}
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ url('usuario/editar') }}" >Cambiar contraseña</a>
                    <hr>
                        <a class="dropdown-item" href="{{ url('usuario/salir') }}"
                        onclick="return confirm('¿Deseas cerrar sesión?')">Cerrar sesión</a>
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
                            <img src="{{ url('img/logo.png') }}" alt="" width="150" height="150">
                        </div>

                        <div class="sb-sidenav-menu-heading">Core</div>

                        <a class="nav-link" href="{{ url('/') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Panel de control
                        </a>

                        <div class="sb-sidenav-menu-heading">Cotizaciones</div>

                        <a class="nav-link" href="{{ url('cotizaciones') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                            Buscar
                        </a>

                        <a class="nav-link" href="{{ url('cotizacion/crear') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Cotizar
                        </a>

                        <div class="sb-sidenav-menu-heading">Pólizas</div>

                        <a class="nav-link" href="{{ url('polizas') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                            Buscar
                        </a>

                        <a class="nav-link" href="{{ url('polizas/reporte') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Reportes
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <br>
                    @yield('content')
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Grupo Nobe {{ date('Y') }}</div>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
