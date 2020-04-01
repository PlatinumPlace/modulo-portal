<h1 class="mt-4">Buscar Cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Buscar</li>
</ol>
<form class="form-inline" method="POST" action="<?= constant('url') ?>cotizacion/buscar">
    <div class="form-group mb-2">
        <select class="form-control" name="parametro" required>
            <option value="numero" selected>No. de cotización</option>
            <option value="id">RNC/Cédula</option>
        </select>
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="busqueda" required>
    </div>
    <button type="submit" class="btn btn-primary mb-2">Buscar</button>|
    <a href="<?= constant('url') ?>cotizacion/buscar" class="btn btn-info mb-2">Limpiar</a>
</form>
<?php if ($_POST and empty($this->resultado)) : ?>
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
        <?php if (!empty($this->resultado)) : ?>
            <?php foreach ($this->resultado as $trato) : ?>
                <tr>
                    <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                    <td>
                    <?php
                        if ($trato->getFieldValue('RNC_Cedula') == null) {
                            echo "N/A";
                        } else {
                            echo $trato->getFieldValue('RNC_Cedula');
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($trato->getFieldValue('P_liza') == null) {
                            echo "N/A";
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
                        <a href="<?= constant('url') ?>cotizacion/detalles/<?= $trato->getEntityId() ?>" title="Detalles"><i class="fas fa-info"></i></a>
                        <?php if ($trato->getFieldValue('Nombre') != null) : ?>
                            <a href="<?= constant('url') ?>cotizacion/emitir/<?= $trato->getEntityId() ?>" title="Emitir"><i class="fas fa-portrait"></i></a>
                            <a href="<?= constant('url') ?>cotizacion/descargar/<?= $trato->getEntityId() ?>" title="Descargar"><i class="fas fa-download"></i></a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>