<?php
$tratos = new tratos();
$trato = $tratos->detalles($_GET['id']);
if ($_POST) {
    $resultado = $tratos->editar($_GET['id']);
}
?>
<div class="section no-pad-bot" id="index-banner">
    <h2 class="header center blue-text">Editar Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></h2>
</div>

<div class="row">
    <form class="col s12" method="POST" action="index.php?page=edit&id=<?= $trato->getEntityId() ?>">

    <input hidden value="<?= $resultado["id"] ?>" id="id">

        <div class="row">
            <div class="input-field col s6">
                <select name="poliza">
                    <option selected value="Declarativa">Declarativa</option>
                    <option value="Individual">Individual</option>
                </select>
                </select>
                <label>Tipo de Póliza</label>
            </div>
            <div class="input-field col s6">
                <select name="plan">
                    <option selected value="Mensual Full">Mensual Full</option>
                    <option value="Anual Full">Anual Full</option>
                    <option value="Mensual Ley">Mensual Ley</option>
                    <option value="Anual Ley">Anual Ley</option>
                </select>
                </select>
                <label>Tipo de Plan</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <select>
                    <option value="" selected>Vehículo</option>
                </select>
                <label>Tipo de Cotización</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select class="browser-default" name="marca" id="marca" onchange="obtener_modelos(this)" required>
                    <option value="" selected disabled>Selecciona una Marca</option>
                    <?php require("helpers/obtener_marcas.php") ?>
                </select>
                </select>
            </div>
            <div class="input-field col s6">
                <select class="browser-default" name="modelo" id="modelo" required>
                    <option value="" selected disabled>Selecciona un Modelo</option>
                    <div id="modelo"></div>
                </select>
            </div>
            <div class="input-field col s6">
                <input id="Valor_Asegurado" name="Valor_Asegurado" required type="number" class="validate" value="<?= $trato->getFieldValue('Valor_Asegurado') ?>">
                <label for="Valor_Asegurado">Valor Asegurado</label>
            </div>
            <div class="input-field col s6">
                <input id="A_o_de_Fabricacion" name="A_o_de_Fabricacion" required type="number" class="validate">
                <label for="A_o_de_Fabricacion">Año de fabricación</label>
            </div>
            <div class="input-field col s6">
                <input id="chasis" name="chasis" required type="text" class="validate">
                <label for="chasis">Chasis</label>
            </div>
            <div class="input-field col s6">
                <input id="color" name="color" type="text" class="validate">
                <label for="color">Color</label>
            </div>
            <div class="input-field col s6">
                <input id="placa" name="placa" type="text" class="validate">
                <label for="placa">Placa</label>
            </div>
            <div class="input-field col s6">
                <p>
                    <label>
                        <input name="estado" type="checkbox" />
                        <span>¿Es nuevo?</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <a href="?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="green waves-effect waves-light btn"><i class="material-icons left">arrow_back</i>Cancelar</a>
                <button class="btn waves-effect waves-light" type="submit" name="action">Cotizar
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>
</div>

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
        }else{
            alert("Ha ocurrido un error,intentalo nuevamente");
        }
    </script>;
<?php endif ?>