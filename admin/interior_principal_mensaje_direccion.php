<?php
switch ($opcion){	
default:
$row= FetchArray(ProcesaQuery("select * from intranet_mensaje_direccion where id='1';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Secciones Principales / Mensaje de la Dirección</h3>
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
								<label class="col-sm-3 control-label">* Imagen</label>
								<div class="col-sm-5">
									<div class="col-sm-12" style="overflow:hidden; padding:opx;">
                                	<?php if($row['imagen']!='' and file_exists('../img/'.$row['imagen'])){ echo '<img class="imagenNoticiasB" src="../img/'.$row['imagen'].'" /><br/>'; } else { echo 'Sin Imagen<br/>';}?>
									</div>
									<input name="archivo" id="archivo" type="file" class="form-control modIn" />
									<small>Tamaño de imagen 420 x 225px</small>
								</div>
							</div>
                            
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Texto</label>
								<div class="col-sm-5">
									<textarea name="texto" id="texto" class="form-control modIn"><?php echo $row['texto'];?></textarea>
								</div>
							</div>
							
							<div class="form-group">	
								<label class="col-sm-3 control-label">* Mensaje</label>
								<div class="col-sm-5">
									<?php
									include_once("fckeditor/fckeditor.php");
									$oFCKeditor = new FCKeditor('mensaje');
									$oFCKeditor->BasePath = 'fckeditor/';
									$oFCKeditor->Width	= '400';
									$oFCKeditor->Height	= '350';
									$oFCKeditor->Value = $row['mensaje'];
									$oFCKeditor->Create();
									?>
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