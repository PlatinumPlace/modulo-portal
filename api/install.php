<?php

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;


if (file_exists("config.php")) {
    require 'config.php';
    $client_id = $configuration['client_id'];
    $client_secret = $configuration['client_secret'];
    $redirect_uri = $configuration['redirect_uri'];
}


if ($_POST['client_id']) {

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
if ($_POST['grant_token']) {
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
    $mensaje = "Token generado.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Install ZOHO API</title>
</head>
<body>
<h1>Primero: Registrar la aplicaion en
    <a href="https://accounts.zoho.com/developerconsole" target="_blank">zoho</a>.
</h1>
<hr>
<h1>Segundo: Crear el archivo config.php.</h1>
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
</body>
<hr>
    <h1>
    Tercero: En la aplicacion ya registrada,crear una clave de <a href="https://accounts.zoho.com/developerconsole" target="_blank">client propio</a>.
    </h1>
    <p>(Nota:Usar la clave siguente dara al API acceso total al CRM, ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ)</p>
    <form action="install.php" method="post">
        <label>Codigo</label>
        <input type="text" name="grant_token">
        <br>
        <button type="submit">Generar token</button>
    </form>
    <?= $alerta = isset($mensaje)?>
    <br>
    <a href="../index.php">Ir a index.php</a>
</html>