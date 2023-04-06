<?php
if(isset($_GET['id_categoria'])){ $id_categoria=$_GET['id_categoria']; } else { $id_categoria='';}
if(isset($_GET['id_noticia'])){ $id_noticia=$_GET['id_noticia']; } else { $id_noticia='';}
switch ($opcion){	


default:
$row= FetchArray(ProcesaQuery("select * from intranet_redes_sociales where id='1';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Secciones Principales / Redes Sociales</h3>
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
								<label class="col-sm-3 control-label">* Facebook</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="facebook" id="facebook" value="<?php echo $row['facebook'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Twitter</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="twitter" id="twitter" value="<?php echo $row['twitter'];?>" required>
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