<h2 class="text-uppercase text-center">
    cotización No. <?= $oferta->getFieldValue('No_Cotizaci_n') ?>
    <br>
    seguro vehículo de motor
    <br>
    plan <?= $oferta->getFieldValue('Plan') ?>
</h2>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Opciones</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?= constant("url") ?>auto/detalles/<?= $oferta_id ?>">
                    <i class="tiny material-icons">details</i> Detalles
                </a>
            </li>
            <?php if ($oferta->getFieldValue('Email') == null) : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= constant("url") ?>auto/completar/<?= $oferta_id ?>">
                        <i class="tiny material-icons">content_paste</i> Completar
                    </a>
                </li>
            <?php else : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= constant("url") ?>auto/emitir/<?= $oferta_id ?>">
                        <i class="tiny material-icons">folder_shared</i> Emitir
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= constant("url") ?>auto/descargar/<?= $oferta_id ?>">
                        <i class="tiny material-icons">file_download</i> Descargar
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>

<br>