<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <h3 class="header center orange-text">Editar Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></h3>
    </div>
</div>

<div class="container">
    <div class="section">

        <div class="row">
            <form class="col s12" method="post" action="?page=edit&id=<?= $trato_id ?>">
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
                        <select name="marca">
                            <option selected>Selecciona un modelo</option>
                        </select>
                        <label>Selecciona una marca</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">directions_car</i>
                        <select name="modelo">
                            <option selected>Selecciona un modelo</option>
                        </select>
                        <label>Selecciona un modelo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">directions_car</i>
                        <input id="Tipo_de_vehiculo" type="text" class="validate" name="Tipo_de_vehiculo" required>
                        <label for="Tipo_de_vehiculo">Tipo_de_vehiculo</label>
                    </div>
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
                    <button data-target="modal1" class="btn modal-trigger waves-effect waves-light red">Eliminar Cotización
                        <i class="material-icons right">restore_from_trash</i>
                    </button>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Guardar Cambios
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
        <a href="?page=details&id=<?= $resultado['id'] ?>" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
</div>
<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4>¿Estas seguro?</h4>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">No</a>
        <a href="?page=delete&id=<?= $trato_id ?>" class="modal-close waves-effect waves-green btn-flat">Si</a>
    </div>
</div>