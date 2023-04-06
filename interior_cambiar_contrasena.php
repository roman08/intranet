<?php
if(isset($_GET['mensaje'])){ $mensaje=Limpiar_Cadena($_GET['mensaje']);} else { $mensaje='';}
?><!-- cambiar contraseña -->
	<article id="cambiar">
		<h3 class="TitBloque">CAMBIAR CONTRASEÑA</h3>
		<div class="contenidoCh">
			<form action="procesa.php" method="post" class="formulario">
				<ul>
					<?php if($mensaje!=''){ echo '<li><h3 style="color:#CC2828;">'.$mensaje.'</h3></li>';}?>
					<li>
						<label for="">Contraseña actual</label>
						<input type="password" name="contrasena1" id="contrasena1" class="form" required>
					</li>
					<li>
						<label for="">Nueva Contraseña</label>
						<input type="password" name="contrasena2" id="contrasena2" class="form" required>
					</li>
					<li>
						<label for="">Confirmar Contraseña</label>
						<input type="password" name="contrasena3" id="contrasena3" class="form" required>
					</li>
					<li class="liUltimo"><input type="submit" value="Enviar"></li>
					<?php
					$_SESSION['empleado_contrasena']=rand(9999,999999);
					$token=md5($_SESSION['empleado_contrasena']);?>
				</ul>
				<input type="hidden" id="token" name="token" value="<?php echo $token;?>">
				<input type="hidden" id="ver" name="ver" value="sesion">
				<input type="hidden" id="accion" name="accion" value="cambiar">
			</form>
		</div>
	</article>
