<?php
require_once('helpers/verificar_usuario.php');
if ($_POST) {
    $resultado = validar();
    echo "<script>M.toast({html: '" . $resultado . "'})</script>";
}
?>
<br><br>
<div class="col s12">
    <?php if ($_POST) : ?>
        <div class="row">
            <div class="col s6 m4 right">
                <div class="card-panel red">
                    <span class="white-text">
                        <?= $resultado ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="card horizontal">
        <div class="card-image">
            <img src="img/portal/usuario.png" width="200" height="300">
        </div>
        <div class="card-stacked">
            <form method="POST" action="index.php">
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="usuario" type="text" class="validate" name="usuario" required>
                            <label for="usuario">Usuario</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">vpn_key</i>
                            <input id="clave" type="password" class="validate" name="clave" required>
                            <label for="clave">Contraseña</label>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Verificar
                        <i class="material-icons right">verified_user</i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>