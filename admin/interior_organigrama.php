<?php
if(isset($_GET['padre'])){ $padre=$_GET['padre']; } else { $padre='';}
if(isset($_GET['id_seccion'])){ $id_seccion=$_GET['id_seccion']; } else { $id_seccion='';}
switch ($opcion){

case 'Organigrama_Nuevo': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio"><?php $nodo=FetchArray(ProcesaQuery("select * from intranet_organigrama where id_seccion='$padre';")); echo $nodo['nombre'].'<br/>';?>Agregar Subsección</h3>
						<!--<p>Registre los datos que a continuación se solicitan</p> -->
					</div>
					<div class="col-xs-12 col-sm-2 col-md-6">
						<button id="btn_RegresarUD" class="btn btn-lg btnAzmed bco" onClick="location.href='admin.php?ver=<?php echo $ver?>&opcion=Organigrama_Listar&padre=<?php echo $padre;?>'" ><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
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
								<label class="col-sm-3 control-label">*Nombre</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre"  required>
								</div>
							</div>

              <!--<div class="form-group">
								<label class="col-sm-3 control-label">*Imagen</label>
								<div class="col-sm-5">
									<input name="archivo" id="archivo" type="file" class="form-control" required/>
									<small>Tamaño de imagen 132 x 185px</small>
								</div>
							</div>-->

                            <div class="form-group">
								<label class="col-sm-3 control-label">*Descripción</label>
								<div class="col-sm-5">
									<textarea name="descripcion" id="descripcion" class="form-control"></textarea>
								</div>
							</div>
							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Agregar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="accion" id="accion" type="hidden" value="Organigrama_Guardar" />
                        <input name="padre" type="hidden" id="padre" value="<?php echo $padre;?>">
					</form>
				</div>
			</div>
		</article>
	</section>
<?php
break;
case 'Organigrama_Modificar':
$row=FetchArray(ProcesaQuery("select * from intranet_organigrama where id_seccion='$id_seccion';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio"><?php $nodo=FetchArray(ProcesaQuery("select * from intranet_organigrama where id_seccion='$padre';")); echo $nodo['nombre'].'<br/>';?>
					     Modificar Subsección</h3>
						<!--<p>Registre los datos que a continuación se solicitan</p> -->
				  </div>
					<div class="col-xs-12 col-sm-2 col-md-6">
						<button id="btn_RegresarU" class="btn btn-lg btnAzmed bco" onClick="location.href='admin.php?ver=<?php echo $ver?>&opcion=Organigrama_Listar&padre=<?php echo $padre;?>'"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
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
								<label class="col-sm-3 control-label">*Nombre</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $row['nombre'];?>" required>
								</div>
							</div>

              <!--<div class="form-group">
								<label class="col-sm-3 control-label">*Imagen</label>
								<div class="col-sm-5">
									<div class="col-sm-12" style="overflow:hidden; padding:opx;">
                                	<?php if($row['imagen']!='' and file_exists('../organigrama/'.$row['imagen'])){ echo '<img class="imagenNoticiasB" src="../organigrama/'.$row['imagen'].'" /><br/>'; } else { echo 'Sin Imagen<br/>';}?>
									</div>
									<input name="archivo" id="archivo" type="file" class="form-control modIn" />
									<small>Tamaño de imagen 132 x 185px</small>
								</div>
							</div>-->

              <div class="form-group">
								<label class="col-sm-3 control-label">*Descripción</label>
								<div class="col-sm-5">
									<textarea name="descripcion" id="descripcion" class="form-control"><?php echo $row['descripcion'];?></textarea>
								</div>
							</div>





							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
								<button class="btn btn-lg btn-primary" type="reset">Cancelar</button>
								<span class="azulMedio requeridos requeridosA">*Datos Requeridos</span>
							</div>
						</div>
                        <input name="ver" type="hidden" id="ver" value="<?php echo $ver;?>">
                        <input name="id_seccion" type="hidden" id="id_seccion" value="<?php echo $row['id_seccion'];?>">
                        <input name="accion" id="accion" type="hidden" value="Organigrama_Modificar" />
                        <input name="padre" type="hidden" id="padre" value="<?php echo $padre;?>">
					</form>
				</div>
			</div>
		</article>
	</section>
<?php
break;
case 'Organigrama_Listar': ?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8">
						<h3 class="azulMedio"><?php $nodo=FetchArray(ProcesaQuery("select * from intranet_organigrama where id_seccion='$padre';")); echo $nodo['nombre'].'<br/>';?>
					    Subsecciónes</h3>
  				<!-- 						<p>En la siguiente lista usted podrá visualizar las facturas que ha registrado en el sistema y el estatus de las mismas.      </p>
 --></div>
					<div class="col-xs-12 col-sm-4">
						<button id="preguntaR" class="btn btn-lg btnAzmed bco" onclick="location.href='admin.php?ver=<?php echo $ver;?>&opcion=<?php if($nodo['padre']!='0'){ echo 'Organigrama_';}?>Listar&padre=<?php echo $nodo['padre'];?>';"><span class="glyphicon glyphicon-triangle-left"></span>Regresar</button>
						<button id="pregunta" class="btn btn-lg btnAzmed bco" onClick="location.href='admin.php?ver=<?php echo $ver?>&opcion=Organigrama_Nuevo&padre=<?php echo $padre;?>'"><img class="iconUser" src="img/ipreguntas.png" alt="preguntas frecuentes">Agregar Subsección</button>
					</div>
				</div>

				<div id="" class="row">
					<table id="tablePreguntas" class="table table-striped table-responsive tableGeneral">
						<thead>
							<tr class="back_azulMedio bco">
							  <th>Clave</th>
							  <th>Registro</th>
							  <th>Subsección</th>
							  <th>Subsecciones</th>
								<th class="thAcciones">Orden</th>
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

						  $consulta=ProcesaQuery("select A.*, COUNT(B.id_seccion) as subsecciones from intranet_organigrama A
						  LEFT JOIN intranet_organigrama B ON A.id_seccion=B.padre
						  WHERE A.padre='$padre'
						  GROUP BY A.id_seccion
						  ORDER by A.orden asc limit $inicio, $rxp;");
						  $total=NumRows(ProcesaQuery("select A.* from intranet_organigrama A  WHERE A.padre='$padre';"));
					if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							$contador=0;
						  while ($row=FetchArray($consulta)) {
							  $contador++;
						  ?>
							<tr>
							  <td class="centrarCelda"><?php echo $row['id_seccion'];?></td>
								<td class="centrarCelda"><?php echo fecha_ddmmaaaahhmmss($row['registro']);?></td>
								<td class="centrarCelda"><?php echo $row['nombre'];?></td>
								<td class="centrarCelda"><a href="admin.php?ver=<?php echo $ver;?>&opcion=Organigrama_Listar&padre=<?php echo $row['id_seccion'];?>"><?php echo $row['subsecciones'];?></a></td>
								<td><?php if ($contador!=1) {?><a class="link_ver"  href="admin_procesa.php?ver=<?php echo $ver?>&orden1=<?php echo $row['orden'];?>&orden2=<?php echo $row['orden']-1;?>&accion=Organigrama_Ordenar&inicio=<?php echo $inicio;?>&padre=<?php echo $padre;?>&id_seccion=<?php echo $row['id_seccion'];?>"><span class="glyphicon glyphicon-arrow-up naranja" aria-hidden="true" title="Subir"></span></a><?php } ?>
								<?php if ($contador!=$total)  {?><a class="link_ver"  href="admin_procesa.php?ver=<?php echo $ver?>&orden1=<?php echo $row['orden'];?>&orden2=<?php echo $row['orden']+1;?>&accion=Organigrama_Ordenar&inicio=<?php echo $inicio;?>&padre=<?php echo $padre;?>&id_seccion=<?php echo $row['id_seccion'];?>"><span class="glyphicon glyphicon-arrow-down naranja" aria-hidden="true" title="Bajar"></span></a><?php } ?></td>

								<td>
                                <a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Organigrama_Modificar&id_seccion=<?php echo $row['id_seccion'];?>&padre=<?php echo $padre;?>" title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
                                <a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver;?>&accion=Organigrama_Eliminar&id_seccion=<?php echo $row['id_seccion'];?>&inicio=<?php echo $inicio;?>&padre=<?php echo $padre;?>" title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a></td>
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
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Organigrama_Listar&padre=<?php echo $padre;?>&inicio=<?php echo $anterior;?>" class="borrar"><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>
	  <?php }?>

      <input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual;?>" onchange="location.href='admin.php?ver=<?php echo $ver?>&opcion=Organigrama_Listar&padre=<?php echo $padre;?>&pagina='+this.value">

      <?php if ($siguiente < $total) {?>
      <a href="admin.php?ver=<?php echo $ver?>&opcion=Organigrama_Listar&padre=<?php echo $padre;?>&inicio=<?php echo $siguiente;?>" class="borrar"><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
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
case 'Nuevo':
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Nueva Sección</h3>
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
								<label class="col-sm-3 control-label">*Nombre</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre"  required>
								</div>
							</div>

              <!--<div class="form-group">
								<label class="col-sm-3 control-label">*Imagen</label>
								<div class="col-sm-5">
									<input name="archivo" id="archivo" type="file" class="form-control" required/>
									<small>Tamaño de imagen 132 x 185px</small>
								</div>
							</div>-->

                            <div class="form-group">
								<label class="col-sm-3 control-label">*Descripción</label>
								<div class="col-sm-5">
									<textarea name="descripcion" id="descripcion" class="form-control"></textarea>
								</div>
							</div>
							<div id="contBtnDatos" class="col-sm-8 ">
								<button class="btn btn-lg btnEnviar negro" type="submit">Modificar</button>
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
$row=FetchArray(ProcesaQuery("select * from intranet_organigrama where id_seccion='$id_seccion';"));
?>
<section>
		<article>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-6">
						 <h3 class="azulMedio">Modificar Sección</h3>
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
								<label class="col-sm-3 control-label">*Nombre</label>
								<div class="col-sm-5">
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $row['nombre'];?>" required>
								</div>
							</div>

              <!--<div class="form-group">
								<label class="col-sm-3 control-label">*Imagen</label>
								<div class="col-sm-5">
									<div class="col-sm-12" style="overflow:hidden; padding:opx;">
                    <?php if($row['imagen']!='' and file_exists('../organigrama/'.$row['imagen'])){ echo '<img class="imagenNoticiasB" src="../organigrama/'.$row['imagen'].'" /><br/>'; } else { echo 'Sin Imagen<br/>';}?>
									</div>
									<input name="archivo" id="archivo" type="file" class="form-control modIn" />
									<small>Tamaño de imagen 132 x 185px</small>
								</div>
							</div>-->

              <div class="form-group">
								<label class="col-sm-3 control-label">*Descripción</label>
								<div class="col-sm-5">
									<textarea name="descripcion" id="descripcion" class="form-control"><?php echo $row['descripcion'];?></textarea>
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
                        <input type="hidden" id="id_seccion" name="id_seccion" value="<?php echo $row['id_seccion'];?>">
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
						<h3 class="azulMedio">Secciónes</h3>
		    <!-- 						<p>En la siguiente lista usted podrá visualizar las facturas que ha registrado en el sistema y el estatus de las mismas.      </p>
 --></div>
					<div class="col-xs-12 col-sm-4">

					</div>
                    <div class="col-xs-12 col-sm-4">
						<button id="pregunta" class="btn btn-lg btnAzmed bco" onClick="location.href='admin.php?ver=<?php echo $ver?>&opcion=Nuevo'"><img class="iconUser" src="img/ipreguntas.png" alt="preguntas frecuentes">Agregar Sección</button>

					</div>
				</div>

				<div id="" class="row">
					<table id="tablePreguntas" class="table table-striped table-responsive tableGeneral">
						<thead>
							<tr class="back_azulMedio bco">
								<th>Clave</th>
								<th>Registro</th>
								<th>Sección</th>
								<th>Subsecciónes</th>
								<th class="thAcciones">Orden</th>
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

						  $consulta=ProcesaQuery("select A.*, COUNT(B.id_seccion) as subsecciones from intranet_organigrama A
						  LEFT JOIN intranet_organigrama B ON A.id_seccion=B.padre
						  where A.padre='0'
						  GROUP BY A.id_seccion
						  ORDER by A.orden limit $inicio, $rxp;");
						  $total=NumRows(ProcesaQuery("select * from intranet_organigrama where padre='0';"));
					if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
						if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
						  if ($total>0) {
							$contador=0;
						  while ($row=FetchArray($consulta)) {
							  $contador++;
						  ?>
							<tr>
								<td class="centrarCelda"><?php echo $row['id_seccion'];?></td>
								<td class="centrarCelda"><?php echo fecha_ddmmaaaahhmmss($row['registro']);?></td>
								<td class="centrarCelda"><?php echo $row['nombre'];?></td>
								<td class="centrarCelda"><a href="admin.php?ver=<?php echo $ver;?>&opcion=Organigrama_Listar&padre=<?php echo $row['id_seccion'];?>"><?php echo $row['subsecciones'];?></a></td>

								<td>
                <?php if ($contador!=1) {?>
									<a class="link_ver"  href="admin_procesa.php?ver=<?php echo $ver?>&id_seccion=<?php echo $row['id_seccion'];?>&orden1=<?php echo $row['orden'];?>&orden2=<?php echo $row['orden']-1;?>&accion=Ordenar&inicio=<?php echo $inicio;?>"><span class="glyphicon glyphicon-arrow-up naranja" aria-hidden="true" title="Subir"></span></a><?php } ?>
								<?php if ($contador!=$total)  {?><a class="link_ver"  href="admin_procesa.php?ver=<?php echo $ver?>&id_seccion=<?php echo $row['id_seccion'];?>&orden1=<?php echo $row['orden'];?>&orden2=<?php echo $row['orden']+1;?>&accion=Ordenar&inicio=<?php echo $inicio;?>"><span class="glyphicon glyphicon-arrow-down naranja" aria-hidden="true" title="Bajar"></span></a><?php } ?>
                </td>
								<td>
                                <a class="link_ver link_verA"  href="admin.php?ver=<?php echo $ver;?>&opcion=Modificar&id_seccion=<?php echo $row['id_seccion'];?>" title="Modificar"><span class="glyphicon glyphicon-pencil naranja" aria-hidden="true" title="Editar"></span></a>
                                </td>
							</tr>
                            <?php } } else {?>
							<tr>
							  <td height="150" colspan="6" class="txtPregunta">No se encontraron Registros</td>
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
