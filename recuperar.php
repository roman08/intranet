<?php
session_name('usuario_empleado_servnet');
session_start();
include ("admin/functions/config.php");
include ("admin/functions/conect.php");

if(!isset($_SESSION['usuario_estilos'])){ $_SESSION['usuario_estilos']=Estilos_Colores();}
$_SESSION['empleado_login']=rand(9999,999999);
$token=md5($_SESSION['empleado_recuperar']);
if(isset($_GET['error'])){ $error=Limpiar_Cadena($_GET['error']);} else { $error='';}
?><!doctype html>
<!--[if IE 9]><html class="no-js ie9"><![endif]-->
<!--[if gt IE 9]><!-->
<html lang="es-MX" class="no-js"><!--<![endif]-->
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="robots" content="index, follow">
		<meta name="author" content="Servnet México">
		<meta name="copyright" content="2016">
		<meta name="description" content="">
		<meta name="keywords" content="">

		<title>Intranet <?php echo $_SESSION['intranet_nombre'];?></title>
		<link rel="icon" type="image/x-icon" href="img/favicon.png" />
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300' rel='stylesheet' type='text/css'>

		<!-- CSS -->
		<link rel="stylesheet" href="css/estilos.css">
		<?php echo $_SESSION['usuario_estilos'];?>
		<script src="js/modernizr.custom.js"></script>
	</head>

	<body>
		<header id="headerIndex">
			<div id="tipoCambio"></div>
			<div id="secAzul" class="back_azul header_background">
				<div class="container">
					<h1><a href="index.php"><img src="<?php echo $_SESSION['intranet_logotipo'];?>" alt="<?php echo $_SESSION['intranet_nombre'];?>" /></a>
						<span class="nombreEmpresa"><?php echo $_SESSION['intranet_nombre'];?></span>
					</h1>
				</div>
			</div>
		</header>

<!-- MENU -->
		 <nav id="navPrincipal"></nav>

<!-- comienza contenido -->
		<div class="container">
			<!-- contenedor principal -->
			<section id="login"  class="mTop">

				<!-- olvido contraseña -->
				<form id="loginForm" action="procesa.php" method="post" class="formulario">
					<?php if($error!=''){ echo '<p id="textos" class="t18 azulC">'.$error.'</p>';}?>
					<ul id="listLogin">
						<li>
							<label for="">Email</label>
							<input type="email" class="form" id="correo" name="correo" required>
						</li>
						<li class="liUltimo">
							<input id="enviarContrasena" type="submit" value="Enviar">
							<input type="hidden" id="token" name="token" value="<?php echo $token;?>">
							<input type="hidden" id="ver" name="ver" value="sesion">
							<input type="hidden" id="accion" name="accion" value="recuperar">
						</li>
					</ul>
				</form>
			</section>
		</div>

		<!-- footer -->
		<footer id="footerIndex" class="mTop">
			<div class="container">
				<!-- direccion -->
				<div id="direccion">
					<h3 class="t18 menu_texto"><?php echo $_SESSION['intranet_nombre'];?></h3>
					<p class="light t14"><?php echo $_SESSION['intranet_direccion'];?></p>
					<a href="mailto:<?php echo $_SESSION['intranet_correo'];?>" class="t14"><?php echo $_SESSION['intranet_correo'];?></a><span class="separacion">|</span><p class="light t14 telFooter">Tel. <?php echo $_SESSION['intranet_telefono'];?></p>
				</div>

				<!-- Redes Sociales -->
				<div id="redesSociales">
					<div id="iconos">
						<a href="#"><img src="img/twitter.png" alt="icono twitter" /></a>
						<a href="#"><img class="facebook" src="img/facebook.png" alt="icono facebook" /></a>

					</div>
					<a id="avisoLink" class="light t14" href="index.php?ver=aviso_privacidad">Aviso de Privacidad</a>
				</div>
			</div>
		</footer>


		<!-- SCRIPTS -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

		<script>
			$("#btnOlvido").click(function(){
				$("#contrasenaForm").css('display','block');
				$("#loginForm").css('display','none');
			});

			$("#enviarContrasena").click(function(){
				$("#listLogin").css('display','none');
				$("#textos").css('display','block');
			});

			// $("#btnIngresar").click(function(){
			// 	location.href='index.php';
			// });
		</script>
	</body>
</html>
