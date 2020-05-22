<h2 class="text-uppercase text-center">
    Crear cotización
</h2>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Opciones</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#" onclick="crear_auto()">
                    <i class="material-icons">directions_car</i> Para vehículo
                </a>
            </li>
        </ul>
    </div>
</nav>

<br>

<div class="card">
    <div class="card-body">

        <div id="auto">
            <form method="POST" action="?url=cotizaciones/crear">

                <h5>Tipo de Cotización</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Póliza</label>
                        <select name="Tipo_de_poliza" class="form-control">
                            <option selected value="Declarativa">Declarativa</option>
                            <option value="Individual">Individual</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Plan</label>
                        <select name="Plan" class="form-control">
                            <option value="Mensual Full" selected>Mensual Full</option>
                            <option value="Anual Full">Anual Full</option>
                            <option value="Ley">Ley</option>
                        </select>
                    </div>
                </div>

                <br>

                <h5>Vehículo</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Marca</label>
                        <select class="form-control" name="Marca" id="marca" onchange="obtener_modelos(this)">
                            <option value="" selected disabled>Selecciona una Marca</option>
                            <?php
                            foreach ($marcas as $marca) {
                                echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Modelo</label>
                        <select class="form-control" name="Modelo" id="modelo">
                            <option value="" selected disabled>Selecciona un Modelo</option>
                            <div id="modelo"></div>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Valor Asegurado</label>
                        <input type="number" class="form-control" name="Valor_Asegurado" id="Valor_Asegurado">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Año de fabricación</label>
                        <input type="number" class="form-control" name="A_o_de_Fabricacion" id="A_o_de_Fabricacion">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Chasis</label>
                        <input type="text" class="form-control" name="Chasis">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Color</label>
                        <input type="text" class="form-control" name="Color">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Uso</label>
                        <select name="Uso" class="form-control">
                            <option selected value="Privado">Privado</option>
                            <option value="Publico">Publico</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Placa</label>
                        <input type="text" class="form-control" name="Placa">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="Es_nuevo">
                            <div class="font-weight-bold">¿Es nuevo?</div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button type="submit" name="crear_auto" class="btn btn-success">Cotizar</button>
                    </div>
                </div>

            </form>
        </div>


    </div>
</div>

<script>
    function crear_auto() {
        var auto = document.getElementById("auto");
        if (auto.style.display === "none") {
            auto.style.display = "block";

            document.getElementById("Valor_Asegurado").required = true;
            document.getElementById("A_o_de_Fabricacion").required = true;
            document.getElementById("marca").required = true;
            document.getElementById("modelo").required = true;
        }
    }


    function obtener_modelos(val) {
        $.ajax({
            url: "libs/obtener_modelos.php",
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