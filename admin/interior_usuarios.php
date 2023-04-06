<?php
if(isset($_GET['pagina'])){ $pagina=$_GET['pagina']; }else{ $pagina='';}
switch ($opcion){
case 'Nuevo': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Nuevo Usuario</h3>
						<!--<p>Registre los datos que a continuación se solicitan</p> -->
					</div>
					<div class="col-xs-12 col-sm-2 col-md-6">
						<button id="btn_RegresarU" class="btn btn-lg btnAzmed bco" onclick="history.go(-1);"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
					</div>
				</div>
			</div>
		</article>
<!-- formulario contacto -->
		<article>
			<div class="container">
				<div class="row">
					<form action="admin_procesa.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="form_usuario">
						<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-2" >
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Nombre</label>
								<div class="col-sm-5">
									<input name="nombre" type="text" class="form-control" id="nombre" maxlength="150" required>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Usuario (email)</label>
								<div class="col-sm-5">
									<input class="form-control"type="email" name="usuario_" required id="usuario_">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Contraseña</label>
								<div class="col-sm-5">
									<input class="form-control" type="password" name="password_" id="password_" required>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label labelAccesos">*Seccion de Accesos</label>
								<div class="col-sm-5 inputAccesos">
								<?php 
								 $s=0;			 
								 $c=ProcesaQuery("select * from intranet_secciones;");
								 while ($r= FetchArray($c)){
									echo '<div>
									<input class="form-control" name="s'.$r['id_seccion'].'" type="checkbox" id="s'.$r['id_seccion'].'" value="1" ><span class="form-controlTxt">'.utf8_encode($r['nombre']).'</span>
								</div>';
								 }?> 
								 </div>	
							</div>
							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Registrar</button>
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
$row=mysqli_num_rows(ProcesaQuery("select * from intranet_usuarios where id_usuario='$id_usuario' and nivel='1';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Nuevo Usuario</h3>
						<!--<p>Registre los datos que a continuación se solicitan</p> -->
					</div>
					<div class="col-xs-12 col-sm-2 col-md-6">
						<button id="btn_RegresarU" class="btn btn-lg btnAzmed bco" onclick="history.go(-1);"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
					</div>
				</div>
			</div>
		</article>
<!-- formulario contacto -->
		<article>
			<div class="container">
				<div class="row">
					<form action="admin_procesa.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="form_usuario">
						<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-2" >
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Nombre</label>
								<div class="col-sm-5">
									<input name="nombre" type="text" class="form-control" id="nombre" maxlength="150" value="<?php echo $row['nombre'];?>" required>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Usuario (email)</label>
								<div class="col-sm-5">
									<input class="form-control"type="email" name="usuario_" id="usuario_" value="<?php echo $row['usuario'];?>" required>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">*Contraseña</label>
								<div class="col-sm-5">
									<input class="form-control" type="password" name="password_" id="password_" value="<?php echo $row['password'];?>" required>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label labelAccesos">*Seccion de Accesos</label>
								<?php 		 
								 $c=ProcesaQuery("select a.*, b.id_usuario from intranet_secciones a LEFT JOIN intranet_usuarios_seccion b ON a.id_seccion=b.id_seccion and id_usuario='$id_usuario';");
								 while ($r=mysqli_num_rows($c)){
									echo '<div class="col-sm-5">
									<input class="form-control" name="s'.$r['id_seccion'].'" type="checkbox" id="s'.$r['id_seccion'].'" value="1" ';
										if ($r['id_usuario']==$row['id_usuario'])
										echo'checked="checked"';
										echo '><span class="form-controlTxt">'.utf8_encode($r['nombre']).'</span>
								</div>';
								 }?> 	
							</div>
							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>		
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $row['id_usuario'];?>">
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
						<h3 class="azulClaro">Usuarios</h3>
<!-- 						<p>En la siguiente lista usted podrá visualizar las facturas que ha registrado en el sistema y el estatus de las mismas.      </p>
 -->					</div>
					<div class="col-xs-12 col-sm-4">
						<button id="registro" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=usuarios&opcion=Nuevo'"><img class="iconUser" src="img/agregar_usuarios.png" alt="agregar_usuario">Nuevo Usuario</button>
					</div>
				</div>
				
				<div id="" class="row">
					<table id="tableUsuarios" class="table table-striped table-responsive tableGeneral">
						<thead>
							<tr class="back_azulMedio bco">
								<th class="thNombre">Nombre</th>
								<th class="thEmail">Usuario (email)</th>
								<th>Fecha de Último Acceso</th>
								<th class="thAcciones">Acciones</th>
							</tr>
						</thead>
						<tbody>
                         <?php 
						 $rxp=10;
						 if(($pagina!='') and ($pagina>'0')){ $inicio=($pagina*$rxp)-$rxp;}
						
						 
						 if ($inicio!=''){
							$siguiente=$inicio+$rxp;
							$anterior=$inicio-$rxp;
							} else {
							$inicio=0;
							$anterior=-$rxp;
							$siguiente=$rxp;
							}
							$consulta=ProcesaQuery("select * from intranet_usuarios  where nivel='1' and id_usuario>'1' order by nombre desc limit $inicio, $rxp;");
						  $total= mysqli_num_rows(ProcesaQuery("select * from intranet_usuarios  where nivel='1' and id_usuario>'1';"));
					if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							
						  while ($row= FetchArray($consulta)) {
						  ?>
							<tr>
								<td class="centrarCelda"><?php echo $row['nombre'];?></td>
								<td class="centrarCelda"><?php echo $row['usuario'];?></td>
								<td class="centrarCelda"><?php echo fecha_ddmmaaaahhmmss($row['ultimo']);?></td>
								<td><a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Modificar&id_usuario=<?php echo $row['id_usuario'];?>"  title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
								<a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Eliminar&id_usuario=<?php echo $row['id_usuario'];?>&inicio=<?php echo $inicio;?>"  title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a></td>
							</tr>
                            <?php } } else {?>
                            <tr>
								<td class="centrarCelda" colspan="4" height="150">No se encontraron usuarios</td>
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
      <a href="admin.php?ver=<?php echo $ver?>&inicio=<?php echo $anterior;?>" class="borrar"><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>							
	  <?php }?>
      
      <input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual;?>" onchange="location.href='admin.php?ver=<?php echo $ver?>&pagina='+this.value"> 
          
      <?php if ($siguiente < $total) {?>
      <a href="admin.php?ver=<?php echo $ver?>&inicio=<?php echo $siguiente;?>" class="borrar"><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
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