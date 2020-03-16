<?php
$api = new api();
$trato = $api->getRecord("Deals", $_GET['id']);
if (isset($_POST['submit'])) {
    $cambios["Chasis"] = $_POST['chasis'];
    $cambios["Color"] = $_POST['color'];
    $cambios["Placa"] = $_POST['placa'];
    $cambios["Uso"] = $_POST['uso'];
    if (isset($_POST['estado'])) {
        $cambios["Es_nuevo"] = true;
    } else {
        $cambios["Es_nuevo"] = false;
    }
    $cambios["Direcci_n"] = $_POST['direccion'];
    $cambios["Email"] = $_POST['email'];
    $cambios["Nombre"] = $_POST['nombre'];
    $cambios["Apellido"] = $_POST['apellido'];
    $cambios["RNC_Cedula"] = $_POST['cedula'];
    $cambios["Telefono"] = $_POST['telefono'];
    $cambios["Tel_Residencia"] = $_POST['telefono_2'];
    $cambios["Tel_Trabajo"] = $_POST['telefono_1'];
    $resultado = $api->updateRecord("Deals", $cambios, $_GET['id']);
}
?>
<h1 class="mt-4">Completar Cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Detalles</li>
    <li class="breadcrumb-item active">Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<form method="POST" class="row" action="?page=complete_auto&id=<?= $trato->getEntityId() ?>">

    <input value="<?= $_GET['id'] ?>" id="id" hidden>

    <div class="col-6">
        &nbsp;
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col">
                <a href="?page=details_auto&id=<?= $trato->getEntityId() ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Detalles</a>
            </div>
            <div class="col">
                <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Completar</button>
            </div>
        </div>
    </div>

    <div class="col-12">
        &nbsp;
    </div>

    <div class="col-12">
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

    <div class="col-12">
        &nbsp;
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Datos de Vehículo</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Chasis</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="chasis" required value="<?= $trato->getFieldValue('Chasis') ?>">
                    </div>
                    <label class="col-sm-2 col-form-label">Color</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="color" value="<?= $trato->getFieldValue('Color') ?>">
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
                        <input type="text" class="form-control" name="placa" value="<?= $trato->getFieldValue('Placa') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">¿Es nuevo?</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="estado" <?php $retVal = ($trato->getFieldValue('Es_nuevo') == true) ? "checked" : ""; ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<?php if (isset($_POST['submit'])) : ?>
    <script>
        var id = document.getElementById('id').value;
        var opcion = confirm("Cotización completa,¿emitir ahora?");
        if (opcion == true) {
            window.location = "?page=emitir_auto&id=" + id;
        } else {
            window.location = "?page=details_auto&id=" + id;
        }
    </script>
<?php endif ?>