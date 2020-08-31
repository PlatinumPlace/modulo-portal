<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2 text-uppercase">reporte de cotizaciones</h1>
</div>

<?php if (!empty($alerta)) : ?>
	<div class="alert alert-info" role="alert">
		<?= $alerta ?>
	</div>
<?php endif ?>

<form method="POST" action="<?= constant("url") ?>?page=reportes">

	<div class="form-row">

		<div class="form-group col-md-6">
			<label><b>Tipo</b></label>
			<select name="tipo_cotizacion" class="form-control">
				<option value="auto" selected>Auto</option>
			</select>
		</div>

		<div class="form-group col-md-6">
			<label><b>Estado</b></label>
			<select name="estado_cotizacion" class="form-control">
				<option value="pendientes" selected>Pendientes</option>
				<option value="emitidas">Emitidos</option>
			</select>
		</div>

	</div>

	<div class="form-row">

		<div class="form-group col-md-6">
			<label><b>Desde</b></label>
			<input type="date" class="form-control" name="desde" required>
		</div>

		<div class="form-group col-md-6">
			<label><b>Hasta</b></label>
			<input type="date" class="form-control" name="hasta" required>
		</div>

	</div>

	<div class="form-row">

		<div class="form-group col-md-6">
			<label><b>Aseguradora</b></label>
			<select name="contrato_id" class="form-control">
				<option value="" selected>Todas</option>
				<?php
				$aseguradoras = array_unique($aseguradoras);
				foreach ($aseguradoras as $id => $nombre) {
					echo '<option value="' . $id . '">' . $nombre . '</option>';
				}
				?>
			</select>
		</div>

	</div>

	<br>
	<button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
</form>