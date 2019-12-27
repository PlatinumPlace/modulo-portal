<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nueva cotizacion para vehículo</h1>
    <a href="index.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Regresar al dashboard</a>
</div>

<hr>

<form method="POST" action="index.php?page=cotizacion_crear">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Nombre del cliente</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="Nombre_del_asegurado" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">RNC/Cedula del cliente</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="RNC_Cedula_del_asegurado">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Correo del cliente</label>
        <div class="col-sm-4">
            <input type="email" class="form-control" name="Email_del_asegurado">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Telefono del cliente</label>
        <div class="col-sm-4">
            <input type="phone" class="form-control" name="Telefono_del_asegurado">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Direccion del cliente</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="Direcci_n_del_asegurado">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Plan</label>
        <div class="col-sm-4">
            <select class="form-control" name="Plan">
                <option selected value="Mensual Full">Mensual Full</option>
                <option value="Anual Full">Anual Full</option>
                <option value="Mensual Ley">Mensual Ley</option>
                <option value="Anual Ley">Anual Ley</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tipo</label>
        <div class="col-sm-4">
            <select class="form-control" name="Tipo_de_poliza">
                <option selected value="Declarativa">Declarativa</option>
                <option value="Individual">Individual</option>
            </select>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Marca del vehículo</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="Marca">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Modelo del vehículo</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="Modelo">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Año de Fabricacion del vehículo</label>
        <div class="col-sm-4">
            <input type="number" class="form-control" name="A_o_de_Fabricacion" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tipo</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="Tipo_de_vehiculo" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Chasis</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="Chasis" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Placa</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="Placa">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2">Es nuevo?</div>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck1" name="Es_nuevo" value="0">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Valor Asegurado</label>
        <div class="col-sm-44">
            <input type="number" class="form-control" name="Valor_Asegurado" required>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Enviar</button>
</form>