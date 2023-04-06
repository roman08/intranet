<?php /* ------------------------------------------------

Código de Servnet México S.A. de C.V.

---------------------------------------------------*/



  // No almacenar en el cache del navegador esta página.

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada

		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1

		header("Pragma: no-cache");                                   		// HTTP/1.0

?>

<!DOCTYPE html>

<html lang="es-MX">

<head>

	<meta charset="UTF-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />

	<title>Administrador Intranet Do It Roght</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

	<link rel="stylesheet" type="text/css" href="css/estilos_gral.css" />

</head>

<body class="inicio">

	<header id="headerHome">

		<div class="container">

			<div class="col-xs-12 col-sm-6 contLogo">

				<img class="logotipo" src="img/logotipo_doitright.png" alt="logotipo-pulsoInmobiliario">

	    </div>

			<div id="acceso" class="contRecuadro col-xs-12 col-sm-6">

				
    <h3 class="naranja"><strong>Bienvenid@</strong></h3>
    <p>Al administrador de www.intranetdoitright.com</p>

				<form action="admin.php" method="post" enctype="multipart/form-data" class="login" id="form_login">

					<div class="form-group">

						<ul class="listForm">

						  <?php // Mostrar error de Autentificación.

                          include ("functions/gestion_errores.php");

                          if (isset($_GET['error_login'])){

                              $error=$_GET['error_login'];

                          echo '<li>Error: '.$error_login_ms[$error].'</li>';

                          }

                         ?>

                          <li>

							<label>*Usuario</label>

							  <input name="user" type="text" class="form-control" id="user" maxlength="100" placeholder="Correo Electrónico" required autofocus>

							</li>

						  <li>

							<label>*Contraseña</label>

							  <input name="pass" type="password" class="form-control" id="pass" maxlength="15" required autofocus>

							</li>

							<li class="ultimoLi">

								<span class="requeridos">*Datos Requeridos</span>

								<button id="btnIngresar" class="btn btn-lg back_naranja negro" type="submit">Ingresar</button>

							</li>

						</ul>

					</div>

				</form>

			</div>

		</div>	

	</header>





<!-- footer -->

	<footer>

		<div class="container">

				<div class="contFooter col-xs-12 col-sm-6">

					
    <p class="txtCh bco"><font color="#FFFFFF">© 2023 www.intranet.doitright.solutions 
      Powered by Do It Right</font></p>

				</div>

				<div id="design" class="contFooter col-xs-12 col-sm-6">

					<a href="http://doitright.solutions/" target="_blank"><img src="img/logotipo_doitright-footer.png" alt="doitright"></a><!-- <span class="txtCh bco">Sitio Diseñado por</span> -->

				</div>

		</div>

	</footer>



	

    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script type="text/javascript">

		 $("#btnIngresar").on( "click", function() {	 

	        location.href="admin_home.php"

	    });

	</script>

</body>

</html>