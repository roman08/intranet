<?php
if(isset($_GET['id_categoria'])){ $id_categoria=$_GET['id_categoria']; } else { $id_categoria='';}
if(isset($_GET['id_documento'])){ $id_documento=$_GET['id_documento']; } else { $id_documento='';}

 function Recursivo($id, $nombre, $seleccionado){
											$c=ProcesaQuery("select A.id_seccion, A.nombre, IFNULL(B.id_seccion, 0) as seleccionado
											from intranet_organigrama A
											LEFT JOIN intranet_documentos_secciones B ON A.id_seccion=B.id_seccion and B.id_documento='$seleccionado'
											where A.padre='$id'
											order by A.orden;");
												while($r=FetchArray($c)){

													echo '<tr>
                                        <td><input name="seccion'.$r['id_seccion'].'" id="seccion'.$r['id_seccion'].'" type="checkbox" class="form-control" value="1" ';
										if($r['id_seccion']==$r['seleccionado']) { echo 'checked="checked"';}
										echo ' /></td>
                                        <td>'.$nombre.' / '.$r['nombre'].'</td>
                                      </tr>';
											Recursivo($r['id_seccion'], $nombre.' / '.$r['nombre'], $seleccionado);	}

										}

switch ($opcion){

case 'Documentos_Nuevo': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Agregar Documento</h3>
						<?php $r1=FetchArray(ProcesaQuery("SELECT titulo from intranet_documentos_categorias where id_categoria='$id_categoria';")); echo '<p>Categoría <strong>'.$r1['titulo'].'</strong></p>';?>
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
								<label class="col-sm-3 control-label">*Clave Documento</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="clave" id="clave"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Titulo </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="titulo" id="titulo"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Formato </label>
								<div class="col-sm-5">
									<select name="formato" id="formato" class="form-control">
                                    	<option value="Word">Word</option>
                                        <option value="Excel">Excel</option>
                                        <option value="PowerPoint">PowerPoint</option>
                                        <option value="PDF">PDF</option>
                                    </select>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Archivo</label>
								<div class="col-sm-5">
									<input name="archivo" id="archivo" type="file" class="form-control" required />
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
								<label class="col-sm-3 control-label">*Disponible para </label>
								<div class="col-sm-5">
									<table border="0" cellspacing="0" cellpadding="0">
                                     <?php
										$c=ProcesaQuery("select A.id_seccion, A.nombre
										from intranet_organigrama A
										where A.padre='0'
										order by A.orden;");
										while($r=FetchArray($c)){
										echo '<tr>
                                        <td><input name="seccion'.$r['id_seccion'].'" id="seccion'.$r['id_seccion'].'" type="checkbox" class="form-control" value="1"  /></td>
                                        <td>'.$r['nombre'].'</td>
                                      </tr>';

										Recursivo($r['id_seccion'], $r['nombre'], '0');
										}
										?>
                                    </table>
								</div>
							</div>



							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Agregar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
						<input name="id_categoria" type="hidden" id="id_categoria" value="<?php echo $id_categoria;?>">
                        <input name="accion" id="accion" type="hidden" value="Documentos_Guardar" />
					</form>
				</div>
			</div>
		</article>
	</section>
<?php
break;
case 'Documentos_Modificar':
$row=FetchArray(ProcesaQuery("select * from intranet_documentos where id_documento='$id_documento';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Modificar Documento</h3>
						<?php $r1=FetchArray(ProcesaQuery("SELECT titulo from intranet_documentos_categorias where id_categoria='$id_categoria';")); echo '<p>Categoría <strong>'.$r1['titulo'].'</strong></p>';?>
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
								<label class="col-sm-3 control-label">*Clave Documento</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="clave" id="clave" value="<?php echo $row['clave'];?>"  required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Titulo </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="titulo" id="titulo" value="<?php echo $row['titulo'];?>" required>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Formato </label>
								<div class="col-sm-5">
									<select name="formato" id="formato" class="form-control">
                                    	<option value="Word" <?php if($row['activo']=='Word'){ echo 'selected="selected"';}?>>Word</option>
                                        <option value="Excel" <?php if($row['activo']=='Excel'){ echo 'selected="selected"';}?>>Excel</option>
                                        <option value="PowerPoint" <?php if($row['activo']=='PowerPoint'){ echo 'selected="selected"';}?>>PowerPoint</option>
                                        <option value="PDF" <?php if($row['activo']=='PDF'){ echo 'selected="selected"';}?>>PDF</option>
                                    </select>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">*Archivo</label>
								<div class="col-sm-5">
                                	<?php if($row['archivo']!=''){ echo '<a href="admin_procesa.php?ver=documentos&accion=Descargar&id_documento='.$row['id_documento'].'" />Descargar</a><br/>'; } else { echo 'Sin Archivo<br/>';}?>
									<input name="archivo" id="archivo" type="file" class="form-control" />
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
								<label class="col-sm-3 control-label">*Disponible para </label>
								<div class="col-sm-5">
									<table border="0" cellspacing="0" cellpadding="0">
                                      <?php
										$c=ProcesaQuery("select A.id_seccion, A.nombre, IFNULL(B.id_seccion, 0) as seleccionado
										from intranet_organigrama A
										LEFT JOIN intranet_documentos_secciones B ON A.id_seccion=B.id_seccion and B.id_documento='$row[id_documento]'
										where A.padre='0'
										order by A.orden;");
										while($r=FetchArray($c)){
										echo '<tr>
                                        <td><input name="seccion'.$r['id_seccion'].'" id="seccion'.$r['id_seccion'].'" type="checkbox" class="form-control" value="1" ';
										if($r['id_seccion']==$r['seleccionado']) { echo 'checked="checked"';}
										echo ' /></td>
                                        <td>'.$r['nombre'].'</td>
                                      </tr>';

										Recursivo($r['id_seccion'], $r['nombre'], $row['id_documento']);
										}
										?>
                                    </table>
								</div>
							</div>

							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="id_documento" type="hidden" id="id_documento" value="<?php echo $row['id_documento'];?>">
						<input name="id_categoria" type="hidden" id="id_categoria" value="<?php echo $id_categoria;?>">
                        <input name="accion" id="accion" type="hidden" value="Documentos_Modificar" />
					</form>
				</div>
			</div>
		</article>
	</section>
<?php
break;
case 'Documentos_Listar': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8">
						<h3 class="azulMedio">Documentos</h3>
						<?php $r1=FetchArray(ProcesaQuery("SELECT titulo from intranet_documentos_categorias where id_categoria='$id_categoria';")); echo '<p>Categoría <strong>'.$r1['titulo'].'</strong></p>';?>
					</div>
					<div class="col-xs-12 col-sm-4">
						<button id="preguntaR" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>'"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
						<button id="pregunta" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>&id_categoria=<?php echo $id_categoria;?>&opcion=Documentos_Nuevo'"><img class="iconUser" src="img/ipreguntas.png" >Agregar Documento</button>
					</div>
				</div>

				<div id="" class="row">
					<table id="tablePreguntas" class="table table-striped table-responsive tableGeneral">
						<thead>
							<tr class="back_azulMedio bco">
							  <th>Registro</th>
							  <th>Clave</th>
							  <th>Documento</th>
							  <th>Estatus</th>
							  <th >Archivo</th>
							  <th>Orden</th>
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

						  $consulta=ProcesaQuery("select *, if(activo='1', 'Activo', 'Inactivo') as elestatus FROM intranet_documentos WHERE id_categoria='$id_categoria' order by orden limit $inicio, $rxp;");
						  $total=NumRows(ProcesaQuery("select * FROM intranet_documentos WHERE id_categoria='$id_categoria';"));
					if($inicio=='0'){ $pagina_actual='1';} else { $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){ $cantidad_paginas=1; } else { $cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							$contador=0;
						  while ($row=FetchArray($consulta)) {
							  $contador++;
						  ?>
							<tr>
							  <td class="centrarCelda"><?php echo fecha_ddmmaaaahhmmss($row['registro']);?></td>
							  <td class="centrarCelda"><?php echo $row['clave'];?></td>
							  <td class="centrarCelda"><?php echo $row['titulo'];?></td>
							  <td class="centrarCelda"><?php echo $row['elestatus'];?></td>
							  <td><?php if($row['archivo']!=''){ echo '<a href="admin_procesa.php?ver=documentos&accion=Descargar&id_documento='.$row['id_documento'].'" />Ver</a>'; } else { echo 'Sin Archivo';}?></td>
							  <td><?php if ($contador!=1) {?><a class="link_ver"  href="admin_procesa.php?ver=<? echo $ver?>&orden1=<? echo $row['orden'];?>&orden2=<? echo $row['orden']-1;?>&accion=Documentos_Ordenar&inicio=<? echo $inicio;?>&id_documento=<?php echo $row['id_documento'];?>&id_categoria=<?php echo $id_categoria;?>"><span class="glyphicon glyphicon-arrow-up naranja" aria-hidden="true" title="Subir"></span></a><?php } ?>
								<?php if ($contador!=$total)  {?><a class="link_ver"  href="admin_procesa.php?ver=<? echo $ver?>&orden1=<? echo $row['orden'];?>&orden2=<? echo $row['orden']+1;?>&accion=Documentos_Ordenar&inicio=<? echo $inicio;?>&id_documento=<?php echo $row['id_documento'];?>&id_categoria=<?php echo $id_categoria;?>"><span class="glyphicon glyphicon-arrow-down naranja" aria-hidden="true" title="Bajar"></span></a><?php } ?></td>
							  <td>
                                <a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Documentos_Modificar&id_documento=<?php echo $row['id_documento'];?>&id_categoria=<?php echo $id_categoria;?>" title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
                                <a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Documentos_Eliminar&id_documento=<?php echo $row['id_documento'];?>&inicio=<?php echo $inicio;?>&id_categoria=<?php echo $id_categoria;?>" title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a></td>
							</tr>
                            <?php } } else {?>
							<tr>
							  <td height="150" colspan="7" class="txtPregunta">No se encontraron  Registros</td>
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
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Documentos_Listar&inicio=<?php echo $anterior;?>" class="borrar"><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>
	  <?php }?>

      <input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual;?>" onchange="location.href='admin.php?ver=<?php echo $ver?>&opcion=Documentos_Listar&pagina='+this.value">

      <?php if ($siguiente < $total) {?>
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Documentos_Listar&inicio=<?php echo $siguiente;?>" class="borrar"><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
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
case 'Nuevo': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Agregar Documento</h3>
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
								<label class="col-sm-3 control-label">*Titulo </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="titulo" id="titulo"  required>
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
$row=FetchArray(ProcesaQuery("select * from intranet_documentos_categorias where id_categoria='$id_categoria';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Modificar Documento</h3>
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
								<label class="col-sm-3 control-label">*Titulo </label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="titulo" id="titulo" value="<?php echo $row['titulo'];?>" required>
								</div>
							</div>
                            

							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>
							
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="id_categoria" type="hidden" id="id_categoria" value="<?php echo $row['id_categoria'];?>">
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
						<h3 class="azulMedio">Documentos</h3>
<!-- 						<p>En la siguiente lista usted podrá visualizar las facturas que ha registrado en el sistema y el estatus de las mismas.      </p>
 -->					</div>
					<div class="col-xs-12 col-sm-4">
						<button id="preguntaR" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>'"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
						<button id="pregunta" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>&opcion=Nuevo'"><img class="iconUser" src="img/ipreguntas.png" >Agregar Categoría</button>
					</div>
				</div>

				<div id="" class="row">
					<table id="tablePreguntas" class="table table-striped table-responsive tableGeneral">
						<thead>
							<tr class="back_azulMedio bco">
							  <th>Registro</th>
							  <th>Categoría</th>
							  <th>Documentos</th>
							  <th>Orden</th>
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

						  $consulta=ProcesaQuery("select A.*, COUNT(B.id_documento) as cantidad from intranet_documentos_categorias A 
						  LEFT JOIN intranet_documentos B ON A.id_categoria=B.id_categoria 
						  group by A.id_categoria 
						  order by A.orden limit $inicio, $rxp;");
						  $total=NumRows(ProcesaQuery("select A.* from intranet_documentos_categorias A;"));
					if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							$contador=0;
						  while ($row=FetchArray($consulta)) {
							  $contador++;
						  ?>
							<tr>
							  <td class="centrarCelda"><?php echo fecha_ddmmaaaahhmmss($row['registro']);?></td>
							  <td class="centrarCelda"><?php echo $row['titulo'];?></td>
							  <td class="centrarCelda"><a href="admin.php?ver=<?php echo $ver?>&opcion=Documentos_Listar&id_categoria=<?php echo $row['id_categoria'];?>"><?php echo $row['cantidad'];?></a></td>
							  <td>
									<?php if ($contador!=1) {?><a class="link_ver"  href="admin_procesa.php?ver=<? echo $ver?>&orden1=<? echo $row['orden'];?>&orden2=<? echo $row['orden']-1;?>&accion=Ordenar&inicio=<? echo $inicio;?>&id_categoria=<?php echo $row['id_categoria'];?>"><span class="glyphicon glyphicon-arrow-up naranja" aria-hidden="true" title="Subir"></span></a><?php } ?>
									<?php if ($contador!=$total)  {?><a class="link_ver"  href="admin_procesa.php?ver=<? echo $ver?>&orden1=<? echo $row['orden'];?>&orden2=<? echo $row['orden']+1;?>&accion=Ordenar&inicio=<? echo $inicio;?>&id_categoria=<?php echo $row['id_categoria'];?>"><span class="glyphicon glyphicon-arrow-down naranja" aria-hidden="true" title="Bajar"></span></a><?php } ?></td>
							  <td>
                                <a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Modificar&id_categoria=<?php echo $row['id_categoria'];?>" title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
                                <a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Eliminar&id_categoria=<?php echo $row['id_categoria'];?>&inicio=<?php echo $inicio;?>" title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a></td>
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
