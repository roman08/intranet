<!-- direccion -->
	<article id="casosExitoA">
		<h3 class="TitBloque">CASOS DE ÉXITO</h3>
		<div class="contenidoCh">

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

			$consulta=ProcesaQuery("select * from intranet_casos_exito order by orden limit $inicio, $rxp;");
			$total=NumRows(ProcesaQuery("select id_caso from intranet_casos_exito;"));
			if($inicio=='0'){ $pagina_actual='1';}else{ $pagina_actual=($inicio/$rxp)+1;}
			if (round($total/$rxp)=='0'){$cantidad_paginas=1;}else{$cantidad_paginas=round($total/$rxp);}
			if ($total>0) {
			$contador=0;
			while ($row=FetchArray($consulta)) {
			$contador++;  ?>

			<div class="contCasos">
				<div class="logotipos">
					<?php if($row['imagen']!='' and file_exists('casos_exito/'.$row['imagen'])) { ?>
					<figure>
						<img src="<?php echo 'casos_exito/'.$row['imagen'];?>" alt="<?php echo $row['titulo'];?>">
					</figure>
					<?php }?>
				</div>
				<div class="txt">
					<h4 class="t24 azulC light"><?php echo $row['titulo'];?></h4>
					<p><?php echo nl2br($row['texto1']);?></p>
					<!--<p class="usuario"><span class="bold">Ing. Jesus Camacho</span>
					<small class="t14">Director General</small></p>-->
				</div>
			</div>

		<?php } } else {?>
			<h3>No hay registros </h3>
		<?php }?>

		</div>
	</article>

<!-- paginador -->
	<div class="extUp extUpsM">
        <ul class="paginador paginadorInf">
					<?php if ($siguiente < $total) {?><li><a href="index.php?ver=<?php echo $ver?>&inicio=<?php echo $siguiente;?>"><img src="img/trianguloDer.png" alt="triangulo" /></a></li><?php }?>
					<li><input type="text" class="numPag" name="pagina" id="pagina" value="<?php echo $pagina_actual;?>" onchange="location.href='index.php?ver=<?php echo $ver?>&pagina='+this.value"></li>
					<?php if ($anterior >= 0){?><li><a href="index.php?ver=<?php echo $ver?>&inicio=<?php echo $anterior;?>"><img src="img/trianguloIzq.png" alt="triangulo" /></a></li><?php }?>
					<li><p class="regular">PÁG. <?php echo $pagina_actual;?> DE <?php echo $cantidad_paginas;?></p></li>
        </ul>
    </div>
