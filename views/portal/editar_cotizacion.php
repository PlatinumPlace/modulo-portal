<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Para Vehículos</button>
        </div>
    </div>
</div>
<form method="POST" class="row" action="index.php?pagina=editar&id=<?= $trato->getEntityId() ?>">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Póliza</h5>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Tipo</label>
                            <select name="poliza" class="form-control">
                                <option selected value="Declarativa">Declarativa</option>
                                <option value="Individual">Individual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Plan</label>
                            <select name="plan" class="form-control">
                                <option selected value="Mensual Full">Mensual Full</option>
                                <option value="Anual Full">Anual Full</option>
                                <option value="Mensual Ley">Mensual Ley</option>
                                <option value="Anual Ley">Anual Ley</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Vehículo</h5>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Marca</label>
                            <select name="marca" id="marca" class="form-control" onchange="obtener_modelos(this)" required>
                                <option value="" selected disabled>Selecciona una marca</option>
                                <?php foreach ($marcas as $marca) : ?>
                                    <option value="<?= $marca->getEntityId() ?>"><?= $marca->getFieldValue('Name') ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Modelo</label>
                            <select name="modelo" id="modelo" class="form-control" required>
                                <option value="" selected disabled>Selecciona un modelo</option>
                                <div id="modelo"></div>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Valor Asegurado</label>
                            <input class="form-control" type="number" name="Valor_Asegurado" value="<?= $trato->getFieldValue('Valor_Asegurado') ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Año de fabricación</label>
                            <input class="form-control" type="number" name="A_o_de_Fabricacion" required />
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Chasis</label>
                            <input class="form-control" type="text" name="chasis" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Color</label>
                            <input class="form-control" type="text" name="color" />
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Placa</label>
                            <input class="form-control" type="text" name="placa" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">¿Es nuevo?</label>
                            <input class="form-control" type="checkbox" name="estado" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Opciones</h5>
                <div class="form-row">
                    <div class="col-md-6">
                        <a href="index.php?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-primary btn-block">Volver a detalles</a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-block">Cotizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
</form>
<!-- Alerta 1 -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal"><?= $mensaje ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <a href="index.php?pagina=detalles&id=<?= $resultado['id'] ?>" class="btn btn-primary">Aceptar</a>
            </div>
        </div>
    </div>
</div>