<?php
$alerta = $datos;
?>
<h1 class="text-center">
    <?php if (!empty($alerta)) : ?>
        <?= $alerta ?>
    <?php else : ?>
        Ha ocurrido un error
    <?php endif ?>
</h1>

<center>
    <a href="<?= constant('url') ?>index.php" class="btn btn-info">Ir a inicio</a>
</center>