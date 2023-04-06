<!-- direccion -->
	<article id="organigrama">
		<h3 class="TitBloque">Organigrama</h3>
		<div class="contInfo">
			<div class="main">
				<ul id="cbp-ntaccordion" class="cbp-ntaccordion">
					<?php
						$query="SELECT A.*, CONCAT(B.nombre, ' ' ,B.apellidop, ' ' ,B.apellidom) as persona, B.imagen as foto, B.archivo
						FROM intranet_organigrama A
						LEFT JOIN intranet_empleados B ON A.id_seccion=B.id_seccion and B.activo='1' and B.eliminado='0'
						WHERE A.padre='0'
						ORDER by A.orden";
						$consulta=ProcesaQuery($query);
						while ($row=FetchArray($consulta)){?>
					<!-- segundo bloque -->
					<li>
						<h3 class="cbp-nttrigger"><?php echo $row['nombre'];?></h3>
						<div class="cbp-ntcontent">
							<div class="Puesto">
								<div class="txtPuesto">
									<div class="fotoPuesto">
										<figure>
											<img class="fotoOrganigrama" src="<?php if($row['foto']!='' and file_exists('empleados/'.$row['foto'])){ echo 'empleados/'.$row['foto'];} else { echo 'img/personal/NoFoto.jpg';}?>" alt="<?php echo $row['persona'];?>">
										</figure>
										<p class="t16 negro"><?php echo $row['persona'];?></p>
									</div>
									<p class="descPuesto"><?php echo $row['descripcion'];?></p>
								</div>
							</div>
							<?php if($row['archivo']!='' and file_exists('empleados/'.$row['archivo'])){ ?>
								<a href="empleados/<?php echo $row['archivo'];?>" class="linkRojo" target="_blank">Más información</a>
							<?php }?>
								<?php
								$query1="select A.*
								from intranet_organigrama A
								where A.padre='".$row['id_seccion']."'
								order by A.orden";
								$con=ProcesaQuery($query1);
								if(NumRows($con)>0){
								?>

							<!-- fotos varias -->
							<ul class="cbp-ntsubaccordion">
								<?php while ($r=FetchArray($con)){?>
								<li>
									<h4 class="cbp-nttrigger"><?php echo $r['nombre'];?></h4>
									<div class="cbp-ntcontent cbp-ntcontentA">
										<ul class="cbp-Lista">
											<?php
											$query2="select CONCAT(A.nombre, ' ' ,A.apellidop, ' ' ,A.apellidom) as persona, A.imagen as foto, A.archivo, A.puesto
											from intranet_empleados A
											WHERE A.id_seccion='".$r['id_seccion']."'
											order by persona";
											$con1=ProcesaQuery($query2);
											while ($row1=FetchArray($con1)){
											?>
											<li>
												<figure>
													<img class="fotoOrganigrama" src="<?php if($row1['foto']!='' and file_exists('empleados/'.$row1['foto'])){ echo 'empleados/'.$row1['foto'];} else { echo 'img/personal/NoFoto.jpg';}?>" alt="<?php echo $row1['persona'];?>">
												</figure>
												<p class="t14 negro bold"><?php echo $row1['persona'];?></p>
												<small><?php echo $row1['puesto'];?></small>
												<?php if($row1['archivo']!='' and file_exists('empleados/'.$row1['archivo'])){ ?>
													<a href="empleados/<?php echo $row1['archivo'];?>" class="linkRojo" target="_blank">Más información</a>
												<?php }?>
											</li>
										 <?php }?>
										</ul>

									</div>
								</li>
							<?php }?>
							</ul>
						<?php } ?>
						</div>
					</li>
				<?php }?>
				</ul>
			</div>
		</div>
	</article>
