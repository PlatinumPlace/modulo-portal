<h1 class="mt-4">Editar Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></h1>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-body">
                <form method="POST" action="?pagina=editar&id=<?= $_GET['id'] ?>">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Tipo de póliza</label>
                                <select name="poliza" class="form-control">
                                    <option selected value="Declarativa">Declarativa</option>
                                    <option value="Individual">Individual</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Tipo de plan</label>
                                <select name="plan" class="form-control">
                                    <option selected value="Mensual Full">Mensual Full</option>
                                    <option value="Anual Full">Anual Full</option>
                                    <option value="Mensual Ley">Mensual Ley</option>
                                    <option value="Anual Ley">Anual Ley</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Marca del Vehículo</label>
                                <select name="marca" id="marca" class="form-control" onchange="obtener_modelos(this)">
                                    <option selected disabled>Selecciona una marca</option>
                                    <?php foreach ($marcas as $marca) : ?>
                                        <option value="<?= $marca->getEntityId() ?>"><?= $marca->getFieldValue('Name') ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Modelo del Vehículo</label>
                                <select name="modelo" id="modelo" class="form-control">
                                    <option selected disabled>Selecciona un modelo</option>
                                    <div id="modelo"></div>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Valor Asegurado</label>
                                <input class="form-control py-4" type="number" name="Valor_Asegurado" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Año de fabricación</label>
                                <input class="form-control py-4" type="number" name="A_o_de_Fabricacion" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Chasis</label>
                                <input class="form-control py-4" type="text" name="chasis" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Color</label>
                                <input class="form-control py-4" type="text" name="color" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Placa</label>
                                <input class="form-control py-4" type="text" name="placa" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">¿Es nuevo?</label>
                                <input class="form-control py-4" type="checkbox" name="estado" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Alerta -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal"><?= $mensaje ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <a href="?pagina=detalles&id=<?= $resultado['id'] ?>" class="btn btn-primary">Aceptar</a>
            </div>
        </div>
    </div>
</div>