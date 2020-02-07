<h1 class="mt-4">Buscar Cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item active">Busca Cotización</li>
</ol>
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="?pagina=buscar">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1">Nombre del Cliente</label>
                        <input class="form-control py-4" type="text" name="busqueda" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1">Buscar por:</label>
                        <select name="parametro" class="form-control">
                            <option selected value="numero">No. de cotización</option>
                            <option value="nombre">Nombre del cliente</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. de cotización</th>
                        <th>Nombre del cliente</th>
                        <th>Bien Asegurado</th>
                        <th>Suma Asegurada</th>
                        <th>Estado</th>
                        <th>Fecha de cierre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No. de cotización</th>
                        <th>Nombre del cliente</th>
                        <th>Bien Asegurado</th>
                        <th>Suma Asegurada</th>
                        <th>Estado</th>
                        <th>Fecha de cierre</th>
                        <th>Opciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($tratos)) : ?>
                        <?php foreach ($tratos as $trato) : ?>
                            <tr>
                                <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                                <td><?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?></td>
                                <td><?= $trato->getFieldValue('Type')  ?></td>
                                <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                <td><?= $trato->getFieldValue("Stage") ?></td>
                                <td><?= $trato->getFieldValue("Closing_Date") ?></td>
                                <td>
                                    <a href="?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light blue tooltipped" data-position="bottom" data-tooltip="Detalles"><i class="material-icons">details</i></a>
                                    <?php if ($trato->getFieldValue('Activo') == true and $trato->getFieldValue('Aseguradora') == null) : ?>
                                        <a href="?pagina=emitir&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Emitir"><i class="material-icons">recent_actors</i></a>
                                        <a href="?pagina=editar&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light yellow tooltipped" data-position="bottom" data-tooltip="Editar"><i class="material-icons">edit</i></a>
                                    <?php endif ?>
                                    <a class="btn-floating btn-small waves-effect waves-light green tooltipped" data-position="bottom" data-tooltip="Descargar" href="?page=download&id=<?= $trato->getEntityId() ?>"><i class="material-icons">cloud_download</i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>