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
</head>

<body>

    <header>

        <div class="navbar-fixed">

            <nav>
                <div class="nav-wrapper blue">

                    <a href="index.php" class="brand-logo center">Portal</a>

                    <!-- Menu izquierdo -->
                    <!-- dropdown1 Structure -->
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="?page=create">Nueva cotizacion</a></li>
                    </ul>
                    <!-- dropdown1 Structure -->
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li><a href="index.php">Dashboard</a></li>
                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Cotizaciones<i class="material-icons right">arrow_drop_down</i></a></li>
                    </ul>
                    <!-- Menu izquierdo -->



                    <!-- Menu derecho -->

                    <ul id="nav-mobile" class="right hide-on-med-and-down">

                    </ul>
                    <!-- Menu derecho -->

                    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                </div>
            </nav>

        </div>

        <ul class="sidenav" id="mobile-demo">
            <li><a href="index.php">Dashboard</a></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a class="subheader">Cotizaciones</a></li>
            <li><a href="?page=create">Nueva cotizacion</a></li>
        </ul>
    </header>

    <main>
