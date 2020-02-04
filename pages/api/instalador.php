<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ZOHO API</title>
</head>

<body>
    <h1>
        Crear una clave de <a href="https://accounts.zoho.com/developerconsole" target="_blank">client propio</a>.
    </h1>
    <p>(Nota:Usar la clave siguente dara al API acceso total al CRM, ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ)</p>
    <form action="index.php" method="post">
        <label>Codigo</label>
        <input type="text" name="grant_token">
        <br>
        <button type="submit">Generar token</button>
    </form>
    <?= $alerta = isset($mensaje) ?>
</body>

</html>