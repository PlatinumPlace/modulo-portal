<?php
$api = new api();
if (isset($_POST['submit'])) {
    $trato["Contact_Name"] = $_SESSION['usuario']['id'];
    $trato["Lead_Source"] = "Portal GNB";
    $trato["Deal_Name"] = "Cotización";
    $trato["Direcci_n_del_asegurado"] = $_POST['direccion'];
    $trato["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
    $trato["Chasis"] = $_POST['chasis'];
    $trato["Color"] = $_POST['color'];
    $trato["Email_del_asegurado"] = $_POST['email'];
    $marca = $api->getRecord("Marcas", $_POST['marca']);
    $trato["Marca"] = $marca->getFieldValue('Name');
    $modelo = $api->getRecord("Modelos", $_POST['modelo']);
    $trato["Modelo"] = $modelo->getFieldValue('Name');
    $trato["Tipo_de_vehiculo"] = $modelo->getFieldValue('Tipo');
    $trato["Nombre_del_asegurado"] = $_POST['nombre'];
    $trato["Apellido_del_asegurado"] = $_POST['apellido'];
    $trato["Placa"] = $_POST['placa'];
    $trato["Plan"] = $_POST['plan'];
    $trato["Type"] = $_POST['cotizacion'];
    $trato["Uso"] = $_POST['uso'];
    $trato["RNC_Cedula_del_asegurado"] = $_POST['cedula'];
    $trato["Telefono_del_asegurado"] = $_POST['telefono'];
    $trato["Tel_Residencia"] = $_POST['telefono_2'];
    $trato["Tel_Trabajo"] = $_POST['telefono_1'];
    $trato["Tipo_de_poliza"] = $_POST['poliza'];
    $trato["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
    $trato["Stage"] = "Cotizando";
    if (isset($_POST['estado'])) {
        $trato["Es_nuevo"] = true;
    } else {
        $trato["Es_nuevo"] = false;
    }
    $resultado = $api->createRecord("Deals", $trato);
}
?>
<h1 class="mt-4">Crear Cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item active">Crear</li>
</ol>

<form method="POST" action="?page=add" class="row">

    <input value="<?= $resultado['id']  ?>" id="id" hidden>

    <div class="col-10">
        &nbsp;
    </div>
    <div class="col-2">
        <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-search-dollar"></i> Cotizar</button>
    </div>
    <div class="col-12">
        &nbsp;
    </div>

    <div class="col-7">
        <div class="card">
            <div class="card-header">
                <h5>Datos del Cliente</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">RNC/Cédula</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="cedula" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <label class="col-sm-2 col-form-label">Apellido</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="apellido" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="direccion">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Celular</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="telefono">
                    </div>
                    <label class="col-sm-2 col-form-label">Tel. Trabajo</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="telefono_1">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Residencial</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="telefono_2">
                    </div>
                    <label class="col-sm-2 col-form-label">Correo Electrónico</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="email">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-5">
        <div class="card">
            <div class="card-header">
                <h5>Tipo de Cotización</h5>
            </div>
            <div class="card-body">
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
                            <option selected value="Anual Full">Anual Full</option>
                            <option value="Mensual Full">Mensual Full</option>
                            <option value="Ley">Ley</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12">
        &nbsp;
    </div>

    <div class="col-7">
        <div class="card">
            <div class="card-header">
                <h5>Datos de Vehículo</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Marca</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)" required>
                            <option value="" selected disabled>Selecciona una Marca</option>
                            <?php
                            $marcas = $api->getRecords("Marcas");
                            foreach ($marcas as $marca) {
                                echo '<option value="' . $marca->getEntityId() . '">' . $marca->getFieldValue("Name") . '</option>';
                            }
                            ?>
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
            </div>
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
<?php if (isset($_POST['submit'])) : ?>
    <script>
        var id = document.getElementById('id').value;
        alert("Cotización creada");
        window.location = "?page=details&id=" + id;
    </script>
<?php endif ?>