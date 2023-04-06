<?php /* ------------------------------------------------

Código de Servnet México S.A. de C.V.

---------------------------------------------------*/
session_name('usuario_empleado_servnet');

session_start();

include("admin/functions/config.php");

include("admin/functions/conect.php");



if (!isset($_SESSION['usuario_estilos'])) {
	$_SESSION['usuario_estilos'] = Estilos_Colores();
}

$_SESSION['empleado_login'] = rand(9999, 999999);

$token = md5($_SESSION['empleado_login']);

if (isset($_GET['error'])) {
	$error = Limpiar_Cadena($_GET['error']);
} else {
	$error = '';
}



// No almacenar en el cache del navegador esta página.

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Expira en fecha pasada

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Siempre página modificada

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

header("Pragma: no-cache"); // HTTP/1.0

?>

<!DOCTYPE html>

<html lang="es-MX">

<head>

	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />

	<title>Administrador Intranet Do It Roght</title>

	<link rel="stylesheet" type="text/css" href="admin/css/bootstrap.css" />

	<link rel="stylesheet" type="text/css" href="admin/css/estilos_gral.css" />

</head>

<body class="inicio">

	<header id="headerHome">

		<div class="container">

			<div class="col-xs-12 col-sm-6 contLogo">

				<img class="logotipo" src="admin/img/logotipo_doitright.png" alt="logotipo-pulsoInmobiliario">

			</div>

			<div id="acceso" class="contRecuadro col-xs-12 col-sm-6">


				<h3 class="naranja"><strong>Bienvenid@</strong></h3>
				<p>Al administrador de www.intranetdoitright.com</p>

				<form id="loginForm" action="procesa.php" method="post" class="login">

					<div class="form-group">

						<ul class="listForm">

							<?php // Mostrar error de Autentificación.

							include("admin/functions/gestion_errores.php");

							if ($error != '') {


								echo '<li style="color:#CC2828;">Error: ' . $error . '</li>';
							}

							?>

							<li>

								<label>*Usuario</label>

								<input name="usuario" type="text" class="form-control" id="usuario" maxlength="100" placeholder="Usuario" required autofocus>

							</li>

							<li>

								<label>*Contraseña</label>

								<input name="contrasena" type="password" class="form-control" id="contrasena" maxlength="15" placeholder="Contraseña" required autofocus>

							</li>

							<li class="ultimoLi">

								<span class="requeridos">*Datos Requeridos</span>

								<button id="btnIngresar" class="btn btn-lg back_naranja negro" type="submit">Ingresar</button>



								<!-- <a id="btnOlvido" class="t14" href="#">¿Olvidaste tu contraseña?</a> -->

								<!-- <input id="btnIngresar" type="submit" value="Ingresar"> -->

								<input type="hidden" id="token" name="token" value="<?php echo $token; ?>">

								<input type="hidden" id="ver" name="ver" value="sesion">

								<input type="hidden" id="accion" name="accion" value="login">


							</li>

						</ul>

					</div>

				</form>

			</div>

		</div>

	</header>