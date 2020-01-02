<div class="row">
    <form class="col s12" method="POST" action="index.php?page=create">
        <div class="row">
            <div class="input-field col s6">
                <input id="Nombre_del_asegurado" type="text" class="validate" name="Nombre_del_asegurado" required>
                <label for="Nombre_del_asegurado">Nombre del asegurado</label>
            </div>
            <div class="input-field col s6">
                <input id="RNC_Cedula_del_asegurado" type="text" class="validate" name="RNC_Cedula_del_asegurado" required>
                <label for="RNC_Cedula_del_asegurado">RNC Cedula del asegurado</label>
            </div>
            <div class="input-field col s6">
                <input id="Email_del_asegurado" type="email" class="validate" name="Email_del_asegurado">
                <label for="Email_del_asegurado">Correo del cliente</label>
            </div>
            <div class="input-field col s6">
                <input id="Telefono_del_asegurado" type="text" class="validate" name="Telefono_del_asegurado">
                <label for="Telefono_del_asegurado">Telefono del cliente</label>
            </div>
            <div class="input-field col s8">
                <input id="Direcci_n_del_asegurado" type="text" class="validate" name="Direcci_n_del_asegurado">
                <label for="Direcci_n_del_asegurado">Direccion del cliente</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select>
                    <option value="Mensual Full">Mensual Full</option>
                    <option value="Anual Full">Anual Full</option>
                    <option value="Mensual Ley">Mensual Ley</option>
                    <option value="Anual Ley">Anual Ley</option>
                </select>
                <label>Tipo de plan</label>
            </div>
            <div class="input-field col s6">
                <select>
                    <option selected value="Declarativa">Declarativa</option>
                    <option value="Individual">Individual</option>
                </select>
                <label>Tipo de póliza</label>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="input-field col s6">
                <input id="Marca" type="text" class="validate" name="Marca" required>
                <label for="Marca">Marca del vehículo</label>
            </div>
            <div class="input-field col s6">
                <input id="Modelo" type="text" class="validate" name="Modelo" required>
                <label for="Modelo">Modelo del vehículo</label>
            </div>
            <div class="input-field col s6">
                <input id="A_o_de_Fabricacion" type="number" class="validate" name="A_o_de_Fabricacion">
                <label for="A_o_de_Fabricacion">Año de Fabricacion del vehículo</label>
            </div>
            <div class="input-field col s6">
                <input id="Tipo_de_vehiculo" type="text" class="validate" name="Tipo_de_vehiculo" required>
                <label for="Tipo_de_vehiculo">Tipo de vehículo</label>
            </div>
            <div class="input-field col s6">
                <input id="Chasis" type="text" class="validate" name="Chasis" required>
                <label for="Chasis">Chasis</label>
            </div>
            <div class="input-field col s6">
                <input id="Placa" type="text" class="validate" name="Placa">
                <label for="Placa">Placa</label>
            </div>
            <div class="input-field col s6">
                <label>
                    <input type="checkbox" class="filled-in" checked="checked" name="Es_nuevo" value="0" />
                    <span>Es nuevo?</span>
                </label>
            </div>
            <div class="input-field col s6">
                <input id="Valor_Asegurado" type="number" class="validate" name="Valor_Asegurado" required>
                <label for="Valor_Asegurado">Valor Asegurado</label>
            </div>
        </div>

        <button class="btn waves-effect waves-light" type="submit" name="action">Cotizar
            <i class="material-icons right">send</i>
        </button>
    </form>
</div>