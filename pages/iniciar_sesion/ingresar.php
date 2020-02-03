<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar sesión</title>
</head>

<body style="background-color: grey">

    <div class="container">
        <br><br><br><br><br><br><br>
        <div class="row">
            <div class="col s12 m4 l2">
                &nbsp;
            </div>
            <div class="col s12 m6 l8 center">
                <div class="card">
                    <div class="row">
                        <form class="col s12" method="POST" action="index.php">
                            <div class="card-content">
                                <span class="card-title">Iniciar sesión</span>
                                <p class="red-text"><?= $retVal = (isset($mensaje)) ? $mensaje : ""; ?></p>
                                <div class="row">
                                    <div class="input-field col s12">
                                    <i class="material-icons prefix">account_circle</i>
                                        <input id="first_name" type="text" class="validate" name="usuario" required>
                                        <label for="first_name">Usuario</label>
                                    </div>
                                    <div class="input-field col s12">
                                    <i class="material-icons prefix">vpn_key</i>
                                        <input id="password" type="password" class="validate" name="clave" required>
                                        <label for="password">Contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn waves-effect waves-light" type="submit" name="action">Ingresar
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l2">
                &nbsp;
            </div>
        </div>
    </div>









    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>

</html>