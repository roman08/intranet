<!-- banner -->
	<article id="banner">
		<ul class="bxsliderHome">
				<?php
					$query="select * from intranet_banners order by orden";
					$consulta=ProcesaQuery($query);
					while ($row=FetchArray($consulta)){
						if($row['imagen']!='' and file_exists('banners/'.$row['imagen'])) { ?>
		    <li><a href="<?php if($row['liga']!=''){ echo $row['liga'];} else { echo '#';}?>">
		    		<img src="<?php echo 'banners/'.$row['imagen'];?>">
		    	</a>
		    </li>
			<?php } }?>
		</ul>
	</article>

	<article id="bannerResp">
		<ul class="bxsliderHome">
				<?php
					$query="select * from intranet_banners order by orden";
					$consulta=ProcesaQuery($query);
					while ($row=FetchArray($consulta)){
						if($row['imagen1']!='' and file_exists('banners/'.$row['imagen1'])) { ?>
		    <li><a href="<?php if($row['liga']!=''){ echo $row['liga'];} else { echo '#';}?>">
		    		<img src="<?php echo 'banners/'.$row['imagen1'];?>">
		    	</a>
		    </li>
			<?php } }?>
		</ul>
	</article>

<!-- noticias -->
	<article id="noticias" class="mTop">
		<h3 class="TitBloque"><span class="txt">Noticias</span><a href="index.php?ver=noticias">Ver todas las noticias</a></h3>
		<div class="contNoticias">
			<?php
				$query="select id_noticia, registro, titulo, texto1, imagen from intranet_noticias order by registro limit 3;";
				$consulta=ProcesaQuery($query);
				while ($row=FetchArray($consulta)){ ?>
			<div class="noticia">
				<?php if($row['imagen']!='' and file_exists('noticias/'.$row['imagen'])) { ?>
					<figure class="contFotoNot">
					<img src="<?php echo 'noticias/'.$row['imagen'];?>" alt="<?php echo $row['titulo'];?>">
				</figure><?php } ?>
				<div class="txtFotoNot">
					<h2 class="light t24"><?php echo $row['titulo'];?></h2>
					<time class="t14" datetime="<?php echo fecha_ddmmaaaa($row['registro']);?>" pubdate><?php echo fecha_ddmmaaaa($row['registro']);?></time>
					<p><?php echo Abrebiar($row['texto1'], 90);?></p>
				</div>
				<a class="link" href="index.php?ver=noticias_detalle&id=<?php echo $row['id_noticia'];?>">Ver noticia</a>
			</div>
			<?php } ?>
		</div>
	</article>

<!-- segundoBloque home -->
	<article id="segundoBloque" class="mTop">
		<!-- mensaje direccion -->
		<?php
			$query="select * from intranet_mensaje_direccion where id='1';";
			$consulta=ProcesaQuery($query);
			$row=FetchArray($consulta); ?>
		<div id="colUno" class="columna">
			<h3 class="TitBloque">MENSAJE DE LA DIRECCIÓN</h3>
			<?php if($row['imagen']!='' and file_exists('img/'.$row['imagen'])) { ?>
			<figure class="contFoto">
				<img src="img/<?php echo $row['imagen'];?>" alt="<?php echo $row['titulo']?>" />
			</figure>
			<?php } ?>
			<div class="contenido">
				<h2 class="light"><?php echo $row['titulo']?></h2>
				<p><?php echo Abrebiar($row['texto'], 120);?></p>
				<a class="link" href="index.php?ver=nuestra_empresa#msnDireccion">Ver mensaje completo</a>
			</div>
		</div>

		<!-- documentos -->
		<div id="colDos" class="columna">
			<div id="documentos">
				<h3 class="TitBloque">DOCUMENTOS</h3>
				<div class="contenido">
					<?php
						$query="select A.id_documento, A.archivo_ext, B.icono, A.archivo_nombre
						, ROUND(time_to_sec((TIMEDIFF(NOW(), A.registro))) / 60) as diferencia_min
						, ROUND(time_to_sec((TIMEDIFF(NOW(), A.registro))) / 60 /60) as diferencia_hs
						, DATEDIFF(NOW(), A.registro) as diferencia_dia
						from intranet_documentos A
						JOIN intranet_documentos_iconos B ON A.formato=B.formato 
						JOIN intranet_documentos_secciones C ON C.id_documento=A.id_documento
						WHERE A.activo='1' and C.id_seccion='".$_SESSION['usuario_seccion']."'
						order by A.registro desc limit 3";
						$consulta=ProcesaQuery($query);
						while ($row=FetchArray($consulta)){
							if($row['archivo_ext']!='') {
							$unidad='dia'; $mostrar=$row['diferencia_dia'];
							if($row['diferencia_dia']==0) { if($row['diferencia_min']<60){ $unidad='min'; $mostrar=$row['diferencia_min']; } else { $unidad='hs'; $mostrar=$row['diferencia_hs'];} }	?>
					<div class="enlace">
						<a class="enlaceDoc" href="procesa.php?ver=sesion&accion=descargar&id=<?php echo $row['id_documento']?>" download>
							<img src="img/iconosDoc/<?php echo $row['icono'];?>" alt="">
							<p class="txt"><?php echo $row['archivo_nombre'];?></p>
						</a>
						<span class="horario t14">(<?php echo $mostrar;?> <?php echo $unidad;?>)</span>
					</div>
					<?php } }?>

					<a class="link" href="index.php?ver=documentos">Ver todos los documentos</a>
				</div>
			</div>

			<!-- empleado del mes -->
			<?php $row=FetchArray(ProcesaQuery("select A.*, B.nombre as laseccion from intranet_empleados A
			JOIN intranet_organigrama B ON A.id_seccion=B.id_seccion
			where A.empleado='1' and A.activo='1' limit 1;"));?>
			<div id="empleadoMes">
				<?php if($row['imagen']!='' and file_exists('empleados/'.$row['imagen'])) { ?>
				<figure class="contFoto">
					<img src="<?php echo 'empleados/'.$row['imagen'];?>" alt="<?php echo $row['nombre'].' '.$row['apellidop'].' '.$row['apellidom'];?>" />
				</figure>
			<?php }?>
				<div class="txFoto">
					<img src="img/medalla.png" alt="medalla" />
					<h3>EMPLEADO DEL MES</h3>
					<p><?php echo $row['nombre'].' '.$row['apellidop'].' '.$row['apellidom'];?></p>
					<p class="gris"><?php echo $row['laseccion'];?></p>
				</div>
			</div>
		</div>
	</article>

<!-- proximos eventos -->
	<article id="proxEventos" class="mTop">
		<h3 class="TitBloque"><span class="txt">Próximas Actividades</span><a href="index.php?ver=calendario">Ver todos las actividades del año</a></h3>
		<ul>
			<?php
			$query="select A.id_calendario, DATE_FORMAT(A.fecha , '%d-%m-%Y') as fecha, A.actividad
			from intranet_calendario A
			where CURDATE()<=A.fecha and A.activo='1'
			ORDER by A.fecha asc limit 4;";
			$consulta=ProcesaQuery($query);
			while ($row=FetchArray($consulta)){
			?>
			<li>
				<figure>
					<img src="img/iconos/iReloj.png" alt="icono reloj">
					<figcaption><?php echo $row['fecha'];?></figcaption>
				</figure>
				<p><?php echo $row['actividad'];?></p>
			</li>
			<?php
			}
			?>
		</ul>
	</article>
