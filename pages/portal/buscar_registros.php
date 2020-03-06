<?php
$tratos = new tratos();
if ($_POST) {
    $resultado = $tratos->buscar($_SESSION['usuario']['id'], $_POST['busqueda'], $_POST['parametro']);
} else {
    $resultado = $tratos->lista($_SESSION['usuario']['id']);
}
if (isset($_GET['action']) and $_GET['action'] == "delete") {
    $tratos->eliminar($_GET['id']);
    header("Location: index.php?page=details&id=" . $_GET['id']);
}
?>
<h1 class="mt-4">Buscar Registros</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Buscar</li>
</ol>


<form class="form-inline" method="POST" action="index.php?page=search">
    <div class="form-group mb-2">
        <select class="form-control" name="parametro" required>
            <option value="" disabled selected>Buscar por:</option>
            <option value="numero">No. de cotización</option>
            <option value="id">RNC/Cédula</option>
            <option value="poliza">Póliza</option>
        </select>
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="busqueda" required>
    </div>
    <button type="submit" class="btn btn-primary mb-2">Buscar</button>
</form>


<?php if ($_POST and empty($resultado)) : ?>
    <div class="alert alert-info" role="alert">
        No se encontraron registros
    </div>
<?php endif ?>


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
                <tr>
                    <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                    <td><?= $trato->getFieldValue('RNC_Cedula_del_asegurado') ?></td>
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
                        <a href="index.php?page=details&id=<?= $trato->getEntityId() ?>" title="Detalles"><i class="fas fa-info"></i></a>
                        <?php if ($trato->getFieldValue('Stage') != "Abandonado") : ?>
                            <a href="index.php?page=emit&id=<?= $trato->getEntityId() ?>" title="Emitir"><i class="fas fa-portrait"></i></a>
                            <a href="index.php?page=download&id=<?= $trato->getEntityId() ?>"  title="Descargar"><i class="fas fa-download"></i></a>
                        <?php endif ?>
                        <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                            <a href="index.php?page=edit&id=<?= $trato->getEntityId() ?>" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="index.php?page=search&action=delete&id=<?= $trato->getEntityId() ?>" onclick="return confirm('¿Estas seguro?');"><i class="fas fa-trash"></i></a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>