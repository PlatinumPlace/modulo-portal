<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4><?= $mensaje ?></h4>
    </div>
    <div class="modal-footer">
        <a href="?pagina=crear_cotizacion" class="modal-close waves-effect waves-green btn-flat">Hacer otra cotización</a>
        <a href="index.php" class="modal-close waves-effect waves-green btn-flat">Ir al dashboard</a>
    </div>
</div>
<div class="row">
    <form class="col s12" method="post" action="?pagina=eliminar_cotizacion&id=<?= $oferta_id ?>">
        <div class="col s12 center">
            <h2>¿Estas seguro de continuar?</h2>
        </div>
        <div class="row">
            <div class="col s6 center">
                <a class="btn waves-effect waves-light blue" href="?pagina=ver_cotizacion&id=<?= $oferta_id ?>">
                    <i class="material-icons left">arrow_back</i>
                    Cancelar
                </a>
            </div>
            <div class="col s6 center">
                <button class="btn waves-effect waves-light red" type="submit" name="submit">
                    <i class="material-icons left">send</i>
                    Aceptar
                </button>
            </div>
        </div>
    </form>
</div>