<!-- documnetos -->
<?php
if(isset($_GET['categoria'])){ $categoria=$_GET['categoria'];} else {$categoria='';}
if(isset($_GET['buscador'])){ $buscador=$_GET['buscador'];} else {$buscador='';}
if(isset($_GET['desde'])){ $desde=$_GET['desde'];} else {$desde='';}
if(isset($_GET['hasta'])){ $hasta=$_GET['hasta'];} else {$hasta='';}
?>	<article id="documentos">
		<h3 class="TitBloque">DOCUMENTOS</h3>
		<div class="contDoc">
			<form action="index.php" method="get" class="formulario">
				<ul>
					<li id="liBuscador">
						<input class="form" type="search" name="buscador" id="buscador" placeholder="Escribe la clave del documento" value="<?php echo $buscador;?>">
						<button type="submit" id="btnSearch">
							<img id="icSearch" src="img/iconos/lupa.png" alt="">
						</button>
					</li>
					<li class="opcion opcionDesde">
						<p class="desde">Desde</p>
						<input class="form formCh from" name="desde" id="desde" type="text" size="10" maxlength="10" readonly="readonly" placeholder="dia/mes/año" value="<?php echo $desde;?>">
					</li>
					<li class="opcion">
						<p class="">Hasta</p>
						<input class="form formCh to" name="hasta" id="hasta" type="text" id="to" size="10" maxlength="10" readonly="readonly" placeholder="dia/mes/año" value="<?php echo $hasta;?>">
					</li>
					<li id="liSelect">
						<select class="form formCh" name="categoria" id="categoria">
							<option value="">Todas las Categorías</option>
							<?php
							$c=ProcesaQuery("select * from intranet_documentos_categorias");
							while($r= FetchArray($c)){
								echo '<option value="'.$r['id_categoria'].'" ';
								if($r['id_categoria']==$categoria) { echo 'selected';}
								echo '>'.$r['titulo'].'</option>';
							}
							?>
							
						</select>
					</li>
					<li class="boton"><button type="submit" class="btn bold">Filtrar</button></li>
				</ul>
				<input type="hidden" id="ver" name="ver" value="documentos">
			</form>
		</div>

		<!-- lista documentos -->
		<div id="listaDoc" class="contDoc">
			<ul class="listado">
				<?php
				$rxp=6;
				if(($pagina!='') and ($pagina>'0')){ $inicio=($pagina*$rxp)-$rxp;}

				if ($inicio!=''){
				$siguiente=$inicio+$rxp;
				$anterior=$inicio-$rxp;
				} else {
				$inicio=0;
				$anterior=-$rxp;
				$siguiente=$rxp;
				}
				$bus='';
				$dias=array("DOMINGO", "LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO");
				if($buscador!=''){ $bus.="and (A.titulo LIKE '%$buscador%' or A.clave LIKE '%$buscador%' ) "; }
				if($categoria!=''){ $bus.="and A.id_categoria='$categoria' "; }
				if($desde!='' and $hasta!=''){ $bus.="and DATE(A.registro)>='".fecha_aaaammdd($desde)."' and DATE(A.registro)<='".fecha_aaaammdd($hasta)."' ";}
				$consulta=ProcesaQuery("SELECT A.id_documento, A.archivo_ext, B.icono, A.archivo_nombre, A.clave,
				DATE_FORMAT(A.registro, '%w') as dia,
				DATE_FORMAT(A.registro, '%H:%i') as hora,
				DATE_FORMAT(A.registro, '%d.%m.%Y') as fecha, D.titulo as categoria 
				FROM intranet_documentos A 
				JOIN intranet_documentos_iconos B ON A.formato=B.formato 
				JOIN intranet_documentos_secciones C ON C.id_documento=A.id_documento 
				JOIN intranet_documentos_categorias D ON A.id_categoria=D.id_categoria 
				WHERE A.activo='1' and C.id_seccion='".$_SESSION['usuario_seccion']."' $bus ORDER by A.registro DESC LIMIT $inicio, $rxp;");
				$total=NumRows(ProcesaQuery("SELECT A.id_documento FROM intranet_documentos A
					JOIN intranet_documentos_secciones C ON C.id_documento=A.id_documento
					WHERE A.activo='1' and C.id_seccion='".$_SESSION['usuario_seccion']."' $bus;"));
				if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
				if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
				if ($total>0) {
				$contador=0;
				while ($row=FetchArray($consulta)) {
				$contador++; ?>
				<li>
					<p class="DiaDoc bold"><?php echo $dias[$row['dia']];?><br><span class="fecha regular t14"><?php echo $row['fecha'];?></span></p>
					<p class="HoraDoc bold"><?php echo $row['hora'];?></p>
					<p class="NombreDoc"><?php echo $row['archivo_nombre'];?><br><b><?php echo $row['categoria'];?></b></p>
					<p class="claveDoc"><?php echo $row['clave'];?></p>
					<div class="download">
						<a href="procesa.php?ver=sesion&accion=descargar&id=<?php echo $row['id_documento'];?>">
							<img src="img/iconosDoc/<?php echo $row['icono'];?>" alt="acrobat">Descargar
						</a>
					</div>
				</li>
				<li class="espacioBco"></li>
			<?php } } else {?>
				<li>No se encontraron resultados</li>
			<?php }?>
			</ul>
		</div>
	</article>
	<!-- paginador -->
		<div class="extUp">
	        <ul class="paginador paginadorInf">
	            <?php if ($siguiente < $total) {?><li><a href="index.php?ver=<?php echo $ver?>&buscador=<?php echo $buscador;?>&desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&inicio=<?php echo $siguiente;?>"><img src="img/trianguloDer.png" alt="triangulo" /></a></li><?php }?>
	            <li><input type="text" class="numPag" name="pagina" id="pagina" value="<?php echo $pagina_actual;?>" onchange="location.href='index.php?ver=<?php echo $ver?>&buscador=<?php echo $buscador;?>&desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&pagina='+this.value"></li>
	            <?php if ($anterior >= 0){?><li><a href="index.php?ver=<?php echo $ver?>&buscador=<?php echo $buscador;?>&desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&inicio=<?php echo $anterior;?>"><img src="img/trianguloIzq.png" alt="triangulo" /></a></li><?php }?>
	            <li><p class="regular">PÁG. <?php echo $pagina_actual;?> DE <?php echo $cantidad_paginas;?></p></li>
	        </ul>
	    </div>
