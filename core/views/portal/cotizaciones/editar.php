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
                            <select name="poliza" class="custom-select">
                                <option selected value="Declarativa">Declarativa</option>
                                <option value="Individual">Individual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Plan</label>
                            <select name="plan" class="custom-select">
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
                            <select name="marca" id="marca" class="custom-select" onchange="obtener_modelos(this)" required>
                                <option value="" selected disabled>Selecciona un modelo</option>
                                <?php require("core/helpers/obtener_marcas.php") ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Modelo</label>
                            <select name="modelo" id="modelo" class="custom-select" required>
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
                            <label class="small mb-1">&nbsp;</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="estado" name="estado">
                                <label class="custom-control-label" for="estado">¿Es nuevo?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="mx-auto" style="width: 200px;">
        <button type="submit" class="btn btn-success btn-block">Cotizar</button>
        <a href="?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-primary btn-block">Cancelar</a>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
</form>
<!-- Alerta -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id=""><?= $mensaje ?></h5>
            </div>
            <div class="modal-footer">
                <a href="index.php?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-primary">Aceptar</a>
            </div>
        </div>
    </div>
</div>