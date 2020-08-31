<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización auto</h1>
</div>


<form method="POST" action="<?= constant("url") ?>?page=crear&type=auto">

    <h4>Cliente</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label><b>Nombre</b></label>
            <input required type="text" class="form-control" name="nombre">
        </div>

        <div class="form-group col-md-6">
            <label><b>RNC/Cédula</b></label>
            <input type="text" class="form-control" name="rnc_cedula">
        </div>

    </div>

    <br>
    <h4>Vehículo</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-4">
            <label><b>Marca</b></label>
            <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)" required>
                <option value="" selected disabled>Selecciona una Marca</option>
                <?php
                sort($lista_marcas);
                foreach ($lista_marcas as $marca) {
                    echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label><b>Modelos</b></label>
            <select class="form-control" name="modelo" id="modelo" required>
                <option value="" selected disabled>Selecciona un Modelo</option>
                <div id="modelo"></div>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label><b>Año de fabricación</b></label>
            <input required type="number" class="form-control" name="fabricacion" maxlength="4">
        </div>

    </div>

    <br>
    <h4>Plan</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-4">
            <label><b>Valor Asegurado</b></label>
            <input required type="number" class="form-control" name="valor">
        </div>

        <div class="form-group col-md-4">
            <label><b>Tipo</b></label>
            <select name="tipo_plan" class="form-control">
                <option value="Plan Full" selected>Full</option>
                <option value="Plan Ley">Ley</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label><b>Facturación</b></label>
            <select name="facturacion" class="form-control">
                <option value="Mensual" selected>Mensual</option>
                <option value="Anual">Anual</option>
            </select>
        </div>
    </div>

    <br>
    <button type="submit" class="btn btn-success">Crear</button>
    |
    <a href="<?= constant("url") ?>?page=crear" class="btn btn-info">Cancelar</a>

</form>

<script>
    function obtener_modelos(val) {
        var url = "<?= constant("url") ?>";
        $.ajax({
            url: url + "helpers/lista_modelos.php",
            type: "POST",
            data: {
                marcas_id: val.value
            },
            success: function(response) {
                document.getElementById("modelo").innerHTML = response;
            }
        });
    }
</script>