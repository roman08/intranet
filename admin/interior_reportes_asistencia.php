<?php
if (isset($_GET['pagina'])) {
	$pagina = $_GET['pagina'];
} else {
	$pagina = '';
}
if (isset($_GET['empleado'])) {
	$empleado = $_GET['empleado'];
} else {
	$empleado = '';
}
if (isset($_GET['inicial'])) {
	$inicial = $_GET['inicial'];
} else {
	$inicial = date("01/m/Y");
}
if (isset($_GET['final'])) {
	$final = $_GET['final'];
} else {
	$final = date("d", (mktime(0, 0, 0, date("m") + 1, 1, date("Y")) - 1)) . date("/m/Y");
}
?>
<section>
	<article>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-3">
					<h3 class="azulMedio">Reportes Asistencia</h3>
				</div>
			</div>
			<div class="row">
				<div id="formCalendario">
					<form action="admin.php" method="get" enctype="multipart/form-data" id="form_contacto">
						<div class="form-group">
							<ul class="listFormA">
								<li><button class="btn btnConsultar btnAzmed bco" type="submit"><img class="iconUser" src="img/iconsultar.png" alt="consultar">Consultar</button></li>
								<li class="liFecha">
									<label>Fecha Final</label>
									<input class="form-control calendario" readonly="readonly" type="text" name="final" id="final" placeholder="dd/mm/aaaa" value="<?php echo $final; ?>">
								</li>
								<li class="liFecha">
									<label>Fecha Inicial</label>
									<input class="form-control calendario" readonly="readonly" type="text" name="inicial" id="inicial" placeholder="dd/mm/aaaa" value="<?php echo $inicial; ?>">
								</li>
								<li class="liFecha">
									<label>Empleado</label>
									<input class="form-control" type="text" name="empleado" id="empleado" placeholder="" value="<?php echo $empleado; ?>">
								</li>
							</ul>
						</div>
						<input name="ver" type="hidden" id="ver" value="<?php echo $ver; ?>">
					</form>
				</div>
			</div>

			<div id="tableVisible" class="row">
				<table id="tableContacto" class="table table-striped table-responsive tableGeneral">
					<thead>
						<tr class="back_azulMedio bco">
							<th class="thNombre">Ingreso</th>
							<th class="thNombre">Accesos</th>
							<th class="thNombre">Salida</th>
							<th class="thNombre">No Empleado</th>
							<th class="thNombre">Nombre</th>
							<th class="thNombre">Email</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$rxp = 15;
						if (($pagina != '') and ($pagina > '0')) {						
							$inicio = ($pagina * $rxp) - $rxp;
						}
						if ($inicio == '0' or $inicio == '') {
							$pagina_actual = '1';
						} else {
							$pagina_actual = ($inicio / $rxp) + 1;
						}

						$total = 1;

						if (round($total / $rxp) == '0') {
							$cantidad_paginas = 1;
						} else {
							$cantidad_paginas = round($total / $rxp);
						}

						if ($inicio != '') {
							$siguiente = $inicio + $rxp;
							$anterior = $inicio - $rxp;
						} else {
							$inicio = 0;
							$anterior = -$rxp;
							$siguiente = $rxp;
						}


						$bus = '';
						if ($empleado != '') {
							$bus = "and CONCAT(B.nombre, ' ', B.apellidop, ' ', B.apellidom) LIKE '%$empleado%'";
						}
						$consulta = ProcesaQuery("
	  SELECT Y.ingreso, Y.accesos, Z.salida, CONCAT(B.nombre, ' ', B.apellidop, ' ', B.apellidom) as nombre, B.nroempleado, B.correo FROM (select DATE(A.registro) as registro, A.id_empleado  
	  from intranet_empleados_log A 
	  where DATE(A.registro)>='" . fecha_aaaammdd($inicial) . "' and DATE(A.registro)<='" . fecha_aaaammdd($final) . "' $bus 
	  GROUP BY DATE(A.registro) and A.id_empleado
	  order by A.registro desc 
	  limit $inicio, $rxp) X 
	  JOIN intranet_empleados B ON X.id_empleado=B.id_empleado 
	  LEFT JOIN ( SELECT A.id_empleado, DATE(A.registro) as registro, COUNT(A.registro) as accesos, MIN(A.registro) as ingreso FROM intranet_empleados_log A  where A.tipo='1' and DATE(A.registro)>='" . fecha_aaaammdd($inicial) . "' and DATE(A.registro)<='" . fecha_aaaammdd($final) . "' GROUP BY DATE(A.registro) and A.id_empleado ) Y ON X.id_empleado=Y.id_empleado and X.registro=Y.registro 
	  LEFT JOIN ( SELECT A.id_empleado, DATE(A.registro) as registro, COUNT(A.registro) as salidas, MAX(A.registro) as salida FROM intranet_empleados_log A  where A.tipo='0' and DATE(A.registro)>='" . fecha_aaaammdd($inicial) . "' and DATE(A.registro)<='" . fecha_aaaammdd($final) . "' GROUP BY DATE(A.registro) and A.id_empleado ) Z ON X.id_empleado=Z.id_empleado and X.registro=Z.registro 
	  ;");

						$total = NumRows(ProcesaQuery("select DATE(A.registro) as registro, A.id_empleado  
	  FROM intranet_empleados_log A 
	  where DATE(A.registro)>='" . fecha_aaaammdd($inicial) . "' and DATE(A.registro)<='" . fecha_aaaammdd($final) . "' $bus 
	  GROUP BY DATE(A.registro) and A.id_empleado;"));
						if (($total > 0) and ($inicial != '') and ($final != '')) {
							while ($row = FetchArray($consulta)) {
						?>
								<tr>
									<td><?php echo fecha_ddmmaaaahhmmss($row['ingreso']); ?></td>
									<td class="centrarCelda"><?php echo $row['accesos']; ?></td>
									<td><?php echo fecha_ddmmaaaahhmmss($row['salida']); ?></td>
									<td class="centrarCelda"><?php echo $row['nroempleado']; ?></td>
									<td class="centrarCelda"><?php echo $row['nombre']; ?></td>
									<td class="centrarCelda"><?php echo $row['correo']; ?></td>
								</tr>
							<?php }
						} else { ?>
							<tr>
								<td height="140" colspan="6">No se encontraron Registros</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="paginas bottomp">
					<div class="paginas-number">
						<span class="conteo_paginas">Pag <?php echo $pagina_actual; ?> de <?php echo $cantidad_paginas; ?></span>
						<?php if ($anterior >= 0) { ?>
							<a href="admin.php?ver=<?php echo $ver ?>&inicio=<?php echo $anterior; ?>&inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>&empleado=<?php echo $empleado; ?>" class="borrar"><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>
						<?php } ?>

						<input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual; ?>" onchange="location.href='admin.php?ver=<?php echo $ver ?>&pagina='+this.value+'&inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>&empleado=<?php echo $empleado; ?>'">

						<?php if ($siguiente < $total) { ?>
							<a href="admin.php?ver=<?php echo $ver ?>&inicio=<?php echo $siguiente; ?>&inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>&empleado=<?php echo $empleado; ?>" class="borrar"><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
						<?php } ?>
					</div>
				</div>
				<div id="output"></div>
			</div>
		</div>
	</article>
</section>