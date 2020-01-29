<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $mensaje ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <a href="<?= $retVal = (!empty($resultado)) ? '?pagina=ver_cotizacion&id=' . $resultado["id"] : "?pagina=editar_cotizacion"; ?>" class="btn btn-primary">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<form method="post" action="?pagina=editar_cotizacion&id=<?= $oferta_id ?>">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Seguro</h1>
    </div>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <select name="plan" class="form-control">
                <option selected value="Mensual Full">Mensual Full</option>
                <option value="Mensual Full">Mensual Full</option>
                <option value="Anual Full">Anual Full</option>
                <option value="Mensual Ley">Mensual Ley</option>
                <option value="Anual Ley">Anual Ley</option>
            </select>
        </div>
        <div class="col-sm-6">
            <select name="poliza" class="form-control">
                <option selected value="Declarativa">Declarativa</option>
                <option value="Individual">Individual</option>
            </select>
        </div>
    </div>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Vehículo</h1>
    </div>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <select class="form-control" name="marca" id="marca" onchange="modelos(this.value)">
                <option selected>Selecciona una marca</option>
                <?php if (!empty($marcas)) : ?>
                    <?php foreach ($marcas as $marca) : ?>
                        <option value="<?= $marca->getEntityId() ?>"><?= $marca->getFieldValue('Name') ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </div>
        <div class="col-sm-6">
            <select class="form-control" name="modelo" id="modelo">
                <option selected>Selecciona un modelo</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
            <input type="text" class="form-control" name="Tipo_de_vehiculo" required>
        </div>
        <div class="col-sm-6">
            <input type="number" class="form-control" name="Valor_Asegurado" placeholder="Valor Asegurado" required>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
            <select name="A_o_de_Fabricacion" class="form-control">
                <?php
                $fecha_actual = date("d-m-Y");
                for ($i = 0; $i < 60; $i++) {
                    $valor = date("Y", strtotime($fecha_actual . "- " . $i . " year"));
                    echo '<option value="' . $valor . '">' . $valor . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-sm-6">
            <div class="form-control">
                <label>Es nuevo?</label>
                <input type="checkbox" name="estado" checked="checked" value="0" />
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block">Guardas cambios</button>
        <a href="?pagina=ver_cotizacion" class="btn btn-success btn-block">Cancelar</a>
    </div>
</form>