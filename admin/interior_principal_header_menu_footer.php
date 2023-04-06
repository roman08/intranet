<?php

switch ($opcion){
default:
$row= FetchArray(ProcesaQuery("select * from intranet_header_menu_footer where id='1';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Secciones Principales / Header, menú y footer</h3>
						<!--<p>Registre los datos que a continuación se solicitan</p> -->
					</div>
					<div class="col-xs-12 col-sm-2 col-md-6">
						<button id="btn_RegresarU" class="btn btn-lg btnAzmed bco" onClick="history.go(-1);"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
					</div>
				</div>
			</div>
		</article>
<!-- formulario contacto -->
		<article>
			<div class="container">
				<div class="row">
					<form action="admin_procesa.php" method="post" enctype="multipart/form-data" class="form-horizontal modImg" id="form_preguntas">
						<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-2" >
							<h3>Header</h3>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nombre Empresa</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $row['nombre'];?>" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Logotipo</label>
								<div class="col-sm-5">
									<div class="col-sm-12" style="overflow:hidden; padding:opx;">
									<?php if ($row['imagen']!='' and file_exists('../img/'.$row['imagen'])){
											echo '<img class="imagenNoticiasA" src="../img/'.$row['imagen'].'" /><br/>';
										} else {
											echo 'Sin Imagen<br/>';
										}?>
									</div>
									<input name="archivo" id="archivo" type="file" class="form-control modIn" />
									<!--<small>Tamaño de imagen 420 x 220px</small>-->
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Color del fondo</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color11" id="color11" value="<?php echo $row['color11'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color del texto</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color12" id="color12" value="<?php echo $row['color12'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color over del texto</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color13" id="color13" value="<?php echo $row['color13'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color texto <small>(cerrar sesión)</small></label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color14" id="color14" value="<?php echo $row['color14'];?>" required>
								</div>
							</div>

							<h3>Menú</h3>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color del fondo</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color21" id="color21" value="<?php echo $row['color21'];?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Color del fondo over</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color22" id="color22" value="<?php echo $row['color22'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color del texto</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color23" id="color23" value="<?php echo $row['color23'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color over del texto</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color24" id="color24" value="<?php echo $row['color24'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color de subnivel para dispositivos móviles</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color25" id="color25" value="<?php echo $row['color25'];?>" required>
								</div>
							</div>

              <h3>Footer</h3>

							<div class="form-group">
								<label class="col-sm-3 control-label">Dirección </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $row['direccion'];?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Correo </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="correo" id="correo" value="<?php echo $row['correo'];?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Teléfono </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $row['telefono'];?>" required>
								</div>
							</div>

              <div class="form-group">
								<label class="col-sm-3 control-label">Color del fondo</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color31" id="color31" value="<?php echo $row['color31'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color del texto</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color32" id="color32" value="<?php echo $row['color32'];?>" required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Color over del texto</label>
								<div class="col-sm-5">
									<input class="form-control form-controlA" type="color" name="color33" id="color33" value="<?php echo $row['color33'];?>" required>
								</div>
							</div>

							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="accion" id="accion" type="hidden" value="Modificar" />
					</form>
				</div>
			</div>
		</article>
	</section>
<?php
break;
}?>
