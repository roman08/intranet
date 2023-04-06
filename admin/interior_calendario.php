<?php
if(isset($_GET['id_calendario'])){ $id_calendario=$_GET['id_calendario']; } else { $id_calendario='';}
if(isset($_GET['final'])){ $final=$_GET['final']; } else { $final='';}
if(isset($_GET['inicial'])){ $inicial=$_GET['inicial']; } else { $inicial='';}
switch ($opcion){	

case 'Nuevo': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Agregar Fecha</h3>
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
								<label class="col-sm-3 control-label">* Fecha</label>
								<div class="col-sm-5">
									<input class="form-control calendario" readonly="readonly" type="text" name="fecha" id="fecha"  placeholder="dd/mm/aaaa" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Horario </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="horario" id="horario"  required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Actividad </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="actividad" id="actividad"  required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Sede o ubicación </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="ubicacion" id="ubicacion"  required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Descripción </label>
								<div class="col-sm-5">
									<textarea class="form-control" name="descripcion" id="descripcion" cols="" rows="" required></textarea>
								</div>
							</div>
                            
                            <div class="form-group">	
								<label class="col-sm-3 control-label">*Activo </label>
								<div class="col-sm-5">
									<select name="activo" id="activo" class="form-control">
                                    	<option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
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
$row=FetchArray(ProcesaQuery("select * from intranet_calendario where id_calendario='$id_calendario';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Modificar Fecha</h3>
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
								<label class="col-sm-3 control-label">* Fecha</label>
								<div class="col-sm-5">
									<input class="form-control calendario" readonly="readonly" type="text" name="fecha" id="fecha" value="<?php echo fecha_ddmmaaaa($row['fecha']);?>"  placeholder="dd/mm/aaaa" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Horario </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="horario" id="horario" value="<?php echo $row['horario'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Actividad </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="actividad" id="actividad" value="<?php echo $row['actividad'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Sede o ubicación </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="ubicacion" id="ubicacion" value="<?php echo $row['ubicacion'];?>" required>
								</div>
							</div>
                            <div class="form-group">	
								<label class="col-sm-3 control-label">* Descripción </label>
								<div class="col-sm-5">
									<textarea class="form-control" name="descripcion" id="descripcion" cols="" rows="" required><?php echo $row['descripcion'];?></textarea>
								</div>
							</div>
                            
                            <div class="form-group">	
								<label class="col-sm-3 control-label">*Activo </label>
								<div class="col-sm-5">
									<select name="activo" id="activo" class="form-control">
                                    	<option value="1" <?php if($row['activo']=='1'){ echo 'selected="selected"';}?>>SI</option>
                                        <option value="0" <?php if($row['activo']=='0'){ echo 'selected="selected"';}?>>NO</option>
                                    </select>
								</div>
							</div>
                            
							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>		
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="id_calendario" type="hidden" id="id_calendario" value="<?php echo $row['id_calendario'];?>">
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
						<h3 class="azulMedio">Calendario</h3>
<!-- 						<p>En la siguiente lista usted podrá visualizar las facturas que ha registrado en el sistema y el estatus de las mismas.      </p>
 -->					</div>
 
 
 
				  <div class="col-xs-12 col-sm-4">
				  	<button id="preguntaR" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>'"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
					<button id="pregunta" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>&opcion=Nuevo'"><img class="iconUser" src="img/ipreguntas.png" alt="preguntas frecuentes">Agregar Fecha</button>  
				  </div>
				</div>
                
				<div class="row">
					<div id="formCalendario">
	                    <form action="admin.php" method="get" enctype="multipart/form-data" id="form_contacto">
	                    	<div class="form-group">
		                        <ul class="listFormA">
		                            <li><button class="btn btnConsultar btnAzmed bco" type="submit"><img class="iconUser" src="img/iconsultar.png" alt="consultar">Consultar</button></li>                
		                            <li class="liFecha">
		                                <label>Fecha Final</label>
										<input class="form-control calendario" readonly="readonly" type="text" name="final" id="final"  placeholder="dd/mm/aaaa" value="<?php echo $final;?>">
									</li>
									<li class="liFecha">
		                                <label>Fecha Inicial</label>
										<input class="form-control calendario" readonly="readonly" type="text" name="inicial" id="inicial" placeholder="dd/mm/aaaa" value="<?php echo $inicial;?>">
									</li>
		                        </ul>
		                    </div>   
                            <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
	                    </form>
                	</div>
				</div>
                
				<div id="" class="row">
					<table id="tablePreguntas" class="table table-striped table-responsive tableGeneral">
						<thead>
							<tr class="back_azulMedio bco">
							  <th>Fecha</th>
							  <th>Hora</th>
							  <th>Actividad</th>
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
							
						  $bus='';
						  if(($inicial!='') and ($final!='')){	$bus="where fecha>='".fecha_aaaammdd($inicial)."' and fecha<='".fecha_aaaammdd($final)."'";}
						  $consulta=ProcesaQuery("select * from intranet_calendario $bus order by fecha desc limit $inicio, $rxp;");
						  $total= NumRows(ProcesaQuery("select * from intranet_calendario $bus;"));
					if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							$contador=0;  
						  while ($row=FetchArray($consulta)) {
							  $contador++;
						  ?>
							<tr>
							  <td class="centrarCelda"><?php echo fecha_ddmmaaaa($row['fecha']);?></td>
							  <td class="centrarCelda"><?php echo $row['horario'];?></td>
							  <td class="centrarCelda"><?php echo $row['actividad'];?></td>
							  <td>
                                <a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Modificar&id_calendario=<?php echo $row['id_calendario'];?>" title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
                                <a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Eliminar&id_calendario=<?php echo $row['id_calendario'];?>&inicio=<?php echo $inicio;?>" title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a></td>
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
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Listar&inicio=<?php echo $anterior;?>&inicial=<?php echo $inicial;?>&final=<?php echo $final;?>" class="borrar"><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>							
	  <?php }?>
      
      <input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual;?>" onchange="location.href='admin.php?ver=<?php echo $ver?>&opcion=Listar&inicial=<?php echo $inicial;?>&final=<?php echo $final;?>&pagina='+this.value"> 
          
      <?php if ($siguiente < $total) {?>
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Listar&inicio=<?php echo $siguiente;?>&inicial=<?php echo $inicial;?>&final=<?php echo $final;?>" class="borrar"><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
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