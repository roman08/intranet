<?php

/* ------------------------------------------------

Código de Servnet México S.A. de C.V.

---------------------------------------------------*/

include ("functions/config.php");

include ("functions/conect.php");

require("verificar_usuario.php");

$nivel_acceso=4; // Nivel de acceso para esta página.

if ($nivel_acceso <= $_SESSION['usuario_nivel']){

header ("Location: $redir?error_login=5&x=1");

exit;

}





if (isset($_GET['ver'])){ $ver=$_GET['ver'];} else {$ver='';}

if (isset($_GET['opcion'])){ $opcion=$_GET['opcion'];} else {$opcion='';}

if (isset($_GET['inicio'])){ $inicio=$_GET['inicio'];} else {$inicio='';}

if (isset($_GET['id_usuario'])){ $id_usuario=$_GET['id_usuario'];} else {$id_usuario='';}

if (isset($_GET['id'])){ $id=$_GET['id'];} else {$id='';}

if(isset($_GET['pagina'])){ $pagina=$_GET['pagina']; }else{ $pagina='';}

?><!DOCTYPE html>

<html lang="es-MX">

<head>

	<meta charset="UTF-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />

	<title>Administrador Intranet Do It Right</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

	<link rel="stylesheet" type="text/css" href="css/estilos_gral.css" />

	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />

</head>

<body>

	<header id="headerProv">

		<div class="container">

			<div class="row">

				
    <div class="col-xs-6"> <a href="https://doitright.solutions/" target="_blank"><img class="logotipo" src="img/logotipo_doitright_h.png" alt="logotipo doitright"></a></div>

				<div class="col-xs-6 bco">

					<div class="pTxt"><p class="headerTxt">Panel Administración</p><span class="separacion">|</span><a class="link bco linkA" href="http://www.intranet.doitright.solutions" target="_blank">www.intranetdoitright.com</a></div>

					<h4>Bienvenido: <?php echo $_SESSION['usuario_nombre'];?><span class="separacion">|</span><a class="link bco" href="admin.php?ver=cambio_contrasena">Cambiar Contraseña</a></h4>

                </div>

					<div class="pTxt"><a class="link linkA linkB" href="logout.php">Cerrar Sesión</a></div>

			</div>

         </div>

	</header>

<div id="navProv" class="row back_naranja">

	<div class="container">

		<nav class="navbar navbar-default col-xs-12" >

			<!-- <div class="container-fluid"> -->

				<div class="navbar-header">

					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#pMenu">

						<span class="sr-only"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

					</button>

				</div>

                <?php

					if (!isset($_SESSION['menu'])){

					$consulta=ProcesaQuery("SELECT GROUP_CONCAT(a.ver) FROM  intranet_usuarios_seccion b JOIN intranet_secciones a ON a.id_seccion=b.id_seccion where id_usuario='$_SESSION[usuario_id]' group by a.menu");



					$aux = FetchArray($consulta);

					$_SESSION['menu']=explode(",",$aux[0]);

					}

					$menu=$_SESSION['menu'];

				?>

				<div id="pMenu" class="collapse navbar-collapse navbar-right">

					<ul class="nav navbar-nav">

                    	<li class="dropdown">

                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Principal<span class="caret"></span></a>

                        	<ul class="dropdown-menu">

					            <?php if (in_array('principal_datos_generales',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_datos_generales">Datos Generales</a></li><?php }?>

                                <?php if (in_array('principal_banners_home',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_banners_home">Banners Home</a></li><?php }?>

                                <?php if (in_array('principal_header_menu_footer',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_header_menu_footer">Header, menú y footer</a></li><?php }?>

                                <?php if (in_array('principal_mensaje_direccion',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_mensaje_direccion">Mensaje de la Dirección</a></li><?php }?>

                                <?php if (in_array('principal_redes_sociales',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_redes_sociales">Redes Sociales</a></li><?php }?>

                                <?php if (in_array('principal_cortinilla',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_cortinilla">Cortinilla</a></li><?php }?>

                                <?php if (in_array('principal_aviso_privacidad',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_aviso_privacidad">Aviso de privacidad</a></li><?php }?>

                                <?php if (in_array('principal_accesos_directos',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_accesos_directos">Accesos directos</a></li><?php }?>

                                <?php if (in_array('principal_mision_vision',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_mision_vision">Misión, Visión y Valores</a></li><?php }?>

								<?php if (in_array('principal_divisas',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=principal_divisas">Divisas</a></li><?php }?>

					        </ul>

                        </li>

						<?php if (in_array('usuarios',$menu) ) {?><li><a class="MenuSec" href="admin.php?ver=usuarios">Usuarios</a></li><?php }?>

						<?php if (in_array('noticias',$menu)) {?><li><a class="MenuSec" href="admin.php?ver=noticias">Noticias</a></li><?php }?>

						<?php if (in_array('articulos',$menu)) {?><li><a class="MenuSec" href="admin.php?ver=articulos">Articulos</a></li><?php }?>

						<?php if (in_array('organigrama',$menu)) {?><li><a class="MenuSec" href="admin.php?ver=organigrama">Organigrama</a></li><?php }?>

						<?php if (in_array('empleados',$menu)) {?><li><a class="MenuSec" href="admin.php?ver=empleados">Empleados</a></li><?php }?>

						<?php if (in_array('documentos',$menu)) {?><li><a class="MenuSec" href="admin.php?ver=documentos">Documentos</a></li><?php }?>

						<?php if (in_array('calendario',$menu)) {?><li><a class="MenuSec" href="admin.php?ver=calendario">Calendario</a></li><?php }?>

						<?php if (in_array('casos_exito',$menu)) {?><li><a class="MenuSec" href="admin.php?ver=casos_exito">Casos de éxito</a></li><?php }?>

						<?php if (in_array('sugerencias',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=sugerencias">Sugerencias</a></li><?php }?>

						

						<li class="dropdown">

                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes<span class="caret"></span></a>

                        	<ul class="dropdown-menu">

					            <?php if (in_array('reportes_asistencia',$menu)) {?><li><a class="MenuSec MenuSecUlt" href="admin.php?ver=reportes_asistencia">Asistencia</a></li><?php }?>

					        </ul>

                        </li>

					</ul>

				</div>

			<!-- </div> -->

		</nav>

	</div>

</div>



<?php

if(file_exists('interior_'.$ver.'.php') and ($ver!='') and in_array($ver,$menu) ){

	include('interior_'.$ver.'.php');

}

?>



<!-- footer -->

	<footer id="footerHome">

		<div class="container">

				<div class="col-xs-12 col-sm-6 contFooter">

					<p class="txtCh bco2">© 2023 www.intranet.doitright.solutions/

					Powered by Doitright</p>

				</div>

				<div id="design" class="col-xs-12 col-sm-6 contFooter">

					<a href="https://doitright.solutions/" target="_blank"><img src="img/logotipo_doitright-footer.png" alt="Doitright"></a>

				</div>

		</div>

	</footer>





    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script type="text/javascript" src="js/jquery-ui.js"></script>

	<script type="text/javascript" src="js/jquery.paging.min.js"></script>

	<script type="text/javascript" src="js/jquery.easy-paging.js"></script>

	<script type="text/javascript">



		//CALENDARIO

		$(".calendario").datepicker({

		    showAnim: 'blind'

		});



	</script>

</body>

</html>

