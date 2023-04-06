<?php
if (isset($_GET['pagina'])) {
	$pagina = $_GET['pagina'];
} else {
	$pagina = '';
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
					<h3 class="azulMedio">Sugerencias</h3>
				</div>
				<div class="col-xs-12 col-sm-9">
					<button id="pregunta" class="btn btn-lg btnAzmed bco" onclick="location.href='exportar_contacto.php?inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>'"><img class="iconUser" src="img/iexcel.png" alt="exportar Excel">Exportar a Excel</button>
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
							</ul>
						</div>
						<input name="ver" type="hidden" id="ver" value="<?php echo $ver; ?>">
					</form>
				</div>
			</div>

			<div id="tableVisible" class="row">
				<table id="tableContacto" class="table table-striped table-responsive tableGeneral">
					<thead>
						<tr>
							<td colspan="4">Aviso: Para ver los comentarios posicione su cursor en el ícono <a class="link_verA" href="#"><span class="glyphicon glyphicon-eye-open naranja" aria-hidden="true" title=""></span></a></td>
						</tr>
						<tr class="back_azulMedio bco">
							<th>Fecha de Registro</th>
							<th class="thNombre">Nombre</th>
							<th class="thNombre">Email</th>
							<th class="thAcciones">Acciones</th>
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

						
						$consulta = ProcesaQuery("select * from intranet_sugerencias where registro>='" . fecha_aaaammdd($inicial) . "' and registro<='" . fecha_aaaammdd($final) . "' order by registro desc limit $inicio $rxp;");

					
						$total = NumRows(ProcesaQuery("select * from intranet_sugerencias  where registro>='" . fecha_aaaammdd($inicial) . "' and registro<='" . fecha_aaaammdd($final) . "';"));

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



						if (($total > 0) and ($inicial != '') and ($final != '')) {
							while ($row = FetchArray($consulta)) {
						?>
								<tr>
									<td><?php echo fecha_ddmmaaaahhmmss($row['registro']); ?></td>
									<td class="centrarCelda"><?php echo $row['nombre']; ?></td>
									<td class="centrarCelda"><?php echo $row['correo']; ?></td>
									<td><a class="link_ver link_verA" href="#"><span class="glyphicon glyphicon-eye-open naranja" aria-hidden="true" title="<?php echo $row['comentario']; ?>"></span></a>
										<a class="link_ver" href="admin_procesa.php?ver=<?php echo $ver; ?>&accion=Eliminar&id_sugerencia=<?php echo $row['id_sugerencia'] ?>&inicio=<?php echo $inicio; ?>&inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>" title="Eliminar"><span class="glyphicon glyphicon-trash naranja" aria-hidden="true" title="Eliminar"></span></a>
									</td>
								</tr>
							<?php }
						} else { ?>
							<tr>
								<td height="140" colspan="4">No se encontraron Registros</td>
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
							<a href="admin.php?ver=<?php echo $ver ?>&inicio=<?php echo $anterior; ?>&inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>" class="borrar"><img class="triangulo_pag_izq" src="img/previus-page.png" alt="" /></a>
						<?php } ?>

						<input name="pagina" id="pagina" class="form-control" value="<?php echo $pagina_actual; ?>" onchange="location.href='admin.php?ver=<?php echo $ver ?>&pagina='+this.value+'&inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>'">

						<?php if ($siguiente < $total) { ?>
							<a href="admin.php?ver=<?php echo $ver ?>&inicio=<?php echo $siguiente; ?>&inicial=<?php echo $inicial; ?>&final=<?php echo $final; ?>" class="borrar"><img class="triangulo_pag" src="img/next-page.png" alt="" /></a>
						<?php } ?>
					</div>
				</div>
				<div id="output"></div>
			</div>
		</div>
	</article>
</section>