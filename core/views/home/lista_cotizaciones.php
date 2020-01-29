<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buscar</h1>
</div>

<form method="post" action="?pagina=lista_cotizaciones">
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <input type="text" class="form-control form-control-user" placeholder="Buscar" name="busqueda">
        </div>
        <div class="col-sm-4">
            <select class="form-control" name="opcion">
                <option value="nombre" selected>Nombre del cliente</option>
                <!--
                    <option value="numero">No. de cotización</option>
                    -->
            </select>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary btn-circle">
                <i class="fas fa-search"></i>
            </button>
            <a href="?pagina=lista_cotizaciones" class="btn btn-secondary btn-circle">
                <i class="fas fa-redo"></i>
            </a>
        </div>
    </div>
</form>
<div class="card shadow mb-4">
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
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ofertas)) : ?>
                        <?php foreach ($ofertas as $oferta) : ?>
                                <?php $criterio = "Deal_Name:equals:" . $oferta->getEntityId() ?>
                                <?php $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio) ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($cotizaciones)) : ?>
                                            <?php foreach ($cotizaciones as $cotizacion) : ?>
                                                <?= $cotizacion->getFieldValue('Quote_Number') ?>
                                                <?php break ?>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </td>
                                    <td><?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?></td>
                                    <td><?= $oferta->getFieldValue('Type')  ?></td>
                                    <td>RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                    <td><?= $oferta->getFieldValue("Stage") ?></td>
                                    <td>
                                        <a href="?pagina=emitir_cotizacion&id=<?= $oferta->getEntityId() ?>" title="Emitir" class="btn btn-primary btn-circle btn-sm"><i class="far fa-id-card"></i></a>
                                        <a href="?pagina=ver_cotizacion&id=<?= $oferta->getEntityId() ?>" title="Detalles" class="btn btn-info btn-circle btn-sm"><i class="fas fa-info"></i></a>
                                        <?php if ($oferta->getFieldValue('Aseguradora') == null) : ?>
                                            <a href="?pagina=editar_cotizacion&id=<?= $oferta->getEntityId() ?>" title="Editar" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                            <button title="Eliminar" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#Modal"><i class="fas fa-trash"></i></button>
                                        <?php endif ?>
                                        <a href="?pagina=descargar_cotizacion&id=<?= $oferta->getEntityId() ?>" title="Descargar" class="btn btn-success btn-circle btn-sm"><i class="fas fa-file-download"></i></a>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Estas seguro?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <a href="?pagina=eliminar_cotizacion&origen=buscar_cotizacion&id=<?= $oferta->getEntityId() ?>" class="btn btn-danger">Continuar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>