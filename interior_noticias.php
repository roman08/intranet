<!-- noticias -->
	<article id="noticiasVarios" class="mTop">
		<h3 class="TitBloque">Noticias</h3>

		<div class="contNoticias">
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

			$consulta=ProcesaQuery("select id_noticia, titulo, imagen, registro, texto1 from intranet_noticias order by registro desc limit $inicio, $rxp;");
			$total=NumRows(ProcesaQuery("select id_noticia from intranet_noticias;"));
			if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
			if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
			if ($total>0) {
			$contador=0;
			while ($row=FetchArray($consulta)) {
			$contador++; if($contador=='4'){ echo '</div><div class="contNoticias">';} ?>
			<div class="noticia">
				<?php if($row['imagen']!='' and file_exists('noticias/'.$row['imagen'])) { ?>
				<figure class="contFotoNot">
					<img src="<?php echo 'noticias/'.$row['imagen'];?>" alt="">
				</figure>
				<?php }?>
				<div class="txtFotoNot">
					<h2 class="light t24"><?php echo $row['titulo'];?></h2>
					<time class="t14" datetime="<?php echo fecha_ddmmaaaa($row['registro']);?>" pubdate><?php echo fecha_ddmmaaaa($row['registro']);?></time>
					<p><?php echo Abrebiar($row['texto1'], 90);?></p>
				</div>
				<a class="link" href="index.php?ver=noticias_detalle&id=<?php echo $row['id_noticia'];?>">Ver noticia</a>
			</div>
		<?php } } else {?>
			<h3>No hay noticias registradas </h3>
		<?php }?>
		</div>

	</article>

<!-- paginador -->
	<div class="extUp">
        <ul class="paginador paginadorInf">
            <?php if ($siguiente < $total) {?><li><a href="index.php?ver=<?php echo $ver?>&inicio=<?php echo $siguiente;?>"><img src="img/trianguloDer.png" alt="triangulo" /></a></li><?php }?>
            <li><input type="text" class="numPag" name="pagina" id="pagina" value="<?php echo $pagina_actual;?>" onchange="location.href='index.php?ver=<?php echo $ver?>&pagina='+this.value"></li>
            <?php if ($anterior >= 0){?><li><a href="index.php?ver=<?php echo $ver?>&inicio=<?php echo $anterior;?>"><img src="img/trianguloIzq.png" alt="triangulo" /></a></li><?php }?>
            <li><p class="regular">PÁG. <?php echo $pagina_actual;?> DE <?php echo $cantidad_paginas;?></p></li>
        </ul>
    </div>
