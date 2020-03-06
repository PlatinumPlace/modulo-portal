<?php
$tratos = new tratos();
$trato = $tratos->detalles($_GET['id']);
if ($_POST) {
    $resultado = $tratos->editar($_GET['id']);
}
?>
<h1 class="mt-4">Editar Cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Editar</li>
    <li class="breadcrumb-item active">Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<form method="POST" action="index.php?page=edit&id=<?= $trato->getEntityId() ?>">

        <input hidden value="<?= $resultado["id"] ?>" id="id">

        <h5>Tipo de Cotización</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Póliza</label>
            <div class="col-sm-4">
                <select name="poliza" class="form-control">
                    <option selected value="Declarativa">Declarativa</option>
                    <option value="Individual">Individual</option>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">Para</label>
            <div class="col-sm-4">
                <select name="cotizacion" class="form-control">
                    <option value="Auto" selected>Auto</option>
                    <option value="Vida">Vida</option>
                    <option value="Incendio Hipotecario">Incendio Hipotecario</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Plan</label>
            <div class="col-sm-4">
                <select name="plan" class="form-control">
                    <option selected value="Mensual Full">Mensual Full</option>
                    <option value="Anual Full">Anual Full</option>
                    <option value="Ley">Ley</option>
                    <option value="Ley">Simple</option>
                </select>
            </div>
        </div>
        <hr>
        <h5>Datos de Vehículo</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Marca</label>
            <div class="col-sm-4">
                <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)" required>
                    <option value="" selected disabled>Selecciona una Marca</option>
                    <?php require("helpers/obtener_marcas.php") ?>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">Modelo</label>
            <div class="col-sm-4">
                <select class="form-control" name="modelo" id="modelo" required>
                    <option value="" selected disabled>Selecciona un Modelo</option>
                    <div id="modelo"></div>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Valor Asegurado</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" name="Valor_Asegurado" required>
            </div>
            <label class="col-sm-2 col-form-label">Año de fabricación</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" name="A_o_de_Fabricacion" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Chasis</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="chasis">
            </div>
            <label class="col-sm-2 col-form-label">Color</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="color">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Uso</label>
            <div class="col-sm-4">
                <select name="uso" class="form-control">
                    <option selected value="Privado">Privado</option>
                    <option value="Publico">Publico</option>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">Placa</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="placa">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">¿Es nuevo?</div>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="estado">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Cotizar</button>
            </div>
        </div>
    </form>

<script>
    function obtener_modelos(val) {
        {
            $.ajax({
                url: "helpers/obtener_modelos.php",
                type: "POST",
                data: {
                    marcas_id: val.value
                },
                success: function(response) {
                    document.getElementById("modelo").innerHTML = response;
                }
            });
        }
    }
</script>

<?php if ($_POST) : ?>
    <script>
        var id = document.getElementById("id").value;
        if (id > 0) {
            var mensaje = alert("Cambios aplicados");
            window.location = "index.php?page=details&id=" + id;
        } else {
            alert("Ha ocurrido un error,intentalo nuevamente");
        }
    </script>;
<?php endif ?>