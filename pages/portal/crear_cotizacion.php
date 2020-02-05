<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <h3 class="header center orange-text">Crear nueva Cotización</h3>
    </div>
</div>

<div class="container">
    <div class="section">

        <div class="row">
            <form class="col s12" method="POST" action="?pagina=crear">
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="nombre" type="text" class="validate" name="nombre" required>
                        <label for="nombre">Nombre del Cliente</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="apellido" type="text" class="validate" name="apellido" required>
                        <label for="apellido">Apellido del Cliente</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">edit_location</i>
                        <input id="direccion" type="text" class="validate" name="direccion">
                        <label for="direccion">Dirección del Cliente</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">assignment_ind</i>
                        <input id="cedula" type="text" class="validate" name="cedula" required>
                        <label for="cedula">RNC/Cédula del Cliente</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">contact_phone</i>
                        <input id="telefono" type="text" class="validate" name="telefono">
                        <label for="telefono">Telefono del Cliente</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">email</i>
                        <input id="email" type="email" class="validate" name="email">
                        <label for="email">Correo Electronico</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">post_add</i>
                        <select name="plan">
                            <option selected value="Mensual Full">Mensual Full</option>
                            <option value="Anual Full">Anual Full</option>
                            <option value="Mensual Ley">Mensual Ley</option>
                            <option value="Anual Ley">Anual Ley</option>
                        </select>
                        <label>Tipo de plan</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">post_add</i>
                        <select name="poliza">
                            <option selected value="Declarativa">Declarativa</option>
                            <option value="Individual">Individual</option>
                        </select>
                        <label>Tipo de póliza</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">directions_car</i>
                        <select name="marca" id="marca" onchange="obtener_modelos(this)">
                            <option selected disabled>Selecciona una marca</option>
                            <?php $marcas = $this->cotizaciones->marcas() ?>
                            <?php foreach ($marcas as $marca) : ?>
                                <option value="<?= $marca->getEntityId() ?>"><?= $marca->getFieldValue('Name') ?></option>
                            <?php endforeach ?>
                        </select>
                        <label>Selecciona una marca</label>
                    </div>
                    <div class="input-field col s6">
                        <select name="modelo" id="modelo" class="browser-default">
                            <div id="modelo"></div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">attach_money</i>
                        <input id="Valor_Asegurado" type="number" class="validate" name="Valor_Asegurado" required>
                        <label for="Valor_Asegurado">Valor Asegurado</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">directions_car</i>
                        <input id="chasis" type="text" class="validate" name="chasis">
                        <label for="chasis">Chasis</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">directions_car</i>
                        <input id="color" type="text" class="validate" name="color">
                        <label for="color">Color</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">directions_car</i>
                        <input id="placa" type="text" class="validate" name="placa">
                        <label for="placa">Placa</label>
                    </div>
                    <div class="input-field col s6">
                        <p>
                            <label>
                                <input type="checkbox" name="estado" value="0" />
                                <span>¿Es nuevo?</span>
                            </label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">directions_car</i>
                        <input id="A_o_de_Fabricacion" type="number" class="validate" name="A_o_de_Fabricacion" required>
                        <label for="A_o_de_Fabricacion">Año de fabricación</label>
                    </div>
                </div>
                <div class="col s12 center">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Cotizar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Modal Structure -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h4><?= $mensaje ?></h4>
    </div>
    <div class="modal-footer">
        <a href="?pagina=detalles&id=<?= $resultado['id'] ?>" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
</div>