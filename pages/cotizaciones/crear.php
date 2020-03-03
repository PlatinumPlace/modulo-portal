<?php
$tratos = new tratos();
if ($_POST) {
    $resultado = $tratos->crear();
}
?>
<div class="section no-pad-bot" id="index-banner">
    <h2 class="header center blue-text">Crear Cotización</h2>
</div>

<div class="row">
    <form class="col s12" method="POST" action="index.php?page=add">

        <input hidden value="<?= $resultado["id"] ?>" id="id">
        
        <div class="row">
            <div class="input-field col s6">
                <input id="nombre" name="nombre" required type="text" class="validate">
                <label for="nombre">Nombre del cliente</label>
            </div>
            <div class="input-field col s6">
                <input id="apellido" name="apellido" required type="text" class="validate">
                <label for="apellido">Apellido del cliente</label>
            </div>
            <div class="input-field col s6">
                <input id="direccion" name="direccion" type="text" class="validate">
                <label for="direccion">Dirección del cliente</label>
            </div>
            <div class="input-field col s6">
                <input id="cedula" name="cedula" required type="text" class="validate">
                <label for="cedula">RNC/Cédula del cliente</label>
            </div>
            <div class="input-field col s6">
                <input id="telefono" name="telefono" type="tel" class="validate">
                <label for="telefono">Teléfono del cliente</label>
            </div>
            <div class="input-field col s6">
                <input id="email" name="email" type="text" class="validate">
                <label for="email">Correo Electrónico del cliente</label>
            </div>
        </div>
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
                <input id="Valor_Asegurado" name="Valor_Asegurado" required type="number" class="validate">
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
            var mensaje = confirm("Cotización creada,¿ver detalles?");
            if (mensaje) {
                window.location = "index.php?page=details&id=" + id;
            }
        }else{
            alert("Ha ocurrido un error,intentalo nuevamente");
        }
    </script>;
<?php endif ?>