<?php
session_name('usuario_empleado_servnet');
session_start();
include ("admin/functions/config.php");
include ("admin/functions/conect.php");

if(!isset($_SESSION['usuario_estilos'])){ $_SESSION['usuario_estilos']=Estilos_Colores();}

if(!isset($_SESSION['usuario_id'])){ header("Location: login.php"); exit();}

if(isset($_GET['ver'])){ $ver=$_GET['ver'];} else {$ver='';}
if(isset($_GET['id'])){ $id=$_GET['id'];} else {$id='';}
if(isset($_GET['pagina'])){ $pagina=$_GET['pagina'];} else {$pagina='';}
if(isset($_GET['inicio'])){ $inicio=$_GET['inicio'];} else {$inicio='';}
?>
<!doctype html>
<!--[if IE 9]><html class="no-js ie9"><![endif]-->
<!--[if gt IE 9]><!--><html lang="es-MX" class="no-js"><!--<![endif]-->
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
		<link rel="icon" type="image/x-icon" href="img/favicon.ico" />
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300' rel='stylesheet' type='text/css'>

		<!-- CSS -->
		<!-- slide home -->  		<link rel="stylesheet" href="css/pgwslider.css">
		<!-- calendario -->  		<link rel="stylesheet" href="css/calendar.css">
		<!-- organigrama --> 		<link rel="stylesheet" href="css/component.css">
		<!-- filtro documentos --> 	<link rel="stylesheet" href="css/jquery-ui.css">
									<link rel="stylesheet" href="css/estilos.css">
					<?php echo $_SESSION['usuario_estilos'];?>

		<!-- <noscript>
			<link rel="stylesheet" type="text/css" href="css/noscript.css" />
		</noscript>-->

		<script src="js/modernizr.custom.js"></script>

	</head>
	<body>
		<!-- LIGHT BOX -->
		<div id="lightBox" class="lightBox">
			<div class="contForm">
				<img class="cerrar" src="img/iconos/cerrar.png" alt="">
				<h3 class="TitBloque">Sugerencias</h3>
				<div class="paddBox">
					<p class="azulC t20 light">Envianos tus comentarios.</p>
					<form action="procesa.php" method="post" class="formulario">
						<input type="text" class="form" placeholder="Escribe tu email" name="correo" id="correo" required>
						<textarea name="" class="form" placeholder="Escribe tu sugerencia" name="comentarios" id="comentarios" required></textarea>
						<?php
						$_SESSION['empleado_sugerencia']=rand(9999,999999);
						$token=md5($_SESSION['empleado_sugerencia']);?>
						<input type="hidden" id="token" name="token" value="<?php echo $token;?>">
						<input type="hidden" id="ver" name="ver" value="sesion">
						<input type="hidden" id="accion" name="accion" value="sugerencia">
					</form>
					<button type="submit"><img src="img/iconos/submit.png" alt=""></button>
				</div>
			</div>
		</div>


		<?php if(!isset($_SESSION['ver_video'])){
			$row=FetchArray(ProcesaQuery("SELECT * from intranet_cortinilla where id='1';"));
			$_SESSION['ver_video']='SI';
			if($row['video']!=''){
			?>
		<!-- LIGHTBOX VIDEO -->
		<div id="lightVideo" class="lightBox lightBoxA">
<!-- 			<a href="https://player.vimeo.com/video/1084537?title=0&amp;byline=0&amp;portrait=0" class="html5lightbox" title="Big Buck Bunny Copyright Blender Foundation"><img src="images/Big_Buck_Bunny_2_96.jpg"></a>
 -->
			<div class="contForm">
				<img class="cerrar" src="img/iconos/cerrar.png" alt="">
				<div class="paddBox">
					<iframe width="100%" height="315"src="<?php echo $row['video'];?>"></iframe>
				</div>
			</div>
		</div>
	<?php }}?>



		<header id="headerIndex">
			<div id="tipoCambio">
				<div class="container">
					<?php
					$divisas=FetchArray(ProcesaQuery("SELECT *
					FROM intranet_divisas
					WHERE id='1';"));
					 ?>
					<ul>
						<!-- <li><span class="bold"><?php echo $_SESSION['usuario_nombre'];?></span></li> -->
						<li class="bold">Tipo de cambio</li>
						<li>Corporativo <span class="bold">$<?php echo $divisas['corporativo'];?></span></li>
						<li>Ventanilla <span class="bold">$<?php echo $divisas['ventanilla'];?></span></li>
					</ul>
				</div>
			</div>
			<div id="secAzul" class="back_azul header_background">
				<div class="container">
					<h1>
						<a href="index.php">
							<img src="<?php echo $_SESSION['intranet_logotipo'];?>" alt="<?php echo $_SESSION['intranet_nombre'];?>" />
						</a>
						<!-- <span class="nombreEmpresa"><?php echo $_SESSION['intranet_nombre'];?></span> -->
					</h1>
					<div id="sesion">
						<ul>
							<li>Bienvenido: <?php echo $_SESSION['usuario_nombre'];?></li>
							<li>|</li>
							<li><a id="" href="index.php?ver=cambiar_contrasena">Cambiar Contraseña</a></li>
						</ul>
					</div>
					<button onclick="location.href='procesa.php?ver=sesion&accion=logout';" >Cerrar Sesión</button>
				</div>
			</div>
		</header>

<!-- MENU -->
		 <nav id="navPrincipal">
			<div class="container">
				<div id="dl-menu" class="dl-menuwrapper">
					<button class="dl-trigger">Abrir Menu</button>
					<ul class="dl-menu">
						<li class="test"><a href="index.php">Inicio</a></li>
						<li class="MenuTr"><a class="desplegable" href="#">Nuestra Empresa</a>
							<ul class="dl-submenu">
								<li><a href="index.php?ver=nuestra_empresa">Misión, Visión y Valores</a></li>
								<li><a href="index.php?ver=nuestra_empresa#msnDireccion">Mensaje de la dirección</a></li>
								<li><a href="index.php?ver=organigrama">Organigrama</a></li>
							</ul>
						</li>
						<li><a href="index.php?ver=noticias">Noticias</a></li>
						<li><a href="index.php?ver=articulos">Artículos</a></li>
						<li><a href="index.php?ver=calendario">Calendario</a></li>
						<li><a href="index.php?ver=documentos">Documentos</a></li>
						<li><a href="index.php?ver=casos_exito">Casos de Éxito</a></li>
						<li><a id="sugerencias" href="#">Sugerencias</a></li>
					</ul>
				</div>
			</div>
		 </nav>

<!-- comienza contenido -->
		<div class="container">
			<!-- contenedor principal -->
			<section id="contPrincipal" class="mTop">
				<?php
					if(file_exists('interior_'.$ver.'.php') and ($ver!='')){
						include('interior_'.$ver.'.php');
					} else{
						include('interior_home.php');
					}
				?>
			</section>

			<!-- aside -->
			<aside id="asideIndex" class="mTop">
				<div id="asideIzq">
					<!-- accesos -->
					<div id="accesos">
						<h3 class="TitBloque">Accesos</h3>
						<?php
						$consulta=ProcesaQuery("select * from intranet_accesos_directos order by orden ;");
						while ($row=FetchArray($consulta)) { ?>
						<a href="<?php echo $row['liga'];?>" target="_blank">
							<img src="accesos/<?php echo $row['imagen'];?>" alt="icono <?php echo $row['titulo'];?>" /><span class="txt"><?php echo $row['titulo'];?></span>
						</a>
					<?php }?>
						<!-- tamaño de iconos 60 x 60 pixeles -->
					</div>

					<!-- calendario -->
					<div id="calendario" class="mTop">
						<div class="custom-calendar-wrap">
							<div id="custom-inner" class="custom-inner">
								<div class="custom-header clearfix">
									<nav>
										<span id="custom-prev" class="custom-prev"></span>
										<span id="custom-next" class="custom-next"></span>
									</nav>
									<h2 id="custom-month" class="custom-month"></h2>
									<h3 id="custom-year" class="custom-year"></h3>
								</div>
								<div id="calendar" class="fc-calendar-container"></div>
							</div>
						</div>


						<?php
						$meses=array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
						$con=ProcesaQuery("select CONCAT(A.nombre,' ',A.apellidop,' ',A.apellidom) as nombre
						, DATE_FORMAT(A.fecha, '%m') as mes, DATE_FORMAT(A.fecha, '%d') as dia, B.nombre as puesto, A.imagen
						FROM intranet_empleados A
						LEFT JOIN intranet_organigrama B ON A.id_seccion=B.id_seccion
						WHERE MONTH(A.fecha)='".date("m")."' and activo='1' and eliminado='0' ORDER BY RAND() LIMIT 1");
						if(NumRows($con)>0){
							$row=FetchArray($con);
						?>
						<!-- fecha de cumpleaños -->
						<div id="fechaCumple">
							<!-- <img src="img/pastel.png" alt="icono pastel"> -->
							<h3 class="regular">Cumpleaños del mes</h3>
							<figure>
								<?php if($row['imagen']!='' and file_exists('empleados/'.$row['imagen'])) { ?><img src="empleados/<?php echo $row['imagen'];?>" alt="foto"><?php }?>
								<figcaption>
									<span class="light txGde"><?php echo $row['dia'].' '.$meses[$row['mes']];?></span>
									<span class="bold"><?php echo $row['nombre'];?></span>
									<span class="light txCh">(<?php echo $row['puesto'];?>)</span>
								</figcaption>
							</figure>
						</div>
					<?php }?>


					</div>
				</div>

				<div id="asideDer">
					<!-- clima -->
					<div id="clima" class="mTop">
						<h4 class="light">Ciudad de México</h4>
						<div id="weather"></div>
					</div>
					<!-- casos de exito -->
					<div id="casosExito" class="mTop">
						<h3 class="TitBloque">Casos de Éxito</h3>
						<div class="contenido">
							<ul class="bxslider">
								<?php
								$consulta=ProcesaQuery("select * from intranet_casos_exito order by RAND() limit 3 ;");
								while ($row=FetchArray($consulta)) { ?>
				 				<li>
									<p class="bold titulo"><?php echo $row['titulo'];?></p>
									<p class="txSlide"><?php echo $row['texto1'];?></p>
				 				</li>
							<?php }?>
							</ul>
						</div>
					</div>
				</div>
			</aside>
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
						<?php
						$ligaRedes=FetchArray(ProcesaQuery("SELECT IF(facebook<>'',facebook, '#') as facebook, IF(twitter<>'',twitter, '#') as twitter
						FROM intranet_redes_sociales
						WHERE id='1';"));
						 ?>
						<a href="<?php echo $ligaRedes['twitter'];?>" target="_blank"><img src="img/twitter.png" alt="icono twitter" /></a>
						<a href="<?php echo $ligaRedes['facebook'];?>" target="_blank"><img class="facebook" src="img/facebook.png" alt="icono facebook" /></a>

					</div>
					<a id="avisoLink" class="light t14" href="index.php?ver=aviso_privacidad">Aviso de Privacidad</a>
				</div>
			</div>
		</footer>


		<!-- SCRIPTS -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<!-- menu --> 				<script type="text/javascript" src="js/jquery.dlmenu.js"></script>
		<!-- clima --> 				<script type="text/javascript" src="js/jquery.simpleWeather.js"></script>
		<!-- calendario --> 		<script type="text/javascript" src="js/jquery.calendario.js"></script>
									<script type="text/javascript" src="js/data.js"></script>
		<!-- slide home --> 		<script type="text/javascript" src="js/pgwslider.min.js"></script>
		<!-- slide casos exito -->	<script type="text/javascript" src="js/jquery.bxslider.js"></script>
		<!-- filtro documentos  -->	<script type="text/javascript" src="js/jquery-ui.js"></script>
		<!-- organigrama  --> 		<script type="text/javascript" src="js/jquery.cbpNTAccordion.min.js"></script>

		<script>
			//MENU
			$(function() {
				$( '#dl-menu' ).dlmenu({
					animationClasses : { classin : 'dl-animate-in-3', classout : 'dl-animate-out-3' }
				});
			});

			//CLIMA ASIDE
			$(document).ready(function() {
				$.simpleWeather({
				    location: 'df, mexico',
				    woeid: '',
				    unit: 'c',
				    success: function(weather) {
				      html = '<h2><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h2>';
				      // html += '<ul><li>'+weather.city+', '+weather.region+'</li>';
				      // html += '<li class="currently">'+weather.currently+'</li>';
				      // html += '<li>'+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</li></ul>';

				      $("#weather").html(html);
				    },
				    error: function(error) {
				      $("#weather").html('<p>'+error+'</p>');
				    }
				});
			});

			//CALENDARIO ASIDE
			$(function() {
				var transEndEventNames = {
						'WebkitTransition' : 'webkitTransitionEnd',
						'MozTransition' : 'transitionend',
						'OTransition' : 'oTransitionEnd',
						'msTransition' : 'MSTransitionEnd',
						'transition' : 'transitionend'
				},

				transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
				$wrapper = $( '#custom-inner' ),
				$calendar = $( '#calendar' ),
				cal = $calendar.calendario( {
					onDayClick : function( $el, $contentEl, dateProperties ) {
						if( $contentEl.length > 0 ) {
							showEvents( $contentEl, dateProperties );
						}

					},
					caldata : codropsEvents,
					displayWeekAbbr : true
				} ),

					$month = $( '#custom-month' ).html( cal.getMonthName() ),
					$year = $( '#custom-year' ).html( cal.getYear() );

				$( '#custom-next' ).on( 'click', function() {
					cal.gotoNextMonth( updateMonthYear );
				} );
				$( '#custom-prev' ).on( 'click', function() {
					cal.gotoPreviousMonth( updateMonthYear );
				} );

				function updateMonthYear() {
					$month.html( cal.getMonthName() );
					$year.html( cal.getYear() );
				}

				// just an example..
				function showEvents( $contentEl, dateProperties ) {

					hideEvents();

					var $events = $( '<div id="custom-content-reveal" class="custom-content-reveal"><h4>Events for ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4></div>' ),
						$close = $( '<span class="custom-content-close"></span>' ).on( 'click', hideEvents );

					$events.append( $contentEl.html() , $close ).insertAfter( $wrapper );

					setTimeout( function() {
						$events.css( 'top', '0%' );
					}, 25 );
				}

				function hideEvents() {

					var $events = $( '#custom-content-reveal' );
					if( $events.length > 0 ) {

						$events.css( 'top', '100%' );
						Modernizr.csstransitions ? $events.on( transEndEventName, function() { $( this ).remove(); } ) : $events.remove();
					}
				}
			});

			//CASOS DE EXITO
			$('.bxslider').bxSlider({
			  auto: true
			});

			//SLIDE HOME
			$('.bxsliderHome').bxSlider({
			  auto: true
			});

			//CALENDARIO
			$(function() {
			    $( ".from").datepicker({
			      defaultDate: "+1w",
			      showAnim: 'slideDown',
			      changeMonth: false,
			      numberOfMonths: 1,
			      onClose: function( selectedDate) {
			        $( ".to" ).datepicker( "option", "minDate", selectedDate );
			      }
			    });
			    $( ".to").datepicker({
			      defaultDate: "+1w",
			      showAnim: 'slideDown',
			      changeMonth: false,
			      numberOfMonths: 1,
			      onClose: function( selectedDate ) {
			        $( ".from").datepicker( "option", "maxDate", selectedDate );
			      }
			    });
			});

			//ORGANIGRAMA
			$( function() {
				$( '#cbp-ntaccordion' ).cbpNTAccordion();
			} );

			//LIGHT BOX
			$("#sugerencias").click(function(){
				$("#lightBox").slideDown();
			});

			$(".cerrar").click(function(){
				$(".lightBox").slideUp();
			});
		</script>
	</body>
</html>
