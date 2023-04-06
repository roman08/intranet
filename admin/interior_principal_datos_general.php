<?php

switch ($opcion){	


default:
$row= FetchArray(ProcesaQuery("select * from intranet_datos_generales where id='1';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Secciones Principales / Datos generales / Datos de la empresa</h3>
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
							<div class="form-group">	
								<label class="col-sm-3 control-label">* Nombre</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $row['nombre'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Domicilio Completo</label>
								<div class="col-sm-5">
									<textarea class="form-control" name="domicilio" id="domicilio" cols="30" rows="5" ><?php echo $row['domicilio'];?></textarea>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Correo Electrónico</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="correo" id="correo" value="<?php echo $row['correo'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Número Telefónico</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $row['telefono'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Lotipo</label>
								<div class="col-sm-5">
									<div class="col-sm-12" style="overflow:hidden; padding:opx;">
                                	<?php if($row['imagen']!='' and file_exists('../img/'.$row['imagen'])){ echo '<img class="imagenNoticias" src="../img/'.$row['imagen'].'" /><br/>'; } else { echo 'Sin Imagen<br/>';}?>
									</div>
									<input name="archivo" id="archivo" type="file" class="form-control modIn" />
									<small>Tamaño de imagen 82 x 180px</small>
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