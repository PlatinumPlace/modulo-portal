<form method="POST" action="index.php?controller=HomeController&action=emitir_cotizacion&id=<?=$id?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 py-3 border-left-primary">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label class="form-control-plaintext"><b>Aseguradora seleccionada</b></label>
                        </div>
                        <div class="col">
                            <select class="form-control-plaintext">
                                <?php foreach ($quote as $key => $product) : ?>
                                    <?php $detail = $productAPI->getRecord($product['id_product']) ?>
                                    <option><?= $detail['Vendor_Name'] ?></option>
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
                            <input type="file" class="form-control-plaintext" required name="contratos">
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