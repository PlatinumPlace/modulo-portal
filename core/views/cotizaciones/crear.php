<form method="POST" action="index.php?controller=dealController&action=createDeal">
    <div class="cliente">
        <h5>Cliente</h5>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Nombre" name="Nombre_del_asegurado">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="RNC/Cédula" name="RNC_Cedula_del_asegurado">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Correo" name="Email_del_asegurado">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Teléfono" name="Telefono_del_asegurado">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col col-md-6">
                <input type="text" class="form-control" placeholder="Dirección" name="Direcci_n_del_asegurado">
            </div>
        </div>
    </div>
    <hr>
    <div class="poliza">
        <h5>Póliza</h5>
        <div class="row">
            <div class="col col-md-6">
                <select class="custom-select" name="Ramo_de_la_p_liza">
                    <option selected value="Automóvil">Ramo</option>
                    <option value="Automóvil">Automóvil</option>
                </select>
            </div>
            <div class="col">
                <input type="number" class="form-control" placeholder="Valor Asegurado" name="Valor_Asegurado">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <select class="custom-select" name="Plan">
                    <option selected value="Mensual Full">Plan</option>
                    <option value="Mensual Full">Mensual Full</option>
                    <option value="Anual Full">Anual Full</option>
                    <option value="Mensual Ley">Mensual Ley</option>
                    <option value="Anual Ley">Anual Ley</option>
                </select>
            </div>
            <div class="col">
                <select class="custom-select" name="Tipo_de_poliza">
                    <option selected value="Declarativa">Tipo</option>
                    <option value="Declarativa">Declarativa</option>
                    <option value="Ley">Individual</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="vehiculo">
        <h5>Vehiculo</h5>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Marca" name="Marca">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Modelo" name="Modelo">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Año de Fabricacion" name="A_o_de_Fabricacion">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Tipo" name="Tipo_de_vehiculo">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Chasis" name="Chasis">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Placa" name="Placa">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Color" name="Color">
            </div>
        </div>
        <br>
    </div>
    <br>
    <button class="btn btn-primary" type="submit">Enviar</button>
</form>