<?php

use zcrmsdk\oauth\ZohoOAuth;


if (file_exists("config.php")) {
    require 'config.php';
    $client_id = $configuration['client_id'];
    $redirect_uri = $configuration['redirect_uri'];
}


if ($_POST) {

    // Creamos el archivo config.php. Si ya existe,lo modificamos.
    $config = fopen("config.php", "w+") or die("No se puede abrir/crear el archivo!");
    $php = '<?php 
    use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
    require "vendor/autoload.php";
    $configuration = array(
        "client_id" => "' . $_POST['client_id'] . '",
        "client_secret" => "' . $_POST['client_secret'] . '",
        "redirect_uri" => "' . $_POST['redirect_uri'] . '",
        "currentUserEmail" => "' . $_POST['currentUserEmail'] . '",
        "token_persistence_path" =>dirname(__FILE__). "/token/"
    );
    ZCRMRestClient::initialize($configuration);
    ?>';

    fwrite($config, $php);
    fclose($config);

    if (isset($_GET['code'])) {
        // Creamos el txt donde se guardara el token. Si ya existe,lo formateamos.
        $authTokenFile = dirname(__FILE__) . "/token/zcrm_oauthtokens.txt";
        $fp = fopen($authTokenFile, 'w');
        fwrite($fp, '');
        fclose($fp);
        $oAuthClient = ZohoOAuth::getClientInstance();
        $grantToken = $_GET['code'];
        $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Instalador de ZOHO API</title>
</head>

<body>
    <div class="container">
        <?php if (isset($_GET['code'])) : ?>

            <div class="alert alert-primary" role="alert">
                Token generado exitosamente.
            </div>

        <?php endif ?>
        <h3>Primero: ingresa <a href="https://accounts.zoho.com/developerconsole' target='_blank'">aqui</a> para registrar la aplicacion en zoho.com.</h3>
        <p>(Nota: tu URIs de redireccionamiento autorizados es: tudominio/zohoapi/install.php)</p>
        <br>
        <h3>Segundo: completas el formulario para crear el archivo config.php.</h3>
        <form method="POST" action="install.php">
            <div class="form-group">
                <label>ID de cliente</label>
                <input type="text" class="form-control" name="client_id" required>
            </div>
            <div class="form-group">
                <label>Secreto del cliente</label>
                <input type="text" class="form-control" name="client_secret" required>
            </div>
            <div class="form-group">
                <label>URIs de redireccionamiento autorizados</label>
                <input type="text" class="form-control" name="redirect_uri" required>
            </div>
            <div class="form-group">
                <label>Email de tu cuenta de zoho</label>
                <input type="text" class="form-control" name="currentUserEmail" required>
            </div>
            <button type="submit" class="btn btn-primary">Instalar</button>
        </form>
        <br>
        <?php if (file_exists("config.php") && isset($_POST)) : ?>
            <h3>Tercero: ingresa <a href="https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ&client_id=<?= $client_id ?>&response_type=code&access_type=offline&prompt=consent&redirect_uri=<?= $redirect_uri ?>">aqui</a> para generar el token y guardarlo.</h3>
        <?php endif ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>