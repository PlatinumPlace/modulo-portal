<?php
$api = new api();
$filtro = $_GET['filter'];
$criterio = "Contact_Name:equals:" . $_COOKIE["usuario_id"];
$resultado = $api->searchRecordsByCriteria("Deals", $criterio);
?>
<table class="table">
    <thead>
        <tr>
            <th>Cotización No.</th>
            <th>RNC/Cédula</th>
            <th>Póliza</th>
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
                <?php if ($trato->getFieldValue("Stage") == $filtro and date("m", strtotime($trato->getFieldValue("Closing_Date"))) == date("m")) : ?>
                    <tr>
                        <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                        <td><?= $trato->getFieldValue('RNC_Cedula') ?></td>
                        <td>
                            <?php
                            if ($trato->getFieldValue('P_liza') == null) {
                                echo "No emitida";
                            } else {
                                echo $trato->getFieldValue('P_liza')->getLookupLabel();
                            }
                            ?>
                        </td>
                        <td><?= $trato->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $trato->getFieldValue("Stage") ?></td>
                        <td><?= date("d/m/Y", strtotime($trato->getFieldValue("Closing_Date"))) ?></td>
                        <td>
                            <a href="?page=details_auto&id=<?= $trato->getEntityId() ?>" title="Detalles"><i class="fas fa-info"></i></a>
                            <a href="?page=emit&id=<?= $trato->getEntityId() ?>" title="Emitir"><i class="fas fa-portrait"></i></a>
                            <a href="?page=download_auto&id=<?= $trato->getEntityId() ?>" title="Descargar"><i class="fas fa-download"></i></a>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>