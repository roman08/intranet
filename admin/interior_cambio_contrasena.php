	<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Cambiar Contraseña</h3>
					</div>
				</div>
			</div>
		</article>
<!-- formulario contacto -->
		<article>
			<div id="misDatos" class="container">
				<div class="row">
					<form action="admin_procesa.php" method="post" enctype="multipart/form-data" class="form-horizontal modImg" id="form_cambio_password">
						<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-2">
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Contraseña Actual</label>
								<div class="col-sm-5">
									<input class="form-control"type="password" name="contrasena1" id="contrasena1" required >
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Contraseña Nueva</label>
								<div class="col-sm-5">
									<input class="form-control"type="password" name="contrasena2" id="contrasena2" required >
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Confirmar Nueva Contraseña</label>
								<div class="col-sm-5">
									<input class="form-control"type="password" name="contrasena3" id="contrasena3">
								</div>
							</div>
							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Cambiar Contraseña</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
                                <input name="ver" id="ver" type="hidden" value="usuarios" />
                                <input name="accion" id="accion" type="hidden" value="Cambiar_Password" />
							</div>				
						</div>
					</form>
				</div>
			</div>
		</article>
	</section>
