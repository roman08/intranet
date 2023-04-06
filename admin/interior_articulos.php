<?php
if(isset($_GET['id_articulo'])){ $id_articulo=$_GET['id_articulo']; } else { $id_articulo='';}
switch ($opcion){	

case 'Nuevo': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Agregar Artículo</h3>
						<!--<p>Registre los datos que a continuación se solicitan</p> -->
					</div>
					<div class="col-xs-12 col-sm-2 col-md-6">
						<button id="btn_RegresarUD" class="btn btn-lg btnAzmed bco" onClick="history.go(-1);"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
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
								<label class="col-sm-3 control-label">*Título </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="titulo" id="titulo"  required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">*Imagen</label>
								<div class="col-sm-5">
									<input name="archivo" id="archivo" type="file" class="form-control" required/>
									<small>Tamaño de imagen 420 x 220px</small>
								</div>
							</div>
                            
                            
					    <div class="form-group">	
								<label class="col-sm-3 control-label">*Breve Descripción </label>
								<div class="col-sm-5">
									<textarea class="form-control" name="texto1" id="texto1" cols="30" rows="5" required ></textarea>
								</div>
							</div>
                            
                            <div class="form-group">	
								<label class="col-sm-3 control-label">*Descripción </label>
								<div class="col-sm-5">
									<?php
									include_once("fckeditor/fckeditor.php");
									$oFCKeditor = new FCKeditor('texto2');
									$oFCKeditor->BasePath = 'fckeditor/';
									$oFCKeditor->Width	= '400';
									$oFCKeditor->Height	= '350';
									$oFCKeditor->Value = '';
									$oFCKeditor->Create();
									?>
								</div>
							</div>
							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Agregar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>		
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="accion" id="accion" type="hidden" value="Guardar" />
					</form>
				</div>
			</div>
		</article>
	</section>
<?php 
break;
case 'Modificar':
$row= FetchArray(ProcesaQuery("select * from intranet_articulos where id_articulo='$id_articulo';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Modificar Artículo</h3>
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
								<label class="col-sm-3 control-label">*Título </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="titulo" id="titulo" value="<?php echo $row['titulo'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">*Imagen</label>
								<div class="col-sm-5">
									<div class="col-sm-12" style="overflow:hidden; padding:opx;">
                                	<?php if($row['imagen']!='' and file_exists('../articulos/'.$row['imagen'])){ echo '<img class="imagenarticulos" src="../articulos/'.$row['imagen'].'" /><br/>'; } else { echo 'Sin Imagen<br/>';}?>
									</div>
									<input name="archivo" id="archivo" type="file" class="form-control modIn" />
									<small>Tamaño de imagen 420 x 220px</small>
								</div>
							</div>
                            
                            
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Breve Descripción </label>
								<div class="col-sm-5">
									<textarea class="form-control" name="texto1" id="texto1" cols="30" rows="5" ><?php echo $row['texto1'];?></textarea>
								</div>
							</div>
                            
                            <div class="form-group">	
								<label class="col-sm-3 control-label">*Descripción </label>
								<div class="col-sm-5">
									<?php
									include_once("fckeditor/fckeditor.php");
									$oFCKeditor = new FCKeditor('texto2');
									$oFCKeditor->BasePath = 'fckeditor/';
									$oFCKeditor->Width	= '400';
									$oFCKeditor->Height	= '350';
									$oFCKeditor->Value = $row['texto2'];
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
                        <input name="id_articulo" type="hidden" id="id_articulo" value="<?php echo $row['id_articulo'];?>">
                        <input name="accion" id="accion" type="hidden" value="Modificar" />
					</form>
				</div>
			</div>
		</article>
	</section>
<?php 
break;
default: ?>	
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8">
						<h3 class="azulMedio">Artículos</h3>
<!-- 						<p>En la siguiente lista usted podrá visualizar las facturas que ha registrado en el sistema y el estatus de las mismas.      </p>
 -->					</div>
					<div class="col-xs-12 col-sm-4">
						<button id="preguntaR" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>'"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
						<button id="pregunta" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>&opcion=Nuevo'"><img class="iconUser" src="img/ipreguntas.png" alt="preguntas frecuentes">Agregar Artículo</button>
					</div>
				</div>
				
				<div id="" class="row">
					<table id="tablePreguntas" class="table table-striped table-responsive tableGeneral">
						<thead>
							<tr class="back_azulMedio bco">
							  <th>Registro</th>
							  <th>Imagen</th>
								<th>Artículo</th>
								<th class="thAcciones">Acciones</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$rxp=15;
						if(($pagina!='') and ($pagina>'0')){ $inicio=($pagina*$rxp)-$rxp;}
						
						
						if ($inicio!='')
							{
							$siguiente=$inicio+$rxp;
							$anterior=$inicio-$rxp;
							} else {
							$inicio=0;
							$anterior=-$rxp;
							$siguiente=$rxp;
							}	
					
						  $consulta=ProcesaQuery("select * from intranet_articulos order by registro desc limit $inicio, $rxp;");
						  $total= NumRows(ProcesaQuery("select * from intranet_articulos;"));
					if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							$contador=0;  
						  while ($row= FetchArray($consulta)) {
							  $contador++;
						  ?>
							<tr>
							  <td class="centrarCelda"><?php echo fecha_ddmmaaaahhmmss($row['registro']);?></td>
							  <td class="centrarCelda"><?php if($row['imagen']!='' and file_exists('../articulos/'.$row['imagen'])){ echo '<img class="imagenarticulos" src="../articulos/'.$row['imagen'].'" width="95" />'; } else { echo 'Sin Imagen';}?></td>
								<td class="centrarCelda"><?php echo $row['titulo'];?></td>
								<td>
                                <a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Modificar&id_articulo=<?php echo $row['id_articulo'];?>" title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
                                <a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Eliminar&id_articulo=<?php echo $row['id_articulo'];?>&inicio=<?php echo $inicio;?>" title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a></td>
							</tr>
                            <?php } } else {?>
							<tr>
							  <td height="150" colspan="4" class="txtPregunta">No se encontraron  Registros</td>
						  </tr>
                          <?php }?>
						</tbody>
					</table>
</div>

				<div class="row">
					
                    
                      <div class="paginas bottomp">
      <div class="paginas-number">
          <span class="conteo_paginas">Pag <?php echo $pagina_actual;?> de <?php echo $cantidad_paginas;?></span>
      <?php if ($anterior >= 0){?>
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Listar&inicio=<?php echo $anterior;?>" class="borrar"><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>							
	  <?php }?>
      
      <input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual;?>" onchange="location.href='admin.php?ver=<?php echo $ver?>&opcion=Listar&pagina='+this.value"> 
          
      <?php if ($siguiente < $total) {?>
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Listar&inicio=<?php echo $siguiente;?>" class="borrar"><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
	  <?php }?>
      </div>
  </div>
        
        			<div id="output"></div>
				</div>
			</div>
		</article>
	</section>
<?php 
break;

}?>    