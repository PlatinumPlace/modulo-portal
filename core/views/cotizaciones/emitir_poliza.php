<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Emision de póliza provisional
    </h1>
    <a href="index.php?controller=cotizaciones&action=detalles&id=<?= $id ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
</div>

<hr>
<form method="POST" action="index.php?controller=cotizaciones&action=emitir_poliza&id=<?=$id?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 py-3 border-left-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label class="form-control-plaintext"><b>Aseguradora seleccionada</b></label>
                        </div>
                        <div class="col">
                            <select class="form-control-plaintext" name="aseguradora">
                                <?php foreach ($cotiazcion as $key => $producto) : ?>
                                    <?php $detalles = $productos->getRecord($producto['id_product']) ?>
                                    <option value="<?= $detalles['Vendor_Name_id'] ?>"><?= $detalles['Vendor_Name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4 py-3 border-left-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <input type="file" class="form-control-plaintext" name="firmas">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card mb-4 py-3 border-left-primary">
                <div class="card-body">
                <button type="submit" class="btn btn-success mb-2">Comfirmar</button>
                </div>
            </div>
        </div>
    </div>
</form>