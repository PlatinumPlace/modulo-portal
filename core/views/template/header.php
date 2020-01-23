<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title>GNB - Portal</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link  rel="icon"   href="logo.png" type="image/png" />
</head>

<body>

    <header>

        <!-- Dropdown Structure -->
        <!--
        <ul id="dropdown1" class="dropdown-content">
            <li><a href="#!">two</a></li>
            <li class="divider"></li>
            <li><a href="#!">three</a></li>
        </ul>
         -->

        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper blue">
                    <a href="index.php" class="brand-logo center">Portal</a>
                    <!--
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    -->
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li><a href="index.php"><i class="material-icons tooltipped" data-tooltip="Dashboard">view_module</i></a></li>
                        <li><a href="?pagina=crear_cotizacion"><i class="material-icons tooltipped" data-tooltip="Nueva cotización">add</i></a></li>
                        <li><a href="?pagina=buscar_cotizaciones"><i class="material-icons tooltipped" data-tooltip="Buscar cotización">search</i></a></li>
                    </ul>
                    <!-- 
                    <ul class="right hide-on-med-and-down">
                        <li><a href="sass.html"><i class="material-icons">search</i></a></li>
                        <li><a href="badges.html"><i class="material-icons">view_module</i></a></li>
                        <li><a href="collapsible.html"><i class="material-icons">refresh</i></a></li>
                        <li><a href="mobile.html"><i class="material-icons">more_vert</i></a></li>
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Dropdown<i class="material-icons right">arrow_drop_down</i></a></li>
                    </ul>
                     -->
                </div>
            </nav>
        </div>

        <!-- Mobile Menu -->
        <!-- 
        <ul class="sidenav" id="mobile-demo">
            <li><a href="sass.html">Sass</a></li>
            <li><a href="badges.html">Components</a></li>
            <li><a href="collapsible.html">Javascript</a></li>
            <li><a href="mobile.html">Mobile</a></li>
        </ul>
        -->

    </header>

    <main>
        <div class="container">