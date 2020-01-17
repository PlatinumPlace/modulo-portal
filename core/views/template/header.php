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
            <nav class="blue">
                <div class="nav-wrapper">
                    <a href="index.php" class="brand-logo center">Logo</a>
                    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                </div>
            </nav>
        </div>


        <ul id="slide-out" class="sidenav sidenav-fixed">
            <!--
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="images/office.jpg">
                    </div>
                    <a href="#user"><img class="circle" src="images/yuna.jpg"></a>
                    <a href="#name"><span class="white-text name">John Doe</span></a>
                    <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a>
                </div>
            </li>
            -->
            <li><a href="index.php"><i class="material-icons">dashboard</i>Dashboard</a></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a class="subheader">Cotizaciones</a></li>
            <li><a class="waves-effect" href="?pagina=lista"><i class="material-icons">list</i>Lista</a></li>
            <li><a class="waves-effect" href="?pagina=crear_cotizacion"><i class="material-icons">create</i>Crear nueva</a></li>
        </ul>

    </header>

    <main>
        <div class="container">