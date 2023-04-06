<?php
/* ------------------------------------------------
Código de Servnet México S.A. de C.V.
---------------------------------------------------*/
include ("functions/config.php");
require("verificar_usuario.php");
$nivel_acceso=4; // Nivel de acceso para esta página.
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5&x=1");
exit;
}

include ("functions/conect.php");

if (!valida_seccion($ver, $_SESSION['usuario_id'])){
header ("Location: admin.php?ver=$ver&inicio=$inicio");
exit();
}

switch ($ver){

////Usuarios Admin
case 'usuarios':
switch ($accion){

case 'Cambiar_Password':
	if(isset($_POST['contrasena1'])){ $contrasena1=Limpiar_Cadena(trim($_POST['contrasena1']));}else{ $contrasena1='';}
	if(isset($_POST['contrasena2'])){ $contrasena2=Limpiar_Cadena(trim($_POST['contrasena2']));}else{ $contrasena2='';}
	if(isset($_POST['contrasena3'])){ $contrasena3=Limpiar_Cadena(trim($_POST['contrasena3']));}else{ $contrasena3='';}

			if(!(($contrasena1!='') and ($contrasena2!='') and ($contrasena3!=''))){
				echo '<script type="text/JavaScript">window.alert("Las contrase\u00F1as no coinciden.")</script>';
				echo "<meta http-equiv='refresh' content='0;URL=admin.php?ver=cambio_contrasena'>";
				exit();
			}

			if(NumRows(ProcesaQuery("select id_usuario from intranet_usuarios where id_usuario='$_SESSION[usuario_id]' and password='$contrasena1';"))==0){
				echo '<script type="text/JavaScript">window.alert("Las contrase\u00F1a actual no es correcta.")</script>';
				echo "<meta http-equiv='refresh' content='0;URL=admin.php?ver=cambio_contrasena'>";
				exit();
			}

			if($contrasena3!=$contrasena2){
				echo '<script type="text/JavaScript">window.alert("Las contrase\u00F1as no coinciden.")</script>';
				echo "<meta http-equiv='refresh' content='0;URL=admin.php?ver=cambio_contrasena'>";
				exit();
			}


			ProcesaQuery("UPDATE intranet_usuarios set password='$contrasena2' where id_usuario='$_SESSION[usuario_id]' limit 1;");

			echo '<script type="text/JavaScript">window.alert("Se ha cambiado la contrase\u00F1a correctamente.")</script>';
			echo "<meta http-equiv='refresh' content='0;URL=admin.php'>";
			exit();
break;

case 'Guardar':
if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
if(isset($_POST['usuario_'])){ $usuario_=Limpiar_Cadena($_POST['usuario_']);}else{ $usuario_='';}
if(isset($_POST['password_'])){ $password_=Limpiar_Cadena($_POST['password_']);}else{ $password_='';}
if (NumRows(ProcesaQuery("select usuario from intranet_usuarios where usuario='$usuario_'"))==0 ){
$ID=InsertQuery("INSERT INTO `intranet_usuarios` ( `id_usuario` , `nombre`, `usuario`, `password`, `nivel`) VALUES ( NULL , '$nombre', '$usuario_', '$password_', '1');");
$_SESSION['error']=18;

	$c=ProcesaQuery("select * from intranet_secciones;");
	while ($r=FetchArray($c)){
	eval('$aux=$s'.$r['id_seccion'].';');
	if ($aux=='1') ProcesaQuery("insert into intranet_usuarios_seccion (id_usuario, id_seccion) values ('$ID', '$r[id_seccion]')");
	}
 }
else
$_SESSION['error']=21;
break;

case 'Modificar':
if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
if(isset($_POST['usuario_'])){ $usuario_=Limpiar_Cadena($_POST['usuario_']);}else{ $usuario_='';}
if(isset($_POST['password_'])){ $password_=Limpiar_Cadena($_POST['password_']);}else{ $password_='';}
if (NumRows(ProcesaQuery("select usuario from intranet_usuarios where usuario='$usuario_' and id_usuario<>'$id_usuario';"))==0 ){

    if ($id_usuario<>'1') ProcesaQuery("delete from intranet_usuarios_seccion where id_usuario='$id_usuario';");

    $c=ProcesaQuery("select * from intranet_secciones;");
	while ($r=FetchArray($c)){
	eval('$aux=$s'.$r['id_seccion'].';');

	if (($aux=='1') and ($id_usuario<>'1')) ProcesaQuery("insert into intranet_usuarios_seccion (id_usuario, id_seccion) values ('$id_usuario', '$r[id_seccion]');");

	}

ProcesaQuery("update intranet_usuarios set usuario='$usuario_', password='$password_', nombre='$nombre' where `id_usuario`='$id_usuario' and id_usuario<>'1'");
$_SESSION['error']=19; }
else
$_SESSION['error']=21;
break;

case 'Eliminar':
ProcesaQuery("delete from intranet_usuarios where `id_usuario`='$id_usuario' and id_usuario<>'1';");
$_SESSION['error']=20;
break;
}
break;

case 'sugerencias':
switch ($accion){
	case 'Eliminar':
	if(isset($_GET['id_sugerencia'])){ $id_sugerencia=Limpiar_Cadena($_GET['id_sugerencia']);}else{ $id_sugerencia='';}
	if(isset($_GET['inicial'])){ $inicial=Limpiar_Cadena($_GET['inicial']);}else{ $inicial='';}
	if(isset($_GET['final'])){ $final=Limpiar_Cadena($_GET['final']);}else{ $final='';}
	if(isset($_GET['inicio'])){ $inicio=Limpiar_Cadena($_GET['inicio']);}else{ $inicio='';}

	ProcesaQuery("delete from intranet_sugerencias where `id_sugerencia`='$id_sugerencia'");
	$_SESSION['error']=20;
	break;
}
header ("Location: admin.php?ver=$ver&inicio=$inicio&inicial=$inicial&final=$final");
exit();
break;

case 'principal_cortinilla':
	switch ($accion){
		case 'Modificar':
		if(isset($_POST['video'])){ $video=$_POST['video'];}else{ $video='';}
		ProcesaQuery("UPDATE intranet_cortinilla set video='$video' where id='1';");
		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_datos_general':
	switch ($accion){
		case 'Modificar':
		if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
		if(isset($_POST['domicilio'])){ $domicilio=Limpiar_Cadena($_POST['domicilio']);}else{ $domicilio='';}
		if(isset($_POST['correo'])){ $correo=Limpiar_Cadena($_POST['correo']);}else{ $correo='';}
		if(isset($_POST['telefono'])){ $telefono=Limpiar_Cadena($_POST['telefono']);}else{ $telefono='';}
		if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

		ProcesaQuery("UPDATE intranet_datos_generales set nombre='$nombre', domicilio='$domicilio', correo='$correo', telefono='$telefono' where id='1';");

		if ($archivo['name']!=''){
		$row=FetchArray(ProcesaQuery("select * from intranet_datos_generales where id='1';"));
			if (($row['imagen']!='') and (file_exists('../img/'.$row['imagen']))){
				borra_archivo ($row['imagen'], 'img', 'no');
			}
		$extension='.'.substr(strrchr($archivo['name'],"."),1);
		$file='logo_empresa_'.date("s").$extension;
		sube_archivo ($archivo['tmp_name'], $file, 'img', 'no');
		ProcesaQuery("UPDATE intranet_datos_generales set `imagen`='$file' where id='1';");
		}
		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_header_menu_footer':
	switch ($accion){
		case 'Modificar':
		if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}
		if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
		if(isset($_POST['direccion'])){ $direccion=Limpiar_Cadena($_POST['direccion']);}else{ $direccion='';}
		if(isset($_POST['correo'])){ $correo=Limpiar_Cadena($_POST['correo']);}else{ $correo='';}
		if(isset($_POST['telefono'])){ $telefono=Limpiar_Cadena($_POST['telefono']);}else{ $telefono='';}
		if(isset($_POST['color11'])){ $color11=Limpiar_Cadena($_POST['color11']);}else{ $color11='';}
		if(isset($_POST['color12'])){ $color12=Limpiar_Cadena($_POST['color12']);}else{ $color12='';}
		if(isset($_POST['color13'])){ $color13=Limpiar_Cadena($_POST['color13']);}else{ $color13='';}
		if(isset($_POST['color14'])){ $color14=Limpiar_Cadena($_POST['color14']);}else{ $color14='';}
		if(isset($_POST['color21'])){ $color21=Limpiar_Cadena($_POST['color21']);}else{ $color21='';}
		if(isset($_POST['color22'])){ $color22=Limpiar_Cadena($_POST['color22']);}else{ $color22='';}
		if(isset($_POST['color23'])){ $color23=Limpiar_Cadena($_POST['color23']);}else{ $color23='';}
		if(isset($_POST['color24'])){ $color24=Limpiar_Cadena($_POST['color24']);}else{ $color24='';}
		if(isset($_POST['color25'])){ $color25=Limpiar_Cadena($_POST['color25']);}else{ $color25='';}
		if(isset($_POST['color31'])){ $color31=Limpiar_Cadena($_POST['color31']);}else{ $color31='';}
		if(isset($_POST['color32'])){ $color32=Limpiar_Cadena($_POST['color32']);}else{ $color32='';}
		if(isset($_POST['color33'])){ $color33=Limpiar_Cadena($_POST['color33']);}else{ $color33='';}

		ProcesaQuery("UPDATE intranet_header_menu_footer set modificacion=NOW(), nombre='$nombre', direccion='$direccion', correo='$correo', telefono='$telefono', color11='$color11', color12='$color12', color13='$color13', color14='$color14', color21='$color21', color22='$color22', color23='$color23', color24='$color24', color25='$color25', color31='$color31', color32='$color32', color33='$color33' where id='1';");

		if ($archivo['name']!=''){
		$row=FetchArray(ProcesaQuery("select * from intranet_header_menu_footer where id='1';"));
			if (($row['imagen']!='') and (file_exists('../img/'.$row['imagen']))){
				borra_archivo ($row['imagen'], 'img', 'no');
			}
		$extension='.'.substr(strrchr($archivo['name'],"."),1);
		$file='logotipo_intranet_'.date("s").$extension;
		sube_archivo ($archivo['tmp_name'], $file, 'img', 'no');
		ProcesaQuery("UPDATE intranet_header_menu_footer set `imagen`='$file' where id='1';");
		}

		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_mensaje_direccion':
	switch ($accion){
		case 'Modificar':
		if(isset($_POST['titulo'])){ $titulo=$_POST['titulo'];}else{ $titulo='';}
		if(isset($_POST['texto'])){ $texto=$_POST['texto'];}else{ $texto='';}
		if(isset($_POST['mensaje'])){ $mensaje=$_POST['mensaje'];}else{ $mensaje='';}
		if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

		ProcesaQuery("UPDATE intranet_mensaje_direccion set modificacion=NOW(), titulo='$titulo', texto='$texto', mensaje='$mensaje' where id='1';");

		if ($archivo['name']!=''){
		$row=FetchArray(ProcesaQuery("select * from intranet_mensaje_direccion where id='1';"));
			if (($row['imagen']!='') and (file_exists('../img/'.$row['imagen']))){
				borra_archivo ($row['imagen'], 'img', 'no');
			}
		$extension='.'.substr(strrchr($archivo['name'],"."),1);
		$file='mensaje_direccion_'.date("s").$extension;
		sube_archivo ($archivo['tmp_name'], $file, 'img', 'no');
		ProcesaQuery("UPDATE intranet_mensaje_direccion set `imagen`='$file' where id='1';");
		}
		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_mision_vision':
	switch ($accion){
		case 'Modificar':
		if(isset($_FILES['archivo1'])){ $archivo1=$_FILES['archivo1'];}else{ $archivo1='';}
		if(isset($_POST['texto1'])){ $texto1=$_POST['texto1'];}else{ $texto1='';}
		if(isset($_FILES['archivo2'])){ $archivo2=$_FILES['archivo2'];}else{ $archivo2='';}
		if(isset($_POST['texto2'])){ $texto2=$_POST['texto2'];}else{ $texto2='';}
		if(isset($_FILES['archivo3'])){ $archivo3=$_FILES['archivo3'];}else{ $archivo3='';}
		if(isset($_POST['texto3'])){ $texto3=$_POST['texto3'];}else{ $texto3='';}

		$row=FetchArray(ProcesaQuery("select * from `intranet_mision_vision` where `id`='1';"));

		if ($archivo1['name']!=''){
					if (($row['imagen1']!='') and (file_exists('../img/'.$row['imagen1']))){
						borra_archivo ($row['imagen1'], 'img', 'no');
					}
				$extension='.'.substr(strrchr($archivo1['name'],"."),1);
				$file='mision_vision1_'.date("s").$extension;
				sube_archivo ($archivo1['tmp_name'], $file, 'img', 'no');
				ProcesaQuery("update `intranet_mision_vision` set `imagen1`='$file' where `id`='1';");
		}

		if ($archivo2['name']!=''){
					if (($row['imagen2']!='') and (file_exists('../img/'.$row['imagen2']))){
						borra_archivo ($row['imagen2'], 'img', 'no');
					}
				$extension='.'.substr(strrchr($archivo2['name'],"."),1);
				$file='mision_vision2_'.date("s").$extension;
				sube_archivo ($archivo2['tmp_name'], $file, 'img', 'no');
				ProcesaQuery("update `intranet_mision_vision` set `imagen2`='$file' where `id`='1';");
		}

		if ($archivo3['name']!=''){
					if (($row['imagen3']!='') and (file_exists('../img/'.$row['imagen3']))){
						borra_archivo ($row['imagen3'], 'img', 'no');
					}
				$extension='.'.substr(strrchr($archivo3['name'],"."),1);
				$file='mision_vision3_'.date("s").$extension;
				sube_archivo ($archivo3['tmp_name'], $file, 'img', 'no');
				ProcesaQuery("update `intranet_mision_vision` set `imagen3`='$file' where `id`='1';");
		}

		ProcesaQuery("UPDATE intranet_mision_vision set modificacion=NOW(), texto1='$texto1',  texto2='$texto2', texto3='$texto3' where id='1';");
		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_redes_sociales':
	switch ($accion){
		case 'Modificar':
		if(isset($_POST['facebook'])){ $facebook=Limpiar_Cadena($_POST['facebook']);}else{ $facebook='';}
		if(isset($_POST['twitter'])){ $twitter=Limpiar_Cadena($_POST['twitter']);}else{ $twitter='';}

		ProcesaQuery("UPDATE intranet_redes_sociales set modificacion=NOW(), facebook='$facebook', twitter='$twitter' where id='1';");
		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_divisas':
	switch ($accion){
		case 'Modificar':
		if(isset($_POST['corporativo'])){ $corporativo=Limpiar_Cadena($_POST['corporativo']);}else{ $corporativo='';}
		if(isset($_POST['ventanilla'])){ $ventanilla=Limpiar_Cadena($_POST['ventanilla']);}else{ $ventanilla='';}

		ProcesaQuery("UPDATE intranet_divisas set modificacion=NOW(), corporativo='$corporativo', ventanilla='$ventanilla' where id='1';");
		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_aviso_privacidad':
	switch ($accion){
		case 'Modificar':
		if(isset($_POST['texto'])){ $texto=$_POST['texto'];}else{ $texto='';}
		ProcesaQuery("UPDATE intranet_aviso_privacidad set modificacion=NOW(), texto='$texto' where id='1';");
		$_SESSION['error']=19;
		break;
	}
break;

case 'principal_banners_home':
	
	switch ($accion){
			case 'Guardar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
			if(isset($_POST['texto'])){ $texto=Limpiar_Cadena($_POST['texto']);}else{ $texto='';}
			if(isset($_POST['liga'])){ $liga=Limpiar_Cadena($_POST['liga']);}else{ $liga='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}
			if(isset($_FILES['archivo1'])){ $archivo1=$_FILES['archivo1'];}else{ $archivo1='';}

			$consulta=ProcesaQuery("select orden from `intranet_banners` order by orden Desc limit 1;");
			$row=FetchArray($consulta);
			$orden=$row['orden']+1;
			if (NumRows($consulta)==0)
			$orden=1;
			
			
			$ID=InsertQuery("INSERT INTO `intranet_banners` ( `id_banner` , `registro` , `titulo`, `texto`, `liga`, `imagen`, `imagen1`, `orden`)
			VALUES (NULL , NOW(), '$titulo', '$texto', '$liga', '-', '-', '$orden');");
			
				
			if ($archivo['name']!=''){
					
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				
				$file=$ID.'_imagen_'.date("s").$extension;
				
				sube_archivo ($archivo['tmp_name'], $file, 'banners', 'no');
				
				ProcesaQuery("update `intranet_banners` set `imagen`='$file' where id_banner='$ID'");
				}
			if ($archivo1['name']!=''){
				$extension='.'.substr(strrchr($archivo1['name'],"."),1);
				$file=$ID.'_imagen1_'.date("s").$extension;
				sube_archivo ($archivo1['tmp_name'], $file, 'banners', 'no');
				ProcesaQuery("update `intranet_banners` set `imagen1`='$file' where id_banner='$ID'");
				}

			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
			if(isset($_POST['texto'])){ $texto=Limpiar_Cadena($_POST['texto']);}else{ $texto='';}
			if(isset($_POST['liga'])){ $liga=Limpiar_Cadena($_POST['liga']);}else{ $liga='';}
			if(isset($_POST['id_banner'])){ $id_banner=Limpiar_Cadena($_POST['id_banner']);}else{ $id_banner='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}
			if(isset($_FILES['archivo1'])){ $archivo1=$_FILES['archivo1'];}else{ $archivo1='';}

			$row=FetchArray(ProcesaQuery("select * from `intranet_banners` where `id_banner`='$id_banner';"));
			ProcesaQuery("update intranet_banners set titulo='$titulo', texto='$texto', liga='$liga' where `id_banner`='$id_banner'");

				if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../banners/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'banners', 'no');
					}
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_banner'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'banners', 'no');
				ProcesaQuery("update `intranet_banners` set `imagen`='$file' where `id_banner`='$id_banner';");
				}

				if ($archivo1['name']!=''){
					if (($row['imagen1']!='') and (file_exists('../banners/'.$row['imagen1']))){
						borra_archivo ($row['imagen1'], 'banners', 'no');
					}
				$extension='.'.substr(strrchr($archivo1['name'],"."),1);
				$file=$row['id_banner'].'_imagen1_'.date("s").$extension;
				sube_archivo ($archivo1['tmp_name'], $file, 'banners', 'no');
				ProcesaQuery("update `intranet_banners` set `imagen1`='$file' where `id_banner`='$id_banner';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_banner'])){ $id_banner=Limpiar_Cadena($_GET['id_banner']);}else{ $id_banner='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_banners` where `id_banner`='$id_banner';"));

					$consulta=ProcesaQuery("select orden, id_banner from `intranet_banners` where `orden`>'".$row['orden']."' order by orden ASC;");
					while ($row2=FetchArray($consulta)){
					$ordennuevo=$row2['orden']-1;
					$id=$row2['id_banner'];
					ProcesaQuery("update `intranet_banners` set `orden`='$ordennuevo' where `id_banner`='$id'");
					}


					if (($row['imagen']!='') and (file_exists('../banners/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'banners', 'no');
					}
					if (($row['imagen1']!='') and (file_exists('../banners/'.$row['imagen1']))){
						borra_archivo ($row['imagen1'], 'banners', 'no');
					}


			ProcesaQuery("delete from intranet_banners where `id_banner`='$id_banner'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Ordenar':
			if(isset($_GET['id_banner'])){ $id_banner=Limpiar_Cadena($_GET['id_banner']);}else{ $id_banner='';}
			if(isset($_GET['orden1'])){ $orden1=Limpiar_Cadena($_GET['orden1']);}else{ $orden1='';}
			if(isset($_GET['orden2'])){ $orden2=Limpiar_Cadena($_GET['orden2']);}else{ $orden2='';}
			ProcesaQuery("update intranet_banners set `orden`='$orden1' where orden='$orden2';");
			ProcesaQuery("update intranet_banners set `orden`='$orden2' where `id_banner`='$id_banner';");
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;
	}
break;

case 'principal_accesos_directos':
	switch ($accion){
			case 'Guardar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['liga'])){ $liga=Limpiar_Cadena($_POST['liga']);}else{ $liga='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$consulta=ProcesaQuery("select orden from `intranet_accesos_directos` order by orden Desc limit 1;");
					$row=FetchArray($consulta);
					$orden=$row['orden']+1;
					if (NumRows($consulta)==0)
					$orden=1;

			$ID=InsertQuery("INSERT INTO `intranet_accesos_directos` ( `id_acceso` , `registro` , `titulo`, `liga`, `orden`)
			VALUES (NULL , NOW(), '$titulo', '$liga', '$orden');");
			if ($archivo['name']!=''){
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$ID.'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'accesos', 'no');
				ProcesaQuery("update `intranet_accesos_directos` set `imagen`='$file' where id_acceso='$ID'");
				}
			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['liga'])){ $liga=Limpiar_Cadena($_POST['liga']);}else{ $liga='';}
			if(isset($_POST['id_acceso'])){ $id_acceso=Limpiar_Cadena($_POST['id_acceso']);}else{ $id_acceso='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$row=FetchArray(ProcesaQuery("select * from `intranet_accesos_directos` where `id_acceso`='$id_acceso';"));
			ProcesaQuery("update intranet_accesos_directos set titulo='$titulo', liga='$liga' where `id_acceso`='$id_acceso'");

				if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../accesos/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'accesos', 'no');
					}
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_acceso'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'accesos', 'no');
				ProcesaQuery("update `intranet_accesos_directos` set `imagen`='$file' where `id_acceso`='$id_acceso';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_acceso'])){ $id_acceso=Limpiar_Cadena($_GET['id_acceso']);}else{ $id_acceso='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_accesos_directos` where `id_acceso`='$id_acceso';"));

					$consulta=ProcesaQuery("select orden, id_acceso from `intranet_accesos_directos` where `orden`>'".$row['orden']."' order by orden ASC;");
					while ($row2=FetchArray($consulta)){
					$ordennuevo=$row2['orden']-1;
					$id=$row2['id_acceso'];
					ProcesaQuery("update `intranet_accesos_directos` set `orden`='$ordennuevo' where `id_acceso`='$id'");
					}


					if (($row['imagen']!='') and (file_exists('../accesos/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'accesos', 'no');
					}


			ProcesaQuery("delete from intranet_accesos_directos where `id_acceso`='$id_acceso'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Ordenar':
			if(isset($_GET['id_acceso'])){ $id_acceso=Limpiar_Cadena($_GET['id_acceso']);}else{ $id_acceso='';}
			if(isset($_GET['orden1'])){ $orden1=Limpiar_Cadena($_GET['orden1']);}else{ $orden1='';}
			if(isset($_GET['orden2'])){ $orden2=Limpiar_Cadena($_GET['orden2']);}else{ $orden2='';}
			ProcesaQuery("update intranet_accesos_directos set `orden`='$orden1' where orden='$orden2';");
			ProcesaQuery("update intranet_accesos_directos set `orden`='$orden2' where `id_acceso`='$id_acceso';");
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;
	}
break;

case 'noticias':
	switch ($accion){
			case 'Guardar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['texto1'])){ $texto1=Limpiar_Cadena($_POST['texto1']);}else{ $texto1='';}
            if(isset($_POST['texto2'])){ $texto2=$_POST['texto2'];}else{ $texto2='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$ID=InsertQuery("INSERT INTO `intranet_noticias` ( `id_noticia` , `registro` , `titulo`, `texto1`, `texto2`)
			VALUES (NULL , NOW(), '$titulo', '$texto1', '$texto2');");
			if ($archivo['name']!=''){
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$ID.'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'noticias', 'no');
				ProcesaQuery("update `intranet_noticias` set `imagen`='$file' where id_noticia='$ID'");
				}
			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['id_noticia'])){ $id_noticia=Limpiar_Cadena($_POST['id_noticia']);}else{ $id_noticia='';}
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['texto1'])){ $texto1=Limpiar_Cadena($_POST['texto1']);}else{ $texto1='';}
            if(isset($_POST['texto2'])){ $texto2=$_POST['texto2'];}else{ $texto2='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$row=FetchArray(ProcesaQuery("select * from `intranet_noticias` where `id_noticia`='$id_noticia';"));
			ProcesaQuery("update intranet_noticias set titulo='$titulo', texto1='$texto1', texto2='$texto2' where `id_noticia`='$id_noticia'");

				if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../noticias/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'noticias', 'no');
					}
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_noticia'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'noticias', 'no');
				ProcesaQuery("update `intranet_noticias` set `imagen`='$file' where `id_noticia`='$id_noticia';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_noticia'])){ $id_noticia=Limpiar_Cadena($_GET['id_noticia']);}else{ $id_noticia='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_noticias` where `id_noticia`='$id_noticia';"));
                if (($row['imagen']!='') and (file_exists('../noticias/'.$row['imagen']))){
                    borra_archivo ($row['imagen'], 'noticias', 'no');
                }
			ProcesaQuery("delete from intranet_noticias where `id_noticia`='$id_noticia'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;
	}
break;

case 'articulos':
	switch ($accion){
			case 'Guardar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['texto1'])){ $texto1=Limpiar_Cadena($_POST['texto1']);}else{ $texto1='';}
            if(isset($_POST['texto2'])){ $texto2=$_POST['texto2'];}else{ $texto2='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$ID=InsertQuery("INSERT INTO `intranet_articulos` ( `id_articulo` , `registro` , `titulo`, `texto1`, `texto2`)
			VALUES (NULL , NOW(), '$titulo', '$texto1', '$texto2');");
			if ($archivo['name']!=''){
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$ID.'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'articulos', 'no');
				ProcesaQuery("update `intranet_articulos` set `imagen`='$file' where id_articulo='$ID'");
				}
			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['id_articulo'])){ $id_articulo=Limpiar_Cadena($_POST['id_articulo']);}else{ $id_articulo='';}
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['texto1'])){ $texto1=Limpiar_Cadena($_POST['texto1']);}else{ $texto1='';}
            if(isset($_POST['texto2'])){ $texto2=$_POST['texto2'];}else{ $texto2='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$row=FetchArray(ProcesaQuery("select * from `intranet_articulos` where `id_articulo`='$id_articulo';"));
			ProcesaQuery("update intranet_articulos set titulo='$titulo', texto1='$texto1', texto2='$texto2' where `id_articulo`='$id_articulo'");

				if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../articulos/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'articulos', 'no');
					}
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_articulo'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'articulos', 'no');
				ProcesaQuery("update `intranet_articulos` set `imagen`='$file' where `id_articulo`='$id_articulo';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_articulo'])){ $id_articulo=Limpiar_Cadena($_GET['id_articulo']);}else{ $id_articulo='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_articulos` where `id_articulo`='$id_articulo';"));
                if (($row['imagen']!='') and (file_exists('../articulos/'.$row['imagen']))){
                    borra_archivo ($row['imagen'], 'articulos', 'no');
                }
			ProcesaQuery("delete from intranet_articulos where `id_articulo`='$id_articulo'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;
	}
break;

case 'calendario':
	switch ($accion){
			case 'Guardar':
			if(isset($_POST['fecha'])){ $fecha=Limpiar_Cadena(fecha_aaaammdd($_POST['fecha']));}else{ $fecha='';}
            if(isset($_POST['horario'])){ $horario=Limpiar_Cadena($_POST['horario']);}else{ $horario='';}
            if(isset($_POST['actividad'])){ $actividad=Limpiar_Cadena($_POST['actividad']);}else{ $actividad='';}
            if(isset($_POST['ubicacion'])){ $ubicacion=Limpiar_Cadena($_POST['ubicacion']);}else{ $ubicacion='';}
            if(isset($_POST['descripcion'])){ $descripcion=Limpiar_Cadena($_POST['descripcion']);}else{ $descripcion='';}
            if(isset($_POST['activo'])){ $activo=Limpiar_Cadena($_POST['activo']);}else{ $activo='';}

			$ID=InsertQuery("INSERT INTO `intranet_calendario` ( `id_calendario` , `registro` , `fecha`, `horario`, `actividad`, `ubicacion`, `descripcion`, `activo`)
			VALUES (NULL , NOW(), '$fecha', '$horario', '$actividad', '$ubicacion', '$descripcion', '$activo');");

			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['id_calendario'])){ $id_calendario=Limpiar_Cadena($_POST['id_calendario']);}else{ $id_calendario='';}
			if(isset($_POST['fecha'])){ $fecha=Limpiar_Cadena(fecha_aaaammdd($_POST['fecha']));}else{ $fecha='';}
            if(isset($_POST['horario'])){ $horario=Limpiar_Cadena($_POST['horario']);}else{ $horario='';}
            if(isset($_POST['actividad'])){ $actividad=Limpiar_Cadena($_POST['actividad']);}else{ $actividad='';}
            if(isset($_POST['ubicacion'])){ $ubicacion=Limpiar_Cadena($_POST['ubicacion']);}else{ $ubicacion='';}
            if(isset($_POST['descripcion'])){ $descripcion=Limpiar_Cadena($_POST['descripcion']);}else{ $descripcion='';}
            if(isset($_POST['activo'])){ $activo=Limpiar_Cadena($_POST['activo']);}else{ $activo='';}

			ProcesaQuery("update intranet_calendario set fecha='$fecha', horario='$horario', actividad='$actividad', ubicacion='$ubicacion', descripcion='$descripcion', activo='$activo'
            where `id_calendario`='$id_calendario'");

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_calendario'])){ $id_calendario=Limpiar_Cadena($_GET['id_calendario']);}else{ $id_calendario='';}
			ProcesaQuery("delete from intranet_calendario where `id_calendario`='$id_calendario'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;
	}
break;

case 'casos_exito':
	switch ($accion){
			case 'Guardar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['texto1'])){ $texto1=Limpiar_Cadena($_POST['texto1']);}else{ $texto1='';}
            if(isset($_POST['texto2'])){ $texto2=$_POST['texto2'];}else{ $texto2='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$consulta=ProcesaQuery("select orden from `intranet_casos_exito` order by orden Desc limit 1;");
					$row=FetchArray($consulta);
					$orden=$row['orden']+1;
					if (NumRows($consulta)==0)
					$orden=1;

			$ID=InsertQuery("INSERT INTO `intranet_casos_exito` ( `id_caso` , `registro` , `titulo`, `texto1`, `texto2`, `orden`)
			VALUES (NULL , NOW(), '$titulo', '$texto1', '$texto2', '$orden');");
			if ($archivo['name']!=''){
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$ID.'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'casos_exito', 'no');
				ProcesaQuery("update `intranet_casos_exito` set `imagen`='$file' where id_caso='$ID'");
				}
			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['id_caso'])){ $id_caso=Limpiar_Cadena($_POST['id_caso']);}else{ $id_caso='';}
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['texto1'])){ $texto1=Limpiar_Cadena($_POST['texto1']);}else{ $texto1='';}
            if(isset($_POST['texto2'])){ $texto2=$_POST['texto2'];}else{ $texto2='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$row=FetchArray(ProcesaQuery("select * from `intranet_casos_exito` where `id_caso`='$id_caso';"));
			ProcesaQuery("update intranet_casos_exito set titulo='$titulo', texto1='$texto1', texto2='$texto2' where `id_caso`='$id_caso'");

				if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../casos_exito/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'casos_exito', 'no');
					}
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_caso'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'casos_exito', 'no');
				ProcesaQuery("update `intranet_casos_exito` set `imagen`='$file' where `id_caso`='$id_caso';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_caso'])){ $id_caso=Limpiar_Cadena($_GET['id_caso']);}else{ $id_caso='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_casos_exito` where `id_caso`='$id_caso';"));

					$consulta=ProcesaQuery("select orden, id_caso from `intranet_casos_exito` where `orden`>'".$row['orden']."' order by orden ASC;");
					while ($row2=FetchArray($consulta)){
					$ordennuevo=$row2['orden']-1;
					$id=$row2['id_caso'];
					ProcesaQuery("update `intranet_casos_exito` set `orden`='$ordennuevo' where `id_caso`='$id'");
					}

					if (($row['imagen']!='') and (file_exists('../casos_exito/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'casos_exito', 'no');
					}

			ProcesaQuery("delete from intranet_casos_exito where `id_caso`='$id_caso'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Ordenar':
			if(isset($_GET['id_caso'])){ $id_caso=Limpiar_Cadena($_GET['id_caso']);}else{ $id_caso='';}
			if(isset($_GET['orden1'])){ $orden1=Limpiar_Cadena($_GET['orden1']);}else{ $orden1='';}
			if(isset($_GET['orden2'])){ $orden2=Limpiar_Cadena($_GET['orden2']);}else{ $orden2='';}
			ProcesaQuery("update intranet_casos_exito set `orden`='$orden1' where orden='$orden2';");
			ProcesaQuery("update intranet_casos_exito set `orden`='$orden2' where `id_caso`='$id_caso';");
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;
	}
break;

case 'organigrama':
	switch ($accion){
			case 'Guardar':
			if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
            if(isset($_POST['descripcion'])){ $descripcion=$_POST['descripcion'];}else{ $descripcion='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$consulta=ProcesaQuery("select orden from `intranet_organigrama` order by orden Desc limit 1;");
					$row=FetchArray($consulta);
					$orden=$row['orden']+1;
					if (NumRows($consulta)==0)
					$orden=1;

			$ID=InsertQuery("INSERT INTO `intranet_organigrama` ( `id_seccion` , `registro` , `nombre`, `descripcion`, `orden`)
			VALUES (NULL , NOW(), '$nombre', '$descripcion', '$orden');");
			if ($archivo['name']!=''){
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$ID.'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'organigrama', 'no');
				ProcesaQuery("update `intranet_organigrama` set `imagen`='$file' where id_seccion='$ID'");
				}
			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['id_seccion'])){ $id_seccion=Limpiar_Cadena($_POST['id_seccion']);}else{ $id_seccion='';}
			if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
      if(isset($_POST['descripcion'])){ $descripcion=$_POST['descripcion'];}else{ $descripcion='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$row=FetchArray(ProcesaQuery("select * from `intranet_organigrama` where `id_seccion`='$id_seccion';"));
			ProcesaQuery("update intranet_organigrama set nombre='$nombre', descripcion='$descripcion' where `id_seccion`='$id_seccion'");

				if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../organigrama/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'organigrama', 'no');
					}
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_seccion'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'organigrama', 'no');
				ProcesaQuery("update `intranet_organigrama` set `imagen`='$file' where `id_seccion`='$id_seccion';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_seccion'])){ $id_seccion=Limpiar_Cadena($_GET['id_seccion']);}else{ $id_seccion='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_organigrama` where `id_seccion`='$id_seccion';"));

					$consulta=ProcesaQuery("select orden, id_seccion from `intranet_organigrama` where `orden`>'".$row['orden']."' order by orden ASC;");
					while ($row2=FetchArray($consulta)){
					$ordennuevo=$row2['orden']-1;
					$id=$row2['id_seccion'];
					ProcesaQuery("update `intranet_organigrama` set `orden`='$ordennuevo' where `id_seccion`='$id'");
					}

					if (($row['imagen']!='') and (file_exists('../organigrama/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'organigrama', 'no');
					}

			ProcesaQuery("delete from intranet_organigrama where `id_seccion`='$id_seccion'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Ordenar':
			if(isset($_GET['id_seccion'])){ $id_seccion=Limpiar_Cadena($_GET['id_seccion']);}else{ $id_seccion='';}
			if(isset($_GET['orden1'])){ $orden1=Limpiar_Cadena($_GET['orden1']);}else{ $orden1='';}
			if(isset($_GET['orden2'])){ $orden2=Limpiar_Cadena($_GET['orden2']);}else{ $orden2='';}
			ProcesaQuery("update intranet_organigrama set `orden`='$orden1' where orden='$orden2' and padre='0';");
			ProcesaQuery("update intranet_organigrama set `orden`='$orden2' where `id_seccion`='$id_seccion';");
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Organigrama_Guardar':
			if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
            if(isset($_POST['padre'])){ $padre=Limpiar_Cadena($_POST['padre']);}else{ $padre='';}
            if(isset($_POST['descripcion'])){ $descripcion=$_POST['descripcion'];}else{ $descripcion='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$consulta=ProcesaQuery("select orden from `intranet_organigrama` order by orden Desc limit 1;");
					$row=FetchArray($consulta);
					$orden=$row['orden']+1;
					if (NumRows($consulta)==0)
					$orden=1;

			$ID=InsertQuery("INSERT INTO `intranet_organigrama` ( `id_seccion` , `registro` , `padre`, `nombre`, `descripcion`, `orden`)
			VALUES (NULL , NOW(), '$padre', '$nombre', '$descripcion', '$orden');");
			if ($archivo['name']!=''){
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$ID.'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'organigrama', 'no');
				ProcesaQuery("update `intranet_organigrama` set `imagen`='$file' where id_seccion='$ID'");
				}
			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Organigrama_Listar&padre=$padre&inicio=$inicio");
			exit();
			break;

			case 'Organigrama_Modificar':
			if(isset($_POST['id_seccion'])){ $id_seccion=Limpiar_Cadena($_POST['id_seccion']);}else{ $id_seccion='';}
			if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
            if(isset($_POST['padre'])){ $padre=Limpiar_Cadena($_POST['padre']);}else{ $padre='';}
            if(isset($_POST['descripcion'])){ $descripcion=$_POST['descripcion'];}else{ $descripcion='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$row=FetchArray(ProcesaQuery("select * from `intranet_organigrama` where `id_seccion`='$id_seccion';"));
			ProcesaQuery("update intranet_organigrama set nombre='$nombre', descripcion='$descripcion' where `id_seccion`='$id_seccion'");

				if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../organigrama/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'organigrama', 'no');
					}
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_seccion'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'organigrama', 'no');
				ProcesaQuery("update `intranet_organigrama` set `imagen`='$file' where `id_seccion`='$id_seccion';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Organigrama_Listar&padre=$padre&inicio=$inicio");
			exit();
			break;

			case 'Organigrama_Eliminar':
			if(isset($_GET['id_seccion'])){ $id_seccion=Limpiar_Cadena($_GET['id_seccion']);}else{ $id_seccion='';}
			if(isset($_GET['padre'])){ $padre=Limpiar_Cadena($_GET['padre']);}else{ $padre='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_organigrama` where `id_seccion`='$id_seccion';"));

					$consulta=ProcesaQuery("select orden, id_seccion from `intranet_organigrama` where `orden`>'".$row['orden']."' order by orden ASC;");
					while ($row2=FetchArray($consulta)){
					$ordennuevo=$row2['orden']-1;
					$id=$row2['id_seccion'];
					ProcesaQuery("update `intranet_organigrama` set `orden`='$ordennuevo' where `id_seccion`='$id'");
					}

					if (($row['imagen']!='') and (file_exists('../organigrama/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'organigrama', 'no');
					}

			ProcesaQuery("delete from intranet_organigrama where `id_seccion`='$id_seccion'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Organigrama_Listar&padre=$padre&inicio=$inicio");
			exit();
			break;

			case 'Organigrama_Ordenar':
			if(isset($_GET['id_seccion'])){ $id_seccion=Limpiar_Cadena($_GET['id_seccion']);}else{ $id_seccion='';}
			if(isset($_GET['padre'])){ $padre=Limpiar_Cadena($_GET['padre']);}else{ $padre='';}
			if(isset($_GET['orden1'])){ $orden1=Limpiar_Cadena($_GET['orden1']);}else{ $orden1='';}
			if(isset($_GET['orden2'])){ $orden2=Limpiar_Cadena($_GET['orden2']);}else{ $orden2='';}
			ProcesaQuery("update intranet_organigrama set `orden`='$orden1' where orden='$orden2';");
			ProcesaQuery("update intranet_organigrama set `orden`='$orden2' where `id_seccion`='$id_seccion';");
			header ("Location: admin.php?ver=$ver&opcion=Organigrama_Listar&padre=$padre&inicio=$inicio");
			exit();
			break;
	}
break;

case 'documentos':
	switch ($accion){
			
			
			case 'Guardar':
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
						if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$consulta=ProcesaQuery("select orden from `intranet_documentos_categorias` order by orden Desc limit 1;");
					$row=FetchArray($consulta);
					$orden=$row['orden']+1;
					if (NumRows($consulta)==0)
					$orden=1;

			$ID=InsertQuery("INSERT INTO `intranet_documentos_categorias` ( `id_categoria` , `registro` , `titulo`, `orden`)
			VALUES (NULL , NOW(), '$titulo', '$orden');");

			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
			if(isset($_POST['id_categoria'])){ $id_categoria=Limpiar_Cadena($_POST['id_categoria']);}else{ $id_categoria='';}
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}

			ProcesaQuery("update intranet_documentos_categorias set titulo='$titulo' where `id_categoria`='$id_categoria'");

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_categoria'])){ $id_categoria=Limpiar_Cadena($_GET['id_categoria']);}else{ $id_categoria='';}
			
			if(NumRows(ProcesaQuery("SELECT id_documento from intranet_documentos where id_categoria='$id_categoria';"))>0){ 
			echo '<script type="text/JavaScript">
				  window.alert("Error! No es posible eliminar porque contiene documentos!")
				  </script>';
			echo "<meta http-equiv='refresh' content='0;URL=admin.php?ver=$ver&opcion=Listar&inicio=$inicio'>";
			//header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			}
			
			$row=FetchArray(ProcesaQuery("select * from `intranet_documentos_categorias` where `id_categoria`='$id_categoria';"));

					$consulta=ProcesaQuery("select orden, id_categoria from `intranet_documentos_categorias` where `orden`>'".$row['orden']."' order by orden ASC;");
					while ($row2=FetchArray($consulta)){
					$ordennuevo=$row2['orden']-1;
					$id=$row2['id_documento'];
					ProcesaQuery("update `intranet_documentos_categorias` set `orden`='$ordennuevo' where `id_categoria`='$id'");
					}

			ProcesaQuery("delete from intranet_documentos_categorias where `id_categoria`='$id_categoria'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Ordenar':
			if(isset($_GET['id_categoria'])){ $id_categoria=Limpiar_Cadena($_GET['id_categoria']);}else{ $id_categoria='';}
			if(isset($_GET['orden1'])){ $orden1=Limpiar_Cadena($_GET['orden1']);}else{ $orden1='';}
			if(isset($_GET['orden2'])){ $orden2=Limpiar_Cadena($_GET['orden2']);}else{ $orden2='';}
			ProcesaQuery("update intranet_documentos_categorias set `orden`='$orden1' where orden='$orden2';");
			ProcesaQuery("update intranet_documentos_categorias set `orden`='$orden2' where `id_categoria`='$id_categoria';");
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;
		
			case 'Documentos_Guardar':
			if(isset($_POST['id_categoria'])){ $id_categoria=Limpiar_Cadena($_POST['id_categoria']);}else{ $id_categoria='';}
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['clave'])){ $clave=Limpiar_Cadena($_POST['clave']);}else{ $clave='';}
            if(isset($_POST['formato'])){ $formato=Limpiar_Cadena($_POST['formato']);}else{ $formato='';}
            if(isset($_POST['activo'])){ $activo=Limpiar_Cadena($_POST['activo']);}else{ $activo='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			$consulta=ProcesaQuery("select orden from `intranet_documentos` where id_categoria='$id_categoria' order by orden Desc limit 1;");
					$row=FetchArray($consulta);
					$orden=$row['orden']+1;
					if (NumRows($consulta)==0){ $orden=1;}

			$ID=InsertQuery("INSERT INTO `intranet_documentos` ( `id_documento` , `id_categoria` , `registro` , `titulo`, `clave`, `formato`, `activo`, `orden`)
			VALUES (NULL, '$id_categoria', NOW(), '$titulo', '$clave', '$formato', '$activo', '$orden');");

			$c=ProcesaQuery("select * from intranet_organigrama;");
			while($r=FetchArray($c)){
				if(isset($_POST['seccion'.$r['id_seccion']])){ $x=Limpiar_Cadena($_POST['seccion'.$r['id_seccion']]);} else { $x='';}
				if($x=='1'){ ProcesaQuery("insert into intranet_documentos_secciones (id_documento, id_seccion) VALUES ('$ID', '$r[id_seccion]');"); }
			}

			if ($archivo['name']!=''){
				$fp2 = fopen($archivo["tmp_name"], 'r+b');
				$data2 = fread($fp2, $archivo['size']);
				fclose($fp2);
				// $data2 = mysqli_real_escape_string($data2);

				ProcesaQuery("update `intranet_documentos` set
				`archivo`='$data2',
				`archivo_nombre`='".$archivo['name']."',
				`archivo_tipo`='".$archivo['type']."',
				`archivo_ext`='".substr(strrchr($archivo['name'],"."),1)."',
				`archivo_tamano`='".$archivo['size']."'
				where id_documento='$ID';");
				}
			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Documentos_Listar&id_categoria=$id_categoria&inicio=$inicio");
			exit();
			break;

			case 'Documentos_Modificar':
			if(isset($_POST['id_categoria'])){ $id_categoria=Limpiar_Cadena($_POST['id_categoria']);}else{ $id_categoria='';}
			if(isset($_POST['id_documento'])){ $id_documento=Limpiar_Cadena($_POST['id_documento']);}else{ $id_documento='';}
			if(isset($_POST['titulo'])){ $titulo=Limpiar_Cadena($_POST['titulo']);}else{ $titulo='';}
            if(isset($_POST['clave'])){ $clave=Limpiar_Cadena($_POST['clave']);}else{ $clave='';}
            if(isset($_POST['formato'])){ $formato=Limpiar_Cadena($_POST['formato']);}else{ $formato='';}
            if(isset($_POST['activo'])){ $activo=Limpiar_Cadena($_POST['activo']);}else{ $activo='';}
			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			ProcesaQuery("delete from intranet_documentos_secciones where `id_documento`='$id_documento'");

			$row=FetchArray(ProcesaQuery("select * from `intranet_documentos` where `id_documento`='$id_documento';"));
			ProcesaQuery("update intranet_documentos set titulo='$titulo', clave='$clave', formato='$formato', activo='$activo' where `id_documento`='$id_documento'");

			$c=ProcesaQuery("select * from intranet_organigrama;");
			while($r=FetchArray($c)){
				if(isset($_POST['seccion'.$r['id_seccion']])){ $x=Limpiar_Cadena($_POST['seccion'.$r['id_seccion']]);}else{ $x='';}
				if($x=='1'){ ProcesaQuery("insert into intranet_documentos_secciones (id_documento, id_seccion) VALUES ('$id_documento', '$r[id_seccion]');"); }
			}

			if ($archivo['name']!=''){
								$fp2 = fopen($archivo["tmp_name"], 'r+b');
                $data2 = fread($fp2, $archivo['size']);
                fclose($fp2);
                // $data2 = mysqli_real_escape_string($data2);


				ProcesaQuery("update `intranet_documentos` set
				`archivo`='".$data2."',
				`archivo_nombre`='".$archivo['name']."',
				`archivo_tipo`='".$archivo['type']."',
				`archivo_ext`='".substr(strrchr($archivo['name'],"."),1)."',
				`archivo_tamano`='".$archivo['size']."'
				where id_documento='$id_documento';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&id_categoria=$id_categoria&inicio=$inicio");
			exit();
			break;

			case 'Documentos_Eliminar':
			if(isset($_GET['id_documento'])){ $id_documento=Limpiar_Cadena($_GET['id_documento']);}else{ $id_documento='';}
			if(isset($_GET['id_categoria'])){ $id_categoria=Limpiar_Cadena($_GET['id_categoria']);}else{ $id_categoria='';}
			$row=FetchArray(ProcesaQuery("select * from `intranet_documentos` where `id_documento`='$id_documento' and id_categoria='$id_categoria';"));

					$consulta=ProcesaQuery("select orden, id_documento from `intranet_documentos` where id_categoria='$id_categoria' and `orden`>'".$row['orden']."' order by orden ASC;");
					while ($row2=FetchArray($consulta)){
					$ordennuevo=$row2['orden']-1;
					$id=$row2['id_documento'];
					ProcesaQuery("update `intranet_documentos` set `orden`='$ordennuevo' where `id_documento`='$id'");
					}

			ProcesaQuery("delete from intranet_documentos_secciones where `id_documento`='$id_documento'");
			ProcesaQuery("delete from intranet_documentos where `id_documento`='$id_documento'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&id_categoria=$id_categoria&inicio=$inicio");
			exit();
			break;

			case 'Documentos_Ordenar':
			if(isset($_GET['id_categoria'])){ $id_categoria=Limpiar_Cadena($_GET['id_categoria']);}else{ $id_categoria='';}
			if(isset($_GET['id_documento'])){ $id_documento=Limpiar_Cadena($_GET['id_documento']);}else{ $id_documento='';}
			if(isset($_GET['orden1'])){ $orden1=Limpiar_Cadena($_GET['orden1']);}else{ $orden1='';}
			if(isset($_GET['orden2'])){ $orden2=Limpiar_Cadena($_GET['orden2']);}else{ $orden2='';}
			ProcesaQuery("update intranet_documentos set `orden`='$orden1' where orden='$orden2' and id_categoria='$id_categoria';");
			ProcesaQuery("update intranet_documentos set `orden`='$orden2' where `id_documento`='$id_documento';");
			header ("Location: admin.php?ver=$ver&opcion=Listar&id_categoria=$id_categoria&inicio=$inicio");
			exit();
			break;

			case 'Descargar':
			if(isset($_GET['id_documento'])){ $id_documento=Limpiar_Cadena($_GET['id_documento']);}else{ $id_documento='';}
			$row=FetchArray(ProcesaQuery("select * from intranet_documentos where id_documento='$id_documento';"));
			header("Content-disposition: attachment; filename=".$row['archivo_nombre']);
			header("Content-type: MIME");
			echo $row['archivo'];
			exit();
			break;
			
			
	}
break;

case 'empleados':
	switch ($accion){
			case 'Guardar':
            if(isset($_POST['nroempleado'])){ $nroempleado=Limpiar_Cadena($_POST['nroempleado']);}else{ $nroempleado='';}
            if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
            if(isset($_POST['apellidop'])){ $apellidop=Limpiar_Cadena($_POST['apellidop']);}else{ $apellidop='';}
            if(isset($_POST['apellidom'])){ $apellidom=Limpiar_Cadena($_POST['apellidom']);}else{ $apellidom='';}
			if(isset($_POST['puesto'])){ $puesto=Limpiar_Cadena($_POST['puesto']);}else{ $puesto='';}
			if(isset($_POST['fecha'])){ $fecha=Limpiar_Cadena(fecha_aaaammdd($_POST['fecha']));}else{ $fecha='';}
            if(isset($_POST['id_seccion'])){ $id_seccion=Limpiar_Cadena($_POST['id_seccion']);}else{ $id_seccion='';}
            if(isset($_POST['empleado'])){ $empleado=Limpiar_Cadena($_POST['empleado']);}else{ $empleado='';}
            if(isset($_POST['correo'])){ $correo=Limpiar_Cadena($_POST['correo']);}else{ $correo='';}
            if(isset($_POST['contrasena'])){ $contrasena=Limpiar_Cadena($_POST['contrasena']);}else{ $contrasena='';}
            if(isset($_POST['activo'])){ $activo=Limpiar_Cadena($_POST['activo']);}else{ $activo='';}
            if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}
						if(isset($_FILES['archivo2'])){ $archivo2=$_FILES['archivo2'];}else{ $archivo2='';}



            if(NumRows(ProcesaQuery("select id_empleado from intranet_empleados where correo='$correo'"))>0){
            	echo '<script type="text/JavaScript">
				  window.alert("Error! El correo ya se encuentra registrado!")
				  </script>';
				echo "<meta http-equiv='refresh' content='0;URL=admin.php'>";
				exit();
            }

            		 if($empleado=='1'){ ProcesaQuery("update intranet_empleados set empleado='0';"); }
			$ID=InsertQuery("INSERT INTO `intranet_empleados` ( `id_empleado` , `registro` , `nroempleado`, `nombre`, `apellidop`, `apellidom`, `puesto`, `fecha`, `id_seccion`, `empleado`, `correo`, `contrasena`, `activo`)
			VALUES (NULL , NOW(), '$nroempleado', '$nombre', '$apellidop', '$apellidom', '$puesto', '$fecha', '$id_seccion', '$empleado', '$correo', '".md5($contrasena)."', '$activo');");

        if ($archivo['name']!=''){
				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$ID.'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'empleados', 'no');
				ProcesaQuery("update `intranet_empleados` set `imagen`='$file' where id_empleado='$ID'");
				}

				if ($archivo2['name']!=''){
				$extension='.'.substr(strrchr($archivo2['name'],"."),1);
				$file=$ID.'_archivo_'.date("s").$extension;
				sube_archivo ($archivo2['tmp_name'], $file, 'empleados', 'no');
				ProcesaQuery("update `intranet_empleados` set `archivo`='$file' where id_empleado='$ID'");
				}

			$_SESSION['error']=21;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Modificar':
						if(isset($_POST['id_empleado'])){ $id_empleado=Limpiar_Cadena($_POST['id_empleado']);}else{ $id_empleado='';}
						if(isset($_POST['nroempleado'])){ $nroempleado=Limpiar_Cadena($_POST['nroempleado']);}else{ $nroempleado='';}
            if(isset($_POST['nombre'])){ $nombre=Limpiar_Cadena($_POST['nombre']);}else{ $nombre='';}
            if(isset($_POST['apellidop'])){ $apellidop=Limpiar_Cadena($_POST['apellidop']);}else{ $apellidop='';}
            if(isset($_POST['apellidom'])){ $apellidom=Limpiar_Cadena($_POST['apellidom']);}else{ $apellidom='';}
						if(isset($_POST['puesto'])){ $puesto=Limpiar_Cadena($_POST['puesto']);}else{ $puesto='';}
						if(isset($_POST['fecha'])){ $fecha=Limpiar_Cadena(fecha_aaaammdd($_POST['fecha']));}else{ $fecha='';}
            if(isset($_POST['id_seccion'])){ $id_seccion=Limpiar_Cadena($_POST['id_seccion']);}else{ $id_seccion='';}
            if(isset($_POST['empleado'])){ $empleado=Limpiar_Cadena($_POST['empleado']);}else{ $empleado='';}
            if(isset($_POST['correo'])){ $correo=Limpiar_Cadena($_POST['correo']);}else{ $correo='';}
            if(isset($_POST['contrasena'])){ $contrasena=Limpiar_Cadena($_POST['contrasena']);}else{ $contrasena='';}
            if(isset($_POST['activo'])){ $activo=Limpiar_Cadena($_POST['activo']);}else{ $activo='';}
            if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}
						if(isset($_FILES['archivo2'])){ $archivo2=$_FILES['archivo2'];}else{ $archivo2='';}

            if(NumRows(ProcesaQuery("select id_empleado from intranet_empleados where correo='$correo' and id_empleado<>'$id_empleado'"))>0){
            	echo '<script type="text/JavaScript">
				  window.alert("Error! El correo ya se encuentra registrado!")
				  </script>';
				echo "<meta http-equiv='refresh' content='0;URL=admin.php'>";
				exit();
            }

            if($empleado=='1'){ ProcesaQuery("update intranet_empleados set empleado='0';"); }
			if($contrasena!=''){
			ProcesaQuery("update intranet_empleados set nroempleado='$nroempleado', nombre='$nombre', apellidop='$apellidop', apellidom='$apellidom', puesto='$puesto', fecha='$fecha', id_seccion='$id_seccion', empleado='$empleado', correo='$correo', contrasena='".md5($contrasena)."', activo='$activo' where `id_empleado`='$id_empleado'");
		} else {
			ProcesaQuery("update intranet_empleados set nroempleado='$nroempleado', nombre='$nombre', apellidop='$apellidop', apellidom='$apellidom', puesto='$puesto', fecha='$fecha', id_seccion='$id_seccion', empleado='$empleado', correo='$correo', activo='$activo' where `id_empleado`='$id_empleado'");
		}
            $row=FetchArray(ProcesaQuery("select * from `intranet_empleados` where `id_empleado`='$id_empleado';"));
        if ($archivo['name']!=''){
					if (($row['imagen']!='') and (file_exists('../empleados/'.$row['imagen']))){
						borra_archivo ($row['imagen'], 'empleados', 'no');
					}

				$extension='.'.substr(strrchr($archivo['name'],"."),1);
				$file=$row['id_empleado'].'_imagen_'.date("s").$extension;
				sube_archivo ($archivo['tmp_name'], $file, 'empleados', 'no');
				ProcesaQuery("update `intranet_empleados` set `imagen`='$file' where `id_empleado`='$id_empleado';");
				}

				if ($archivo2['name']!=''){
					if (($row['archivo']!='') and (file_exists('../empleados/'.$row['archivo']))){
						borra_archivo ($row['archivo'], 'empleados', 'no');
					}

				$extension='.'.substr(strrchr($archivo2['name'],"."),1);
				$file=$row['id_empleado'].'_archivo_'.date("s").$extension;
				sube_archivo ($archivo2['tmp_name'], $file, 'empleados', 'no');
				ProcesaQuery("update `intranet_empleados` set `imagen`='$file' where `id_empleado`='$id_empleado';");
				}

			$_SESSION['error']=19;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Eliminar':
			if(isset($_GET['id_empleado'])){ $id_empleado=Limpiar_Cadena($_GET['id_empleado']);}else{ $id_empleado='';}

            $row=FetchArray(ProcesaQuery("select * from `intranet_empleados` where `id_empleado`='$id_empleado';"));
            if (($row['imagen']!='') and (file_exists('../empleados/'.$row['imagen']))){
                borra_archivo ($row['imagen'], 'empleados', 'no');
            }

			ProcesaQuery("delete from intranet_empleados where `id_empleado`='$id_empleado'");
			$_SESSION['error']=20;
			header ("Location: admin.php?ver=$ver&opcion=Listar&inicio=$inicio");
			exit();
			break;

			case 'Descargar_Excel':
				require_once 'Excel/PHPExcel.php';
				$objPHPExcel = new PHPExcel();

				// Set document properties
				$objPHPExcel->getProperties()->setCreator("CIRT Colegio Israelita")
											 ->setLastModifiedBy("Maarten Balliauw")
											 ->setTitle("Office 2007 XLSX Test Document")
											 ->setSubject("Office 2007 XLSX Test Document")
											 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
											 ->setKeywords("office 2007 openxml php")
											 ->setCategory("Test result file");

				$objPHPExcel->createSheet(0);
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setTitle('Productos');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A1' , 'NROEMPLEADO');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B1' , 'NOMBRE');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C1' , 'APELLIDO PATERNO');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D1' , 'APELLIDO MATERNO');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E1' , 'PUESTO');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F1' , 'FECHA NACIMIENTO');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G1' , 'CLAVE SECCION');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H1' , 'EMPLEADO DEL MES');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I1' , 'CORREO');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'J1' , 'CONTRASENA');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'K1' , 'ACTIVO');
				$con=ProcesaQuery("select * from intranet_empleados order by RAND() limit 2;");
				$i=1;
			/*	while ($row=FetchArray($con)){
					$i++;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$i , $row['nroempleado']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'.$i , $row['nombre']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'.$i , $row['apellidop']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D'.$i , $row['apellidom']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.$i , $row['puesto']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'.$i , fecha_ddmmaaaa($row['fecha']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G'.$i , $row['id_seccion']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H'.$i , $row['empleado']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I'.$i , $row['correo']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'J'.$i , 'XXXXX');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'K'.$i , $row['activo']);
				}*/
				$i++;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$i , '214');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'.$i , 'Juan');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'.$i , 'Perez');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D'.$i , 'Ejemplo');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.$i , 'Ejecutivo');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'.$i , date("d-m-Y"));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G'.$i , '7');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H'.$i , '0');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I'.$i , 'elcorreo1@dominio.com');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'J'.$i , 'XXXXX');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'K'.$i , '1');
				$objPHPExcel->setActiveSheetIndex(0);
				$i++;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$i , '215');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B'.$i , 'Roberto');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C'.$i , 'Fulano');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D'.$i , 'Sultano');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.$i , 'Soporte');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'.$i , date("d-m-Y"));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G'.$i , '45');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H'.$i , '0');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I'.$i , 'elcorreo2@dominio.com');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'J'.$i , 'XXXXX');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'K'.$i , '1');
				$objPHPExcel->setActiveSheetIndex(0);

				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="archivo_empleado_ejemplo.xls"');
				header('Cache-Control: max-age=0');
				header('Cache-Control: max-age=1');
				header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
				header ('Cache-Control: cache, must-revalidate');
				header ('Pragma: public');
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');

		break;

		case 'Cargar_Excel':


			if(isset($_FILES['archivo'])){ $archivo=$_FILES['archivo'];}else{ $archivo='';}

			if ($archivo['tmp_name']!=''){
			require_once 'Excel/reader.php';
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($archivo['tmp_name']);
			//ProcesaQuery("TRUNCATE table intranet_empleados;");

			$hoja=0;
			$insertados=0; $errorx=0; $aux='';
			for ($xx = 2; $xx <= $data->sheets[$hoja]['numRows']; $xx++) {
			$nroempleado=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][1]);
			$nombre=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][2]);
			$apellidop=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][3]);
			$apellidom=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][4]);
			$puesto=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][5]);
			$fecha=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][6]);
			$id_seccion=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][7]);
			$empleado=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][8]);
			$correo=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][9]);
			$contrasena=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][10]);
			$activo=Limpiar_Cadena($data->sheets[$hoja]['cells'][$xx][11]);





					if (($correo!='') and ($contrasena!='') and ($nombre!='')){

						if(NumRows(ProcesaQuery("SELECT id_empleado FROM intranet_empleados WHERE correo='$correo';"))=='0'){
											ProcesaQuery("INSERT INTO `intranet_empleados` ( `id_empleado` , `registro` , `nroempleado`, `nombre`, `apellidop`, `apellidom`, `puesto`, `fecha`, `id_seccion`, `empleado`, `correo`, `contrasena`, `activo`)
							VALUES (NULL , NOW(), '$nroempleado', '$nombre', '$apellidop', '$apellidom', '$puesto', '".fecha_aaaammdd($fecha)."', '$id_seccion', '$empleado', '$correo', '".md5($contrasena)."', '$activo');");
											$insertados++;
						} else {
											$aux.="- [$nroempleado] $correo (El correo ya esta registrado)";
											$errorx++;
						}
					}
			}

			$_SESSION['error']=19;
			echo '<script type="text/JavaScript">
				window.alert("Reporte Insertados: '.$insertados.', Errores: '.$errorx.'\n'.$aux.'");
				</script>';
			echo "<meta http-equiv='refresh' content='0;URL=admin.php?ver=$ver'>";
			exit();
			}
		break;
	}
break;

}
header ("Location: admin.php?ver=$ver&inicio=$inicio");
exit();
