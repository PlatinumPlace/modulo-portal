<?php
$tratos = new tratos();
$filtro = $_GET['filter'];
$tratos = $tratos->lista($_SESSION['usuario']['id']);
?>
<div class="row">
    <table class="col s12 striped highlight">
        <thead>
            <tr>
                <th>Cotización No.</th>
                <th>Nombre del cliente</th>
                <th>Bien Asegurado</th>
                <th>Suma Asegurada</th>
                <th>Estado</th>
                <th>Fecha de cierre</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($tratos)) : ?>
                <?php foreach ($tratos as $trato) : ?>
                    <?php if (isset($filtro) and $trato->getFieldValue("Stage") == $filtro or date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date("Y-m")) : ?>
                        <tr>
                            <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                            <td><?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?></td>
                            <td><?= $trato->getFieldValue('Type')  ?></td>
                            <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                            <td><?= $trato->getFieldValue("Stage") ?></td>
                            <td><?= date("d/m/Y", strtotime($trato->getFieldValue("Closing_Date"))) ?></td>
                            <td>
                                <a href="index.php?page=details&id=<?= $trato->getEntityId() ?>" class="green btn-floating waves-effect waves-light btn-small tooltipped" data-position="bottom" data-tooltip="Detalles"><i class="material-icons left">info</i></a>
                                <a href="index.php?page=emit&id=<?= $trato->getEntityId() ?>" class="blue btn-floating waves-effect waves-light btn-small tooltipped" data-position="bottom" data-tooltip="Emitir"><i class="material-icons left">description</i></a>
                                <a href="index.php?page=download&id=<?= $trato->getEntityId() ?>" class="btn-floating waves-effect waves-light btn-small tooltipped" data-position="bottom" data-tooltip="Descargar"><i class="material-icons left">file_download</i></a>
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>