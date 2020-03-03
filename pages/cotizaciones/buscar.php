<?php
$tratos = new tratos();
if ($_POST) {
    $resultado = $tratos->buscar($_SESSION['usuario']['id'], $_POST['busqueda'], $_POST['parametro']);
} else {
    $resultado = $tratos->lista($_SESSION['usuario']['id']);
}
?>
<div class="section no-pad-bot" id="index-banner">
    <h2 class="header center blue-text">Buscar Cotización</h2>
</div>

<div class="row">

    <div class="col s12">
        <div class="card">
            <div class="row">
                <form class="col s12" method="POST" action="index.php?page=search">
                    <div class="card-content">
                        <div class="row">
                            <div class="input-field col s4">
                                <select name="parametro">
                                    <option value="numero" selected>No. de cotización</option>
                                    <option value="nombre">Nombre del cliente</option>
                                </select>
                                <label>Buscar por:</label>
                            </div>
                            <div class="input-field col s8">
                                <input name="busqueda" type="text" class="validate" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn waves-effect waves-light" type="submit" name="action">Buscar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($_POST and empty($resultado)) : ?>
        <div class="row">
            <div class="col s6 m4 right">
                <div class="card-panel red">
                    <span class="white-text">
                        No se encontraron registros
                    </span>
                </div>
            </div>
        </div>
    <?php endif ?>

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
            <?php if (!empty($resultado)) : ?>
                <?php foreach ($resultado as $trato) : ?>
                    <tr>
                        <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                        <td><?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?></td>
                        <td><?= $trato->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $trato->getFieldValue("Stage") ?></td>
                        <td><?= date("d/m/Y", strtotime($trato->getFieldValue("Closing_Date"))) ?></td>
                        <td>
                            <a href="index.php?page=details&id=<?= $trato->getEntityId() ?>" class="green btn-floating waves-effect waves-light btn-small tooltipped" data-position="bottom" data-tooltip="Detalles"><i class="material-icons left">info</i></a>
                            <?php if ($trato->getFieldValue('Stage') != "Abandonado") : ?>
                                <a href="index.php?page=emit&id=<?= $trato->getEntityId() ?>" class="blue btn-floating waves-effect waves-light btn-small tooltipped" data-position="bottom" data-tooltip="Emitir"><i class="material-icons left">description</i></a>
                                <a href="index.php?page=download&id=<?= $trato->getEntityId() ?>" class="btn-floating waves-effect waves-light btn-small tooltipped" data-position="bottom" data-tooltip="Descargar"><i class="material-icons left">file_download</i></a>
                            <?php endif ?>
                            <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                                <a href="index.php?page=edit&id=<?= $trato->getEntityId() ?>" class="yellow btn-floating waves-effect waves-light btn-small tooltipped" data-position="bottom" data-tooltip="Editar"><i class="material-icons left">edit</i></a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

</div>