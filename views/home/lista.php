<table class="table">
    <thead>
        <tr>
            <th>Cotización No.</th>
            <th>RNC/Cédula</th>
            <th>Nombre del Asegurado</th>
            <th>Bien Asegurado</th>
            <th>Suma Asegurada</th>
            <th>Estado</th>
            <th>Fecha de cierre</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($resultado)) : ?>
            <?php foreach ($resultado as $trato) : ?>
                <?php if ($trato->getFieldValue("Stage") == $filtro and date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) : ?>
                    <tr>
                        <td><?= $trato->getFieldValue('No_Cotizaci_n')  ?></td>
                        <td><?= $trato->getFieldValue('RNC_Cedula') ?></td>
                        <td><?= $trato->getFieldValue('Nombre') . " " . $trato->getFieldValue('Apellido') ?></td>
                        <td><?= $trato->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $trato->getFieldValue("Stage") ?></td>
                        <td><?= date("d/m/Y", strtotime($trato->getFieldValue("Closing_Date"))) ?></td>
                        <td>
                            <a href="<?= constant('url') . $trato->getFieldValue('Type') ?>/detalles/<?= $trato->getEntityId() ?>" title="Detalles">
                                <ion-icon name="information-outline" size="small"></ion-icon>
                            </a>
                            <a href="<?= constant('url') . $trato->getFieldValue('Type') ?>/emitir/<?= $trato->getEntityId() ?>" title="Emitir">
                                <ion-icon name="person-sharp" size="small"></ion-icon>
                            </a>
                            <a href="<?= constant('url') . $trato->getFieldValue('Type') ?>/descargar/<?= $trato->getEntityId() ?>" title="Descargar">
                                <ion-icon name="download-sharp" size="small"></ion-icon>
                            </a>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>