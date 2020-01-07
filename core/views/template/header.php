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
                    <a href="#!" class="brand-logo">GNB Portal</a>
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
            <li><a href="api/install.php">Instalar API</a></li>
        </ul>

        <ul id="slide-out" class="sidenav sidenav-fixed">
            <li>
                <div class="user-view">
                    <div class="background">
                        &nbsp;
                    </div>
                    &nbsp;
                </div>
            </li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a href="index.php"><i class="material-icons">dashboard</i>Dashboard</a></li>
            <li><a href="?page=create"><i class="material-icons">create</i>Nueva cotizacion</a></li>
            <li><a href="api/install.php">Instalar API</a></li>
        </ul>
    </header>
    <main>