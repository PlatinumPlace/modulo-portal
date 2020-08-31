<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-5">

			<?php if (isset($alerta)) : ?>
				<br>
				<div class="alert alert-primary" role="alert">
					<?= $alerta ?>
				</div>
			<?php endif ?>

			<div class="card shadow-lg border-0 rounded-lg mt-5">

				<div class="card-header">
					<div class="text-center">
						<img src="<?= constant("url") ?>public/icons/logo.png" height="150" width="150">
					</div>
				</div>

				<div class="card-body">
					<form method="POST" action="<?= constant("url") ?>">

						<div class="form-group">
							<label class="small mb-1">Usuario</label> <input class="form-control py-4" type="email" name="email" required />
						</div>

						<div class="form-group">
							<label class="small mb-1">Contraseña</label> <input class="form-control py-4" type="password" name="pass" required />
						</div>

						<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
							<button class="btn btn-primary" type="submit">Ingresar</button>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>
</div>

<br>
<br>
<footer class="py-4 bg-light mt-auto fixed-bottom">
	<div class="container-fluid">
		<div class="d-flex align-items-center justify-content-between small">
			<div class="text-muted">Copyright &copy; GrupoNobe <?= date("Y") ?></div>
		</div>
	</div>
</footer>