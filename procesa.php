<?php
session_name('usuario_empleado_servnet');
session_start();
include ("admin/functions/config.php");
include ("admin/functions/conect.php");

if(isset($_GET['ver'])){ $ver=Limpiar_Cadena($_GET['ver']);} else { if(isset($_POST['ver'])){ $ver=Limpiar_Cadena($_POST['ver']);} else { $ver='';}}
if(isset($_GET['accion'])){ $accion=Limpiar_Cadena($_GET['accion']);} else { if(isset($_POST['accion'])){ $accion=Limpiar_Cadena($_POST['accion']);} else { $accion='';}}
if(isset($_GET['token'])){ $token=Limpiar_Cadena($_GET['token']);} else { if(isset($_POST['token'])){ $token=Limpiar_Cadena($_POST['token']);} else { $token='';}}
if(isset($_GET['id'])){ $id=Limpiar_Cadena($_GET['id']);} else { if(isset($_POST['id'])){ $id=Limpiar_Cadena($_POST['id']);} else { $id='';}}

switch ($ver){
  case 'sesion':
    switch($accion){
      case 'login':
       
        
        if(isset($_POST['usuario'])){ $usuario=Limpiar_Cadena($_POST['usuario']);} else { $usuario='';}
        if(isset($_POST['contrasena'])){ $contrasena=Limpiar_Cadena($_POST['contrasena']);} else { $contrasena='';}


        
        
        if($token!=md5($_SESSION['empleado_login']) or $token==''){
          $error='Favor de ingresar los datos correctamente';
          header("Location: login.php?error=$error");
          exit();
        }
        
        $query="SELECT * from intranet_empleados where username='$usuario' and activo='1' and eliminado='0';";
      
        $consulta=ProcesaQuery($query);
        
        if(NumRows($consulta)==0){
          $error='El Usuario no se encuentra registrado.';
          header("Location: login.php?error=$error");
          exit();
        }
        $row=FetchArray($consulta);
    
        if($row['contrasena']!=md5($contrasena)){
          $error='La contraseña no es correcta.';
          header("Location: login.php?error=$error");
          exit();
        }
        unset($_SESSION['empleado_login']);
		
        $_SESSION['usuario_id']=$row['id_empleado'];
        $_SESSION['usuario_nombre']=$row['nombre'].' '.$row['apellidop'].' '.$row['apellidom'];
        $_SESSION['usuario_correo']=$row['correo'];
        $_SESSION['usuario_nroempleado']=$row['nroempleado'];
        $_SESSION['usuario_seccion']=$row['id_seccion'];
		    ProcesaQuery("insert into intranet_empleados_log (id_empleado, tipo) VALUES ('".$_SESSION['usuario_id']."','1');");
        header("Location: index.php");
        exit();
      break;

      case 'logout':
		    ProcesaQuery("insert into intranet_empleados_log (id_empleado, tipo) VALUES ('".$_SESSION['usuario_id']."','0');");
        session_destroy();
        header("Location: index.php");
        exit();
      break;

      case 'cambiar':
        if(isset($_POST['contrasena1'])){ $contrasena1=Limpiar_Cadena($_POST['contrasena1']);} else { $contrasena1='';}
        if(isset($_POST['contrasena2'])){ $contrasena2=Limpiar_Cadena($_POST['contrasena2']);} else { $contrasena2='';}
        if(isset($_POST['contrasena3'])){ $contrasena3=Limpiar_Cadena($_POST['contrasena3']);} else { $contrasena3='';}

        $row=FetchArray(ProcesaQuery("SELECT contrasena from intranet_empleados WHERE id_empleado='".$_SESSION['usuario_id']."';"));

       
        if($token!=md5($_SESSION['empleado_contrasena']) or $token==''){
          $error='Favor de ingresar los datos correctamente';
          header("Location: index.php?ver=cambiar_contrasena&mensaje=$error");
          exit();
        }

        if ($row['contrasena']!=md5($contrasena1)){
          $error='La contraseña actual no es correcta.';
          header("Location: index.php?ver=cambiar_contrasena&mensaje=$error");
          exit();
        }

        if ($contrasena2!=$contrasena3){
          $error='Las contraseñas no coinciden.';
          header("Location: index.php?ver=cambiar_contrasena&mensaje=$error");
          exit();
        }
        unset($_SESSION['empleado_contrasena']);

       
        ProcesaQuery("UPDATE contrasena set password='$contrasena2' WHERE id_empleado='".$_SESSION['usuario_id']."';");
        header("Location: index.php?ver=cambiar_contrasena&mensaje=Se ha cambiado la contraseña correctamente!");
        exit();
      break;

      case 'recuperar':
          if(isset($_POST['correo'])){ $correo=Limpiar_Cadena($_POST['correo']);} else { $correo='';}

          if($token!=md5($_SESSION['empleado_recuperar']) or $token==''){
            $error='Favor de ingresar los datos correctamente.';
            header("Location: recuperar.php?error=$error");
            exit();
          }

          $con=ProcesaQuery("SELECT id_empleado, correo, CONCAT(nombre,' ',apellidop,' ',apellidom) as nombre FROM intranet_empleados WHERE correo='$correo';");
          if(NumRows($con)==0){
            $error='El usuario no se encuentra registrado.';
            header("Location: recuperar.php?error=$error");
            exit();
          }
          $row=FetchArray($con);
          unset($_SESSION['empleado_recuperar']);
          //ENVIAR CORREO ELECTRONICO
          $nueva_contrasena=rand(9999,99999);
          ProcesaQuery("UPDATE intranet_empleados SET contrasena='".md5($nueva_contrasena)."' WHERE correo='$correo';");
				include('admin/includes/class.phpmailer.php');
				$Email= new PHPMailer();
				$Email->IsSMTP();
				$Email->From = 'contacto@servnet.mx';
				$Email->FromName = 'Contacto Intranet';
				$Email->AddAddress($row['correo']);
				$Email->Subject="Recuperar Contraseña";
				$Email->IsHTML(true);
				$Email->Body='<!DOCTYPE HTML><html>
			<head>
			<meta charset="utf-8">
			</head>
			<body bgcolor="#FFFFFF">
			<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="25"  >&nbsp;</td>
				<td ><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top; font-family: arial; font-size: 12px; color: #7a7a7a; ">
					<tr>
					  <td><div style="left: 0;padding: 12px;width: 190px;"><img src="'.$_SESSION['intranet_logotipo'].'" width="160"></div></td>
					  <td>&nbsp;</td>
					  <td ><h1 style="color:#999; font:normal normal 24px/1.2 Arial, Helvetica, sans-serif">Intranet</h1></td>
					</tr>
					<tr>
					  <td colspan="3">&nbsp;</td>
					</tr>
				  </table></td>
				<td width="25"  >&nbsp;</td>
			  </tr>
			  <tr>
				<td  >&nbsp;</td>
				<td ><table width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#7a7a7a; line-height:1.4;">
					<tr>
					  <td>&nbsp;</td>
						<td> <h2  style="line-height:1.2; color:#000;"><br>
						Recuperar Contraseña Intranet</h2>
							<p>Los datos para acceder son los siguientes: </p><br>
						</td>
					  <td>&nbsp;</td>
					</tr>
					<tr style="height:300px; vertical-align:top;">
						<td>&nbsp;</td>
						<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left; color:#666;">
						  <tr>
							       <th scope="row">Nombre:</th>
							              <td>'.$r['nombre'].'</td>
						  </tr>
						  <tr>
							       <th scope="row">Correo electrónico</th>
							              <td>'.$r['correo'].'</td>
						  </tr>
              <tr>
							       <th scope="row">Contraseña</th>
							              <td>'.$nueva_contrasena.'</td>
						  </tr>
						  </table>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td>Saluda Atte.<br><strong>
            '.$_SESSION['intranet_nombre'].'</strong></br>'.
            $_SESSION['intranet_direccion'].'</br>'.
        		$_SESSION['intranet_correo'].'</br>'.
        		$_SESSION['intranet_telefono'].'</br></td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
						<td>&nbsp;</td>
						<td><br></td>
						<td>&nbsp;</td>
					</tr>
				  </table></td>
				<td  >&nbsp;</td>
			  </tr>
			  <tr>
				<td align="center"  >&nbsp;</td>
				<td align="center"  >&nbsp;</td>
				<td align="center"  >&nbsp;</td>
			  </tr>
			  <tr>
				<td align="center"  >&nbsp;</td>
				<td style="font-family:Arial, Helvetica, sans-serif; font-size:11px;color:#7a7a7a; line-height:1.4;">
							<p>La información transmitida está destinada solo a la persona que se dirige este material o contenido el cual es confidencial. Cualquier modificación, difusión u otro uso en base a esta información por personas o entidades distintas al destinatario está prohibido. Si recibió este correo por error, favor de contactar al remitente y eliminar el material re su equipo de cómputo.</p>
						</td>
				<td align="center"  >&nbsp;</td>
			  </tr>
			</table>
			</body>
			</html>';
				$Email->Send();
				$Email->ClearAddresses();

          $error='Se ha enviado un mail a tu correo electrónico con tu nueva contraseña.';
          header("Location: login.php?error=$error");
          exit();
      break;

      case 'sugerencia':
      if(isset($_POST['correo'])){ $correo=Limpiar_Cadena($_POST['correo']);} else { $correo='';}
      if(isset($_POST['comentarios'])){ $comentarios=Limpiar_Cadena($_POST['comentarios']);} else { $comentarios='';}

      if($token!=md5($_SESSION['empleado_sugerencia']) or $token==''){
        echo '<script type="text/JavaScript">
				  window.alert("Favor de ingresar los datos correctamente.")
				  </script>';
				echo "<meta http-equiv='refresh' content='0;URL=".URL_HTTP."index.php'>";
				exit();
      }

      unset($_SESSION['empleado_sugerencia']);
      ProcesaQuery("INSERT INTO intranet_sugerencias (id_sugerencia, registro, nombre, correo, comentario) VALUES (NULL, NOW(), '$nombre', '$correo', '$comentarios')");
      include('admin/includes/class.phpmailer.php');
      $Email= new PHPMailer();
      $Email->IsSMTP();
      $Email->From = 'contacto@servnet.mx';
      $Email->FromName = 'Contacto Intranet';
      $Email->AddAddress(CORREO_ENVIO);
      $Email->Subject="Sugerencia Intranet";
      $Email->IsHTML(true);
      $Email->Body='<!DOCTYPE HTML><html>
    <head>
    <meta charset="utf-8">
    </head>
    <body bgcolor="#FFFFFF">
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
      <td width="25"  >&nbsp;</td>
      <td ><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top; font-family: arial; font-size: 12px; color: #7a7a7a; ">
        <tr>
          <td><div style="left: 0;padding: 12px;width: 190px;"><img src="'.$_SESSION['intranet_logotipo'].'" width="160"></div></td>
          <td>&nbsp;</td>
          <td ><h1 style="color:#999; font:normal normal 24px/1.2 Arial, Helvetica, sans-serif">Intranet</h1></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        </table></td>
      <td width="25"  >&nbsp;</td>
      </tr>
      <tr>
      <td  >&nbsp;</td>
      <td ><table width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#7a7a7a; line-height:1.4;">
        <tr>
          <td>&nbsp;</td>
          <td> <h2  style="line-height:1.2; color:#000;"><br>Formato de Asesoría</h2>
            <p>Se han registrado los siguientes datos: </p><br>
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr style="height:300px; vertical-align:top;">
          <td>&nbsp;</td>
          <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left; color:#666;">
            <tr>
            <th scope="row">Nombre:</th>
            <td>'.$_SESSION['usuario_nombre'].'</td>
            </tr>
            <tr>
            <th scope="row">Correo electrónico</th>
            <td>'.$correo.'</td>
            </tr>
            <tr>
            <th scope="row">Comentarios:</th>
            <td>'.nl2br($comentarios).'</td>
            </tr>
            <tr>
            <th scope="row">&nbsp;</th>
            <td>&nbsp;</td>
            </tr>
          </table>

          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Saluda Atte.<br><strong>
          '.$_SESSION['intranet_nombre'].'</strong></br>'.
          $_SESSION['intranet_direccion'].'</br>'.
          $_SESSION['intranet_correo'].'</br>'.
          $_SESSION['intranet_telefono'].'</br></td>
          <td>&nbsp;</td>
        </tr>
        </table></td>
      <td  >&nbsp;</td>
      </tr>
      <tr>
      <td align="center"  >&nbsp;</td>
      <td align="center"  >&nbsp;</td>
      <td align="center"  >&nbsp;</td>
      </tr>
      <tr>
      <td align="center"  >&nbsp;</td>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:11px;color:#7a7a7a; line-height:1.4;">
            <p>La información transmitida está destinada solo a la persona que se dirige este material o contenido el cual es confidencial. Cualquier modificación, difusión u otro uso en base a esta información por personas o entidades distintas al destinatario está prohibido. Si recibió este correo por error, favor de contactar al remitente y eliminar el material re su equipo de cómputo.</p>
          </td>
      <td align="center"  >&nbsp;</td>
      </tr>
    </table>
    </body>
    </html>';
      $Email->Send();
      $Email->ClearAddresses();

      echo '<script type="text/JavaScript">
        window.alert("Se han enviado los datos correctamente.")
        </script>';
      echo "<meta http-equiv='refresh' content='0;URL=".URL_HTTP."index.php'>";
      exit();

      break;

      case 'descargar':
        $row=FetchArray(ProcesaQuery("SELECT A.* from intranet_documentos A
        JOIN intranet_documentos_secciones C ON C.id_documento=A.id_documento
        WHERE A.id_documento='$id' and C.id_seccion='".$_SESSION['usuario_seccion']."';"));
        if($row['id_documento']!=''){
          header("Content-disposition: attachment; filename=".$row['archivo_nombre']);
          header("Content-type: MIME");
          echo $row['archivo'];
          exit();
        }
      break;
    }
  break;
}
header("Location: index.php?ver=$ver");
exit();
?>
