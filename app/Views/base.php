<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url("css/bootstrap.min.css") ?>" rel="stylesheet">

    <title> <?= (!empty($titulo)) ? $titulo : "IT - Insurance Tech" ?> </title>
    <link rel="icon" href="<?= base_url("favicon.ico") ?>" type="image/x-icon" />
</head>

<body>
    <?= $this->renderSection('content') ?>
</body>

</html>