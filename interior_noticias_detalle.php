<!-- noticias detalle -->
	<?php
		$row=FetchArray(ProcesaQuery("SELECT * FROM intranet_noticias where id_noticia='$id';"));
	?>
	<article id="noticiasDetalle" class="interioresVarios mTop">
		<h3 class="TitBloque"><span class="txt">Noticias</span><a class="regresar" href="javascript:window.history.back();">Regresar</a></h3>
		<div class="contInfo">
			<div class="seccionInt">
				<div class="contIzq contCh">
					<h4 class="t24 azulC light"><?php echo $row['titulo'];?></h4>
					<time class="t14" datetime="<?php echo fecha_ddmmaaaa($row['registro']);?>" pubdate><?php echo fecha_ddmmaaaa($row['registro']);?></time>
				</div>
				<div class="contDer contCh">
					<?php if($row['imagen']!='' and file_exists('noticias/'.$row['imagen'])) { ?><figure>
						<img src="<?php echo 'noticias/'.$row['imagen'];?>" alt="<?php echo $row['titulo'];?>">
					</figure><?php }?>
				</div>
				<?php echo $row['texto2'];?>
			</div>
		</div>
	</article>

<!-- mas noticias -->
	<article id="noticiasA">
		<h3 class="TitBloque">Más Noticias</h3>
		<div class="contNoticias">
			<?php
				$query="select id_noticia, registro, titulo, texto1, imagen from intranet_noticias where id_noticia<>'$id' order by registro limit 3;";
				$consulta=ProcesaQuery($query);
				while ($row=FetchArray($consulta)){ ?>
			<div class="noticia">
				<?php if($row['imagen']!='' and file_exists('noticias/'.$row['imagen'])) { ?>
				<figure class="contFotoNot">
					<img src="<?php echo 'noticias/'.$row['imagen'];?>" alt="<?php echo $row['titulo'];?>">
				</figure>
				<?php } ?>
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
