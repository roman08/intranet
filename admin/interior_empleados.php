<?php
if(isset($_GET['buscar'])){ $buscar=$_GET['buscar']; } else { $buscar='';}
if(isset($_GET['id_empleado'])){ $id_empleado=$_GET['id_empleado']; } else { $id_empleado='';}

										function Recursivo($id, $nombre, $seleccionado){
											$c=ProcesaQuery("select A.id_seccion, A.nombre
											from intranet_organigrama A
											where A.padre='$id'
											order by A.orden;");
												while($r=FetchArray($c)){
													echo '<option value="'.$r['id_seccion'].'" ';
													if($r['id_seccion']==$seleccionado) { echo 'selected="selected"';}
													echo '>'.$nombre.' / '.$r['nombre'].'</option>';
											Recursivo($r['id_seccion'], $nombre.' / '.$r['nombre'], '0');		}

										}

switch ($opcion){

case 'Nuevo': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Agregar Empleado</h3>
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
								<label class="col-sm-3 control-label">*Núm de empleado</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nroempleado" id="nroempleado"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Nombre </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Apellido Paterno </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="apellidop" id="apellidop"  required>
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">Apellido Materno </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="apellidom" id="apellidom" >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">*Puesto </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="puesto" id="puesto"  required>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-3 control-label">Fecha de nacimiento </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="fecha" id="fecha"
                                    pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" placeholder="dd-mm-aaaa"  />
								</div>
							</div>

              <div class="form-group">
								<label class="col-sm-3 control-label">*Fotografía</label>
								<div class="col-sm-5">
									<input name="archivo" id="archivo" type="file" class="form-control" />
									<small>Tamaño de imagen 132 x 185px</small>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">*Archivo</label>
								<div class="col-sm-5">
									<input name="archivo2" id="archivo2" type="file" class="form-control" />
									<small>Archivo Organigrama</small>
								</div>
							</div>

              <div class="form-group">
								<label class="col-sm-3 control-label">*Integrante de </label>
								<div class="col-sm-5">
									<select class="form-control" name="id_seccion" id="id_seccion"  required>
                                    	<?php
										$c=ProcesaQuery("select A.id_seccion, A.nombre
										from intranet_organigrama A
										where A.padre='0'
										order by A.orden;");
										while($r=FetchArray($c)){
										echo '<option value="'.$r['id_seccion'].'">'.$r['nombre'].'</option>';
										Recursivo($r['id_seccion'], $r['nombre'], '0');
										}
										?>

                                    </select>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Empleado del Més </label>
								<div class="col-sm-5">
									<input name="empleado" id="empleado" type="checkbox" value="1" />
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
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Usuario (email) </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="correo" id="correo"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Contraseña </label>
								<div class="col-sm-5">
									<input class="form-control" type="password" name="contrasena" id="contrasena"  required>
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
$row=FetchArray(ProcesaQuery("select * from intranet_empleados where id_empleado='$id_empleado';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Modificar Empleado</h3>
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
								<label class="col-sm-3 control-label">*Núm de empleado</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nroempleado" id="nroempleado" value="<?php echo $row['nroempleado'];?>"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Nombre </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $row['nombre'];?>" required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Apellido Paterno </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="apellidop" id="apellidop" value="<?php echo $row['apellidop'];?>" required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">Apellido Materno </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="apellidom" id="apellidom" value="<?php echo $row['apellidom'];?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">*Puesto </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="puesto" id="puesto" value="<?php echo $row['puesto'];?>"  required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Fecha de nacimiento </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="fecha" id="fecha"
                                    pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" placeholder="dd-mm-aaaa"  />
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-3 control-label">*Fotografía</label>
								<div class="col-sm-5">
                                	<?php if($row['imagen']!='' and file_exists('../empleados/'.$row['imagen'])){ echo '<img class="imagenNoticiasB" src="../empleados/'.$row['imagen'].'" width="182"/><br/>'; } else { echo 'Sin Imagen<br/>';}?>
									<input name="archivo" id="archivo" type="file" class="form-control" />
									<small>Tamaño de imagen 132 x 185px</small>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">*Archivo</label>
								<div class="col-sm-5">
                  <?php if($row['archivo']!='' and file_exists('../empleados/'.$row['archivo'])){
										echo '<a href="../empleados/'.$row['archivo'].'">Descargar</a><br/>'; } else { echo 'Sin Archivo<br/>';}?>
									<input name="archivo2" id="archivo2" type="file" class="form-control" />
									<small>Archivo Organigrama</small>
								</div>
							</div>


                            <div class="form-group">
								<label class="col-sm-3 control-label">*Integrante de </label>
								<div class="col-sm-5">
									<select class="form-control" name="id_seccion" id="id_seccion"  required>
                                    	<?php
										$c=ProcesaQuery("select A.id_seccion, A.nombre
										from intranet_organigrama A
										where A.padre='0'
										order by A.orden;");
										while($r=FetchArray($c)){
										echo '<option value="'.$r['id_seccion'].'" ';
													if($r['id_seccion']==$row['id_seccion']) { echo 'selected="selected"';}
													echo '>'.$r['nombre'].'</option>';
										Recursivo($r['id_seccion'], $r['nombre'], $row['id_seccion']);
										}
										?>

                                    </select>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Empleado del Més </label>
								<div class="col-sm-5">
									<input name="empleado" class="form-control" id="empleado" type="checkbox" value="1" <?php if($row['empleado']=='1'){ echo 'checked="checked"';}?> />
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
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Usuario (email) </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="correo" id="correo" value="<?php echo $row['correo'];?>"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Contraseña </label>
								<div class="col-sm-5">
									<input class="form-control" type="password" name="contrasena" id="contrasena">
									<small>Solo completar en caso de cambio</small>
								</div>
							</div>

							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="id_empleado" type="hidden" id="id_empleado" value="<?php echo $row['id_empleado'];?>">
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
						<h3 class="azulMedio">Empleados</h3>
<!-- 						<p>En la siguiente lista usted podrá visualizar las facturas que ha registrado en el sistema y el estatus de las mismas.      </p>
 -->					</div>
					<div class="col-xs-12 col-sm-4">
						<button id="preguntaR" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>'"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
						<button id="pregunta" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>&opcion=Nuevo'"><img class="iconUser" src="img/ipreguntas.png" alt="preguntas frecuentes">Agregar Empleado</button>
					</div>
				</div>

        <div class="row">
							<div id="formCalendario">
	                    <form action="admin_procesa.php" method="post" enctype="multipart/form-data" id="form_contacto">
			                    	<div class="form-group">
				                        <ul class="listFormA">
				                        	<li class="liFecha">
																		<a href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Descargar_Excel" class="btn btnEnviar bco descargarReg">Descargar Ejemplo</a>
																	</li>
				                          <li><button class="btn btnConsultar btnAzmed bco" type="submit"><img class="iconUser" src="img/iconsultar.png" alt="consultar">Agregar Empleados desde Archivo</button></li>
				                          <li class="liFecha"><input name="archivo" id="archivo" type="file" class="form-control" /></li>
				                        </ul>
				                    </div>
                            <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                            <input name="accion" type="hidden" id="accion" value="Cargar_Excel">
	                    </form>
          		</div>
				</div>

                <div class="row">
					<div id="formCalendario">
	                    <form action="admin.php" method="get" enctype="multipart/form-data" id="form_contacto">
	                    	<div class="form-group">
		                        <ul class="listFormA">
		                           	<li><button class="btn btnConsultar btnAzmed bco" type="submit"><img class="iconUser" src="img/iconsultar.png" alt="consultar">Buscar</button></li>
		                            <li class="liFecha">
										<input class="form-control" type="text" name="buscar" id="buscar"   value="<?php echo $buscar;?>">
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
							  <th>Registro</th>
							  <th>NroEmpleado</th>
							  <th>Nombre Completo</th>
							  <th>Email</th>
							  <th>Estatus</th>
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

						  $bus="";
						  if($buscar!=''){ $bus="where nombre LIKE '%$buscar%' or apellidop LIKE '%$buscar%' or apellidom LIKE '%$buscar%' or nroempleado LIKE '%$buscar%' or correo LIKE '%$buscar%'";}

						  $consulta=ProcesaQuery("select *, if(activo='1', 'Activo', 'Inactivo') as elestatus from intranet_empleados $bus order by nombre, apellidop, apellidom asc limit $inicio, $rxp;");
						  $total= NumRows(ProcesaQuery("select * from intranet_empleados $bus;"));
						if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							$contador=0;
						  while ($row=FetchArray($consulta)) {
							  $contador++;
						  ?>
							<tr>
							  <td class="centrarCelda"><?php echo fecha_ddmmaaaahhmmss($row['registro']);?></td>
							  <td class="centrarCelda"><?php echo $row['nroempleado'];?></td>
							  <td class="centrarCelda"><?php echo $row['nombre'].' '.$row['apellidop'].' '.$row['apellidom'];?></td>
							  <td class="centrarCelda"><?php echo $row['correo'];?></td>
							  <td class="centrarCelda"><?php echo $row['elestatus'];?></td>
							  <td>
                                <a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Modificar&id_empleado=<?php echo $row['id_empleado'];?>" title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
                                <a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Eliminar&id_empleado=<?php echo $row['id_empleado'];?>&inicio=<?php echo $inicio;?>" title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a></td>
							</tr>
                            <?php } } else {?>
							<tr>
							  <td height="150" colspan="6" class="txtPregunta">No se encontraron  Registros</td>
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
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Listar&inicio=<?php echo $anterior;?>" ><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>
	  <?php }?>

      <input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual;?>" onchange="location.href='admin.php?ver=<?php echo $ver?>&opcion=Listar&pagina='+this.value">

      <?php if ($siguiente < $total) {?>
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Listar&inicio=<?php echo $siguiente;?>" ><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
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
