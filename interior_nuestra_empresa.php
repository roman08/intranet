<!-- nuestra_empresa -->
<?php
$row=FetchArray(ProcesaQuery("select * from intranet_mision_vision where id='1';"));
?>
	<article id="mision">
		<h3 class="TitBloque">Nuestra Empresa</h3>
		<div class="contInfo">
			<div class="intInfo">
				<?php if($row['imagen1']!='' and file_exists('img/'.$row['imagen1'])) { ?>
				<figure class="fotoinfo">
					<img src="<?php echo 'img/'.$row['imagen1'];?>" alt="Misión">
				</figure>
				<?php }?>
				<div class="txtInfo">
					<h2 class="light">Misión</h2>
					<?php echo $row['texto1'];?>
				</div>
			</div>
			<!-- vision -->
			<div class="intInfo">
				<?php if($row['imagen2']!='' and file_exists('img/'.$row['imagen2'])) { ?>
				<figure class="fotoinfo">
					<img src="<?php echo 'img/'.$row['imagen2'];?>" alt="Visión">
				</figure>
				<?php }?>
				<div class="txtInfo">
					<h2 class="light">Visión</h2>
					<?php echo $row['texto2'];?>
				</div>
			</div>
			<!-- valores -->
			<div class="intInfo">
				<?php if($row['imagen3']!='' and file_exists('img/'.$row['imagen3'])) { ?>
				<figure class="fotoinfo">
					<img src="<?php echo 'img/'.$row['imagen3'];?>" alt="Valores">
				</figure>
				<?php }?>
				<div class="txtInfo">
					<h2 class="light">Valores</h2>
					<?php echo $row['texto3'];?>
					</p>
				</div>
			</div>
		</div>
	</article>

	<?php
	$row=FetchArray(ProcesaQuery("select * from intranet_mensaje_direccion where id='1';"));
	?>
<!-- mensaje direccion -->
	<article id="msnDireccion" class="interioresVarios mTop">
		<h3 class="TitBloque">Mensaje de la Dirección</h3>
		<div class="contInfo">
			<div class="seccionInt">
				<div class="contIzq contCh">
					<h4 class="t24 azulC light"><?php echo nl2br($row['texto']);?></h4>
				</div>
				<div class="contDer contCh">
					<?php if($row['imagen']!='' and file_exists('img/'.$row['imagen'])) { ?>
					<figure>
						<img src="img/<?php echo $row['imagen'];?>" alt="<?php echo $row['titulo']?>" />
						<!-- tamaño de foto 250px alto -->
					</figure>
					<?php } ?>
				</div>

				<?php echo $row['mensaje'];?>
			</div>
		</div>
	</article>
