<?php
$api = new api();
$trato = $api->getRecord("Deals", $_GET['id']);
if (isset($_POST['submit'])) {
    $cambios["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
    $cambios["Chasis"] = $_POST['chasis'];
    $cambios["Color"] = $_POST['color'];
    $marca = $api->getRecord("Marcas", $_POST['marca']);
    $cambios["Marca"] = $marca->getFieldValue('Name');
    $modelo = $api->getRecord("Modelos", $_POST['modelo']);
    $cambios["Modelo"] = $modelo->getFieldValue('Name');
    $cambios["Tipo_de_vehiculo"] = $modelo->getFieldValue('Tipo');
    $cambios["Placa"] = $_POST['placa'];
    $cambios["Plan"] = $_POST['plan'];
    $cambios["Tipo_de_poliza"] = $_POST['poliza'];
    $cambios["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
    $cambios["Type"] = $_POST['cotizacion'];
    $cambios["Per_odo"] = $_POST['periodo'];
    $cambios["Uso"] = $_POST['uso'];
    if (isset($_POST['estado'])) {
        $cambios["Es_nuevo"] = true;
    } else {
        $cambios["Es_nuevo"] = false;
    }
    $resultado = $api->updateRecord("Deals", $cambios, $_GET['id']);
    echo '<script>
            alert("Cambios aplicados")
            window.location = "?page=details&id=" + ' . $_GET['id'] . ';
        </script>;';
}
?>
<h1 class="mt-4">Editar Cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Editar</li>
    <li class="breadcrumb-item active">Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<form method="POST" action="?page=edit&id=<?= $trato->getEntityId() ?>">

    <div class="row">
        <div class="col-6">
            &nbsp;
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col">
                    <a href="?page=search" class="btn btn-secondary"><i class="fas fa-list"></i> Lista</a>
                </div>
                <div class="col">
                    <a href="?page=details&id=<?= $trato->getEntityId() ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Detalles</a>
                </div>
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-search-dollar"></i> Cotizar</button>
                </div>
            </div>
        </div>
    </div>

    <hr>


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
                <option selected value="Full">Full</option>
                <option value="Ley">Ley</option>
                <option value="Simple">Simple</option>
            </select>
        </div>
        <label class="col-sm-2 col-form-label">Período de pago</label>
        <div class="col-sm-4">
            <select name="periodo" class="form-control">
                <option selected value="Mensual">Mensual</option>
                <option value="Anual">Anual</option>
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