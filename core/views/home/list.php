<div class='container'>

    <h3 class="header">Cotizaciones Realizadas</h3>

    <hr>

    <table class="striped highlight responsive-table">
        <thead>
            <tr>
                <th>No. Aprobación</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($ofertas)) : ?>
                <?php foreach ($ofertas as $oferta_key => $oferta) : ?>
                    <?php if (in_array($oferta["Stage"], $estado)) : ?>
                        <?php $cotizaciones = $this->cotizaciones->buscar_por_trato($oferta['id']) ?>
                        <tr>
                            <td><?= $cotizaciones[0]['Quote_Number'] ?></td>
                            <td><?= $oferta["Stage"] ?></td>
                            <td><a href="?page=details&id=<?= $oferta['id'] ?>" data-tooltip="Ver detalles" class="tooltipped blue waves-effect waves-light btn-small btn-floating"><i class="material-icons left">details</i></a></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>