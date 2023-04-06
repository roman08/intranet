<!-- direccion -->
	<article id="calendarioA" class="back_ back_a">
		<h3 class="TitBloque">CALENDARIO <?php echo date("Y");?></h3>
		<div class="contenidoCh">
			<ul class="contCalendario">
			<?php
			$meses=array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
			$dias=array("DOMINGO", "LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO");
			$query="select A.id_calendario, A.ubicacion, A.horario, A.descripcion,
			DATE_FORMAT(A.fecha , '%d.%m.%Y') as fecha,
			MONTH(A.fecha) as mes,
			DATE_FORMAT(A.fecha , '%w') as dia,
			A.actividad
			from intranet_calendario A
			where A.activo='1' and YEAR(A.fecha)='".date("Y")."'
			ORDER by A.fecha asc;";
			$consulta=ProcesaQuery($query);
			$contador=0;
			$aux='';
			while ($row=FetchArray($consulta)){ $contador++;
			?>
			<!-- SIGUIENTE MES -->


				<?php if($aux!=$row['mes']){ if($contador>1){ echo '</ul><ul class="contCalendario">';}?>

				<li class="Mes bold"><p><?php echo $meses[$row['mes']];?></p></li>
			<?php } $aux=$row['mes'];?>

				<li class="datosCalendarioA">
					<p class="cal_Dia bold"><?php echo $dias[$row['dia']];?><br><span class="fecha regular"><?php echo $row['fecha'];?></span></p>
					<p class="cal_Hora bold"> <?php echo $row['horario'];?></p>
					<p class="cal_Evento">
						<span class="bold">Evento: </span><?php echo $row['actividad'];?>
						<br>
						<span class="txtCh"><?php echo $row['ubicacion'];?> - <?php echo nl2br($row['descripcion']);?></span>
					</p>
				</li>


		  <?php } ?>
			</ul>
		</div>
	</article>
