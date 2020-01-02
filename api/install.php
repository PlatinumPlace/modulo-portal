<?php

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;


if (file_exists("config.php")) {
    require 'config.php';
    $client_id = $configuration['client_id'];
    $client_secret = $configuration['client_secret'];
    $redirect_uri = $configuration['redirect_uri'];
}


if (isset($_POST['client_id'])) {

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
        "token_persistence_path" =>dirname(__FILE__). "/token"
    );
    ZCRMRestClient::initialize($configuration);
    ?>';

    fwrite($config, $php);
    fclose($config);
}
if (isset($_POST['grant_token'])) {
    $carpeta = dirname(__FILE__) . "/token";
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    $authTokenFile = fopen("token/zcrm_oauthtokens.txt", "w+");
    fwrite($authTokenFile, '');
    fclose($authTokenFile);
    ZCRMRestClient::initialize($configuration);
    $oAuthClient = ZohoOAuth::getClientInstance();
    $grantToken = $_POST['grant_token'];
    $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instalador de ZOHO API</title>
</head>

<body>
    <h2>Antes de empezar,instala/actualiza el PHP SDK de zoho en tudominio/api</h2>
    <h3>Primero: ingresa <a href="https://accounts.zoho.com/developerconsole" target="_blank">aqui</a> para registrar la aplicacion en zoho.com.</h3>
    <p>(Nota: tu URIs de redireccionamiento autorizados es: tudominio/api/install.php)</p>
    <hr>
    <h3>Segundo: completas el formulario para crear el archivo config.php.</h3>
    <form method="POST" action="install.php">
        <label>ID de cliente</label>
        <input type="text" name="client_id" required>
        <br>
        <label>Secreto del cliente</label>
        <input type="text" name="client_secret" required>
        <br>
        <label>URIs de redireccionamiento autorizados</label>
        <input type="text" name="redirect_uri" required>
        <br>
        <label>Email de tu cuenta de zoho</label>
        <input type="email" name="currentUserEmail" required>
        <br>
        <button type="submit">Crear</button>
    </form>
    <hr>
    <h3><a href="https://accounts.zoho.com/developerconsole" target="_blank">Vuelve a ingresar aqui</a> y crear un codigo de cliente propio.</h3>
    <p>(Nota: Puedes usar como scope: ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ)</p>
    <form action="install.php" method="post">
        <label>Codigo</label>
        <input type="text" name="grant_token">
        <br>
        <button type="submit">Generar token</button>
    </form>
    <?php
    $archivo = "token/zcrm_oauthtokens.txt";
    if (filesize($archivo) > 0) {
        echo '
        <hr>
        <h4>Token generado exitosamente.</h4>
        <p><a href="../index.php">Finalizar</a></p>
        ';
    }
    ?>
</body>

</html>