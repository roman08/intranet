<?php

function Limpiar_Cadena($valor){
$valor = @iconv('UTF-8','ISO-8859-1//TRANSLIT', $valor);

$vowels = array("SELECT", "COPY", "DELETE", "DROP", "DUMP", " OR ", "%", "LIKE", "^", "[","]","!","�","?","=","'",'"',"&","\\");
$valor = str_ireplace($vowels, "", $valor);
//$valor = str_ireplace("�","&aacute;",$valor);
//$valor=utf8_encode($valor);
$valor=htmlspecialchars(trim(utf8_encode($valor)), ENT_QUOTES);
return $valor;


//$valor = addslashes($valor);
//$valor=utf8_encode(htmlspecialchars(trim($valor), ENT_QUOTES));
//$valor=htmlentities($valor, ENT_QUOTES,'UTF-8');
}

function Estilos_Colores(){
		$r=FetchArray(ProcesaQuery("SELECT * FROM intranet_header_menu_footer where id='1';"));
		$estilos= '<style>
		.header_background { background-color:'.$r['color11'].';}
		#secAzul { color:'.$r['color12'].';}
		#secAzul a { color:'.$r['color12'].';}
		#secAzul a:hover { color:'.$r['color13'].';}
		#secAzul button { color:'.$r['color14'].';}

		.menu_background { background-color:'.$r['color21'].';}
		.menu_texto { color:'.$r['color23'].';}
		.menu_texto_over { color:'.$r['color24'].';}
		.menu_texto_subnivel_moviles { color:'.$r['color25'].';}
		nav#navPrincipal {  background-color:'.$r['color21'].';}
		.dl-menuwrapper li a{ background-color:'.$r['color21'].'; color:'.$r['color23'].';}
		.dl-menuwrapper li a:hover{ background-color:'.$r['color22'].'; color:'.$r['color24'].';}

		@media (max-width: 991px) and (min-width: 280px){
		.dl-menuwrapper button:hover, .dl-menuwrapper button.dl-active, .dl-menuwrapper ul { background-color:'.$r['color22'].';}
		.dl-menuwrapper button { background-color:'.$r['color21'].';}
	  }

		footer#footerIndex{ background-color:'.$r['color31'].';}
		.menu_texto { color:'.$r['color32'].';}
		.menu_texto_over { color:'.$r['color33'].';}
		#direccion p{ color:'.$r['color32'].';}
		#direccion a{ color:'.$r['color32'].';}
		#direccion a:hover{color: '.$r['color33'].';}
		#redesSociales a#avisoLink{ color:'.$r['color32'].';}
		#redesSociales a#avisoLink:hover{ color: '.$r['color33'].';}
		</style>';

		if($r['imagen']!='' and file_exists('img/'.$r['imagen'])) {
			$_SESSION['intranet_logotipo']= URL_HTTP.'img/'.$r['imagen'];
		} else {
			$_SESSION['intranet_logotipo']= URL_HTTP.'img/logotipo-Servnet.png';
		}
		$_SESSION['intranet_nombre']= $r['nombre'];
		$_SESSION['intranet_direccion']= $r['direccion'];
		$_SESSION['intranet_correo']= $r['correo'];
		$_SESSION['intranet_telefono']= $r['telefono'];
		return $estilos;
}

function Valida_Sesion(){
if (($_SESSION['usuario_id']!='') and isset($_SESSION['usuario_id'])){ return TRUE; } else { return FALSE;}
}

function Desplegar_Error(){
	if($_SESSION['mensaje_error']!=''){
	echo '<div class="backerror""><div class="container"><div class="col-xs-12 titulo-error"><h2>'.$_SESSION['mensaje_error'].'</h2></div></div></div>';
	unset($_SESSION['mensaje_error']);
	}
}

function quitar_comas($x){
	$y=str_replace(',','',$x);
	return $y;
}

function calcular_IVA($p) {
return formatea_num($p*0.16);
}
function Get_sku($id){
$r= FetchArray(ProcesaQuery("select sku from intranet_productos where id_producto='$id';"));
return $r[0];
	}


function valida_seccion($ver='0', $id){
//echo "select a.ver from isla_secciones a, isla_usuarios_seccion b where a.ver='$ver' and a.id_seccion=b.id_seccion and b.id_usuario='$id';";
if (($ver!='0') and (NumRows(ProcesaQuery("select a.ver from intranet_secciones a, intranet_usuarios_seccion b where a.ver='$ver' and a.id_seccion=b.id_seccion and b.id_usuario='$id';"))>0))
$r=true;
else
$r=false;
return $r;
}


function mostrar_seccion($seccion, $lugar){
switch ($lugar){
case 'abajo':
$r= FetchArray(ProcesaQuery("select * from intranet_secciones where seccion='$seccion';"));
$mostrar=$r['texto'];
if (($r['imagen']!='') and file_exists('banners/'.$r['imagen']))
$mostrar.='<br /><img src="banners/'.$r['imagen'].'"/><br /><br />';
break;

case 'arriba':
$r= FetchArray(ProcesaQuery("select * from intranet_secciones where seccion='$seccion';"));
if (($r['imagen']!='') and file_exists('banners/'.$r['imagen']))
$mostrar='<br /><img src="banners/'.$r['imagen'].'"/><br />';
$mostrar.=$r['texto'];
break;
}
return $mostrar;
}





function my_strip_tags($str) {
    $strs=explode('<',$str);
    $res=$strs[0];
    for($i=1;$i<count($strs);$i++) {
        if(!strpos($strs[$i],'>'))
            $res = $res.'&lt;'.$strs[$i];
        else
            $res = $res.'<'.$strs[$i];
    }
    return strip_tags($res);
}

function properText($str){
    $str = mb_convert_encoding($str, "HTML-ENTITIES", "UTF-8");
    $str = preg_replace('[a-zA-Z áéíóúÁÉÍÓÚñÑ.]',htmlentities('${1}'),$str);
    return($str); 
}

function Abrebiar($texto, $carateres) {
	$imp='';
	$char=my_strip_tags($texto);
	$char = properText($char);
	$i=0;

	
	$imp.= $char;
	if (strlen($texto)>$carateres){
		$imp = '';
		$textoCorto = substr($char, 0,$carateres);
		$imp.= $textoCorto . '...';
	}
return ucfirst(strtolower($imp)) ;
}





function imprimir_banner ($titulo,$tipo,$liga,$target,$imagen,$x,$y) {
if ((file_exists($imagen)) and ($imagen!='')){
if ($tipo=='IMAGEN')	{
if ($liga!='')
echo '<a href="'.$liga.'" target="'.$target.'"><img src="'.$imagen.'" border="0" width="'.$x.'" height="'.$y.'" alt="'.$titulo.'"></a>';
else
echo '<img src="'.$imagen.'" border="0">';
} else {
echo "<script type='text/javascript'>
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','".$x."','height','".$y."','src','".$imagen."','quality', 'high','pluginspage', 'http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash', 'movie', '".$imagen."' );
</script>";
}}
}



function Conectarse()
{
//global HOST, DBUSER, DBPASSWORD, DBNAME;
   if (!($link=mysqli_connect(HOST,DBUSER,DBPASSWORD)))
   {
      echo "Error conectando a la base de datos1.";
      exit();
   }

   if (!$link->select_db(DBNAME))
   {
      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}

function ProcesaQuery($sql) {
		$link=Conectarse();
        $result = $link->query("$sql");

        if (!$result) {
        echo '<script type="text/JavaScript">window.alert("ERROR:\n '. mysqli_error($link).'\n\n Volver a Intentar")</script>';
				//echo "<meta http-equiv='refresh' content='0;URL=menu.php?ver=$ver&dentro=$dentro'>";
				exit ();
        }
         $link->close();

        return $result;
}

function InsertQuery($sql) {
		$link=Conectarse();
		if (! ($link->query($sql))){
        echo '<script type="text/JavaScript">window.alert("ERROR:\n '. mysqli_error($link).'\n\n Volver a Intentar")</script>';
		exit ();
        }
		$ultimo_id = mysqli_insert_id($link);
		$link->close();
        return $ultimo_id;
}

function FetchArray($result){
	// return $result->fetch_row();
	return mysqli_fetch_array ($result);
}

function NumRows($result){
	return mysqli_num_rows($result);
}

 function formatea_num($num){
      $num = number_format($num,2,'.',',');
             return $num;
   }

    function formatea_num2($num){
      $num = number_format($num,2,'.','');
             return $num;
   }



function divide_fecha($fecha){
          $ano=  substr("$fecha",0,4);
          $mes=  substr("$fecha",5,2);
          $dia=  substr("$fecha",8,2);
return $fecha="$dia-$mes-$ano";
}



function invierte_fecha($fecha){
          $dia=  substr("$fecha",0,2);
          $mes=  substr("$fecha",3,2);
         $ano=  substr("$fecha",6,4);
		 $fecha="$ano-$mes-$dia";
return $fecha;
}

function fecha_ddmmaaaa($fecha){
          $ano=  substr("$fecha",0,4);
          $mes=  substr("$fecha",5,2);
          $dia=  substr("$fecha",8,2);
return $fecha="$dia-$mes-$ano";}



function fecha_ddmmaaaahhmmss($fecha){
          $ano=  substr("$fecha",0,4);
          $mes=  substr("$fecha",5,2);
          $dia=  substr("$fecha",8,2);
		  $hora=  substr("$fecha",11,2);
		  $min=  substr("$fecha",14,2);
		  $seg=  substr("$fecha",17,2);
if($dia!='')
return $fecha="$dia-$mes-$ano $hora:$min:$seg";
else
return $fecha="";
}



function fecha_aaaammdd($fecha){
          $dia=  substr("$fecha",0,2);
          $mes=  substr("$fecha",3,2);
         $ano=  substr("$fecha",6,4);
		 $fecha="$ano-$mes-$dia";
return $fecha;
}



function mensaje($texto,$link_aceptar,$link_cerrar){
echo"<br>

<br>

<table border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#000000'>

  <tr>

    <td bgcolor='#FFFFFF'>

	<table width='100%' border='0' cellpadding='0' cellspacing='1'>

        <tr>

          <td bgcolor='#333366' width='306'>

            <table border='0' cellspacing='0' cellpadding='5' width='305'>

              <tr>

                <td width='279'><font color='#FFFFFF' size='2' face='Arial, Helvetica, sans-serif'><b>Error

                  - Mensaje</b></font></td>

              </tr>

            </table>

          </td>

        </tr>

        <tr>

          <td bgcolor='#A0A0A0' width='306'>

            <table width='100%' border='0' cellspacing='0' cellpadding='8'>

              <tr>

                <td><font size='2' face='Arial, Helvetica, sans-serif' color='#FFFFFF'><b>$texto </b></font></td>

              </tr>

              <tr>

                <td height='50' align='center'><input type='button' name='button' id='button' value='Volver a Intentar' onClick='history.go(-1);'></td>

              </tr>

            </table>

          </td>

        </tr>

      </table>

    </td>

  </tr>

</table>";

}



function sube_foto ($fuente, $destino, $carpeta, $carpeta1){

//global DOMINIO, FTP_USER, FTP_PASSWORD;

$conn_id = ftp_connect(DOMINIO);
$login_result = ftp_login($conn_id, FTP_USER, FTP_PASSWORD);
ftp_chdir($conn_id, 'intranet');
if ($carpeta1!='no')
ftp_chdir($conn_id, $carpeta1);

@ftp_chmod($conn_id, 0777, $carpeta);
ftp_chdir($conn_id, $carpeta);

$upload = ftp_put($conn_id, $destino, $fuente, FTP_BINARY);



switch (strtolower(substr(strrchr($destino,"."),1))){
case 'gif': $original = imagecreatefromgif("../".$carpeta."/".$destino); break;
case 'jpg': $original = imagecreatefromjpeg("../".$carpeta."/".$destino);  break;
case 'png': $original = imagecreatefrompng("../".$carpeta."/".$destino); break;
case 'bmp': $original = imagecreatefromwbmp("../".$carpeta."/".$destino); break;
}

//$original = imagecreatefromjpeg("../".$carpeta."/".$destino);

$ancho = imagesx($original);
$alto = imagesy($original);

if ($ancho>=$alto){

if ($ancho<640){
$alto2=$alto;
$ancho2=$ancho;
} else {
$a=650;
$alto2=$a;
$ancho2=488;
while ($alto2 > 480){
$a=$a-10;
$alto2=$alto/($ancho/$a);
$ancho2=$a;
}
}

} else {

if ($alto<480){
$alto2=$alto;
$ancho2=$ancho;
}
else{
$alto2=653;
$ancho2=$ancho/($alto/$alto2);
$a=$ancho2;
while ($ancho2>640){
$a=$a-10;
$ancho2=$ancho/($alto/$a);
$alto2=$a;
}
}

}
$thumb = imagecreatetruecolor($ancho2,$alto2); // Lo haremos de un tama�o 150x150
imagecopyresampled($thumb,$original,0,0,0,0,$ancho2,$alto2,$ancho,$alto);
//Por �ltimo, guardamos la imagen en disco:



switch (strtolower(substr(strrchr($destino,"."),1))){
case 'gif': imagegif($thumb,"../".$carpeta."/".'t_'.$destino,90); break;
case 'jpg': imagejpeg($thumb,"../".$carpeta."/".'t_'.$destino,90);  break;
case 'png': imagepng($thumb,"../".$carpeta."/".'t_'.$destino,90); break;
case 'bmp': imagewbmp($thumb,"../".$carpeta."/".'t_'.$destino,90); break;
}

//imagejpeg($thumb,"../".$carpeta."/".'t_'.$destino,90);
ftp_delete($conn_id, $destino);
ftp_cdup ($conn_id);
@ftp_chmod($conn_id, 0755, $carpeta);
ftp_close($conn_id);
}


function sube_archivo ($fuente, $destino, $carpeta, $carpeta1){
//global DOMINIO, FTP_USER, FTP_PASSWORD;
$conn_id = ftp_connect(DOMINIO,21);
$login_result = ftp_login($conn_id, FTP_USER, FTP_PASSWORD);
ftp_chdir($conn_id, 'intranetdirsa');
if ($carpeta1!='no')
ftp_chdir($conn_id, $carpeta1);
ftp_chdir($conn_id, $carpeta);
$upload = ftp_put($conn_id, $destino, $fuente, FTP_BINARY);
ftp_close($conn_id);

}

function borra_archivo ($destino, $carpeta, $carpeta1){
//global DOMINIO, FTP_USER, FTP_PASSWORD;
$conn_id = ftp_connect(DOMINIO);
$login_result = ftp_login($conn_id, FTP_USER, FTP_PASSWORD);
ftp_chdir($conn_id, 'intranet');
if ($carpeta1!='no')
ftp_chdir($conn_id, $carpeta1);
ftp_chdir($conn_id, $carpeta);
ftp_delete($conn_id, $destino);
ftp_close($conn_id);
}

function LaFecha($FechaStamp){
$ano = date('Y',$FechaStamp);
$mes = date('m',$FechaStamp);
$dia = date('d',$FechaStamp);
$dialetra = date('w',$FechaStamp);
switch($dialetra){
case 0: $dialetra="Domingo"; break;
case 1: $dialetra="Lunes"; break;
case 2: $dialetra="Martes"; break;
case 3: $dialetra="Mi�rcoles"; break;
case 4: $dialetra="Jueves"; break;
case 5: $dialetra="Viernes"; break;
case 6: $dialetra="S�bado"; break;
}

switch($mes) {
case '01': $mesletra="Enero"; break;
case '02': $mesletra="Febrero"; break;
case '03': $mesletra="Marzo"; break;
case '04': $mesletra="Abril"; break;
case '05': $mesletra="Mayo"; break;
case '06': $mesletra="Junio"; break;
case '07': $mesletra="Julio"; break;
case '08': $mesletra="Agosto"; break;
case '09': $mesletra="Septiembre"; break;
case '10': $mesletra="Octubre"; break;
case '11': $mesletra="Noviembre"; break;
case '12': $mesletra="Diciembre"; break;
}
return "$dia de $mesletra de $ano";
}



/*function enviar_correo($contenido, $destino, $asunto){

//global URL_HTTP;

$mime_boundary = "www.proveedores.mx ".md5(time());

$headers = "From: web@proveedores.mx <web@proveedores.mx>\n";

$headers .= "MIME-Version: 1.0\n";

$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";

$message = "--$mime_boundary\n";

$message .= "Content-Type: text/html;charset=ISO-8859-1\n";

//$message .= "Content-Type: text/html; charset=UTF-8\n";

$message .= "Content-Transfer-Encoding: 8bit\n\n";

$message .= $contenido;

mail( $destino, $asunto, $message, $headers);

}

*/

function elimina_acentos($cadena){
$tofind = "����������������������������������������������������&ntilde;";
$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
return(strtolower(strtr($cadena,$tofind,$replac)));
}


function RandomString($len){
	$base='abcdefghjkmnpqrstwxyz123456789';
	$max=strlen($base)-1;

	$activatecode='';mt_srand((double)microtime()*1000000);
	

	while (strlen($activatecode)<$len+1)
		$activatecode.=$base[mt_rand(0,$max)];
	return $activatecode;	
}



function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras

    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){

       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {

          //miro si tiene caracter .

          if (substr_count($email,".")>= 1){

             //obtengo la terminacion del dominio

             $term_dom = substr(strrchr ($email, '.'),1);

             //compruebo que la terminaci�n del dominio sea correcta

             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){

                //compruebo que lo de antes del dominio sea correcto

                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);

                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);

                if ($caracter_ult != "@" && $caracter_ult != "."){

                   $mail_correcto = 1;

                }

             }

          }

       }

    }

    if ($mail_correcto)
       return 1;
    else
       return 0;

}

function unidad($numuero){
	switch ($numuero)
	{
		case 9:
		{
			$numu = "NUEVE";
			break;
		}
		case 8:
		{
			$numu = "OCHO";
			break;
		}
		case 7:
		{
			$numu = "SIETE";
			break;
		}
		case 6:
		{
			$numu = "SEIS";
			break;
		}
		case 5:
		{
			$numu = "CINCO";
			break;
		}
		case 4:
		{
			$numu = "CUATRO";
			break;
		}
		case 3:
		{
			$numu = "TRES";
			break;
		}
		case 2:
		{
			$numu = "DOS";
			break;
		}
		case 1:
		{
			$numu = "UN";
			break;
		}
		case 0:
		{
			$numu = "";
			break;
		}
	}
	return $numu;
}

function decena($numdero){

		if ($numdero >= 90 && $numdero <= 99)
		{
			$numd = "NOVENTA ";
			if ($numdero > 90)
				$numd = $numd."Y ".(unidad($numdero - 90));
		}
		else if ($numdero >= 80 && $numdero <= 89)
		{
			$numd = "OCHENTA ";
			if ($numdero > 80)
				$numd = $numd."Y ".(unidad($numdero - 80));
		}
		else if ($numdero >= 70 && $numdero <= 79)
		{
			$numd = "SETENTA ";
			if ($numdero > 70)
				$numd = $numd."Y ".(unidad($numdero - 70));
		}
		else if ($numdero >= 60 && $numdero <= 69)
		{
			$numd = "SESENTA ";
			if ($numdero > 60)
				$numd = $numd."Y ".(unidad($numdero - 60));
		}
		else if ($numdero >= 50 && $numdero <= 59)
		{
			$numd = "CINCUENTA ";
			if ($numdero > 50)
				$numd = $numd."Y ".(unidad($numdero - 50));
		}
		else if ($numdero >= 40 && $numdero <= 49)
		{
			$numd = "CUARENTA ";
			if ($numdero > 40)
				$numd = $numd."Y ".(unidad($numdero - 40));
		}
		else if ($numdero >= 30 && $numdero <= 39)
		{
			$numd = "TREINTA ";
			if ($numdero > 30)
				$numd = $numd."Y ".(unidad($numdero - 30));
		}
		else if ($numdero >= 20 && $numdero <= 29)
		{
			if ($numdero == 20)
				$numd = "VEINTE ";
			else
				$numd = "VEINTI".(unidad($numdero - 20));
		}
		else if ($numdero >= 10 && $numdero <= 19)
		{
			switch ($numdero){
			case 10:
			{
				$numd = "DIEZ ";
				break;
			}
			case 11:
			{
				$numd = "ONCE ";
				break;
			}
			case 12:
			{
				$numd = "DOCE ";
				break;
			}
			case 13:
			{
				$numd = "TRECE ";
				break;
			}
			case 14:
			{
				$numd = "CATORCE ";
				break;
			}
			case 15:
			{
				$numd = "QUINCE ";
				break;
			}
			case 16:
			{
				$numd = "DIECISEIS ";
				break;
			}
			case 17:
			{
				$numd = "DIECISIETE ";
				break;
			}
			case 18:
			{
				$numd = "DIECIOCHO ";
				break;
			}
			case 19:
			{
				$numd = "DIECINUEVE ";
				break;
			}
			}
		}
		else
			$numd = unidad($numdero);
	return $numd;
}

	function centena($numc){
		if ($numc >= 100)
		{
			if ($numc >= 900 && $numc <= 999)
			{
				$numce = "NOVECIENTOS ";
				if ($numc > 900)
					$numce = $numce.(decena($numc - 900));
			}
			else if ($numc >= 800 && $numc <= 899)
			{
				$numce = "OCHOCIENTOS ";
				if ($numc > 800)
					$numce = $numce.(decena($numc - 800));
			}
			else if ($numc >= 700 && $numc <= 799)
			{
				$numce = "SETECIENTOS ";
				if ($numc > 700)
					$numce = $numce.(decena($numc - 700));
			}
			else if ($numc >= 600 && $numc <= 699)
			{
				$numce = "SEISCIENTOS ";
				if ($numc > 600)
					$numce = $numce.(decena($numc - 600));
			}
			else if ($numc >= 500 && $numc <= 599)
			{
				$numce = "QUINIENTOS ";
				if ($numc > 500)
					$numce = $numce.(decena($numc - 500));
			}
			else if ($numc >= 400 && $numc <= 499)
			{
				$numce = "CUATROCIENTOS ";
				if ($numc > 400)
					$numce = $numce.(decena($numc - 400));
			}
			else if ($numc >= 300 && $numc <= 399)
			{
				$numce = "TRESCIENTOS ";
				if ($numc > 300)
					$numce = $numce.(decena($numc - 300));
			}
			else if ($numc >= 200 && $numc <= 299)
			{
				$numce = "DOSCIENTOS ";
				if ($numc > 200)
					$numce = $numce.(decena($numc - 200));
			}
			else if ($numc >= 100 && $numc <= 199)
			{
				if ($numc == 100)
					$numce = "CIEN ";
				else
					$numce = "CIENTO ".(decena($numc - 100));
			}
		}
		else
			$numce = decena($numc);

		return $numce;
}

	function miles($nummero){
		if ($nummero >= 1000 && $nummero < 2000){
			$numm = "MIL ".(centena($nummero%1000));
		}
		if ($nummero >= 2000 && $nummero <10000){
			$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
		}
		if ($nummero < 1000)
			$numm = centena($nummero);

		return $numm;
	}

	function decmiles($numdmero){
		if ($numdmero == 10000)
			$numde = "DIEZ MIL";
		if ($numdmero > 10000 && $numdmero <20000){
			$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
		}
		if ($numdmero >= 20000 && $numdmero <100000){
			$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
		}
		if ($numdmero < 10000)
			$numde = miles($numdmero);

		return $numde;
	}

	function cienmiles($numcmero){
		if ($numcmero == 100000)
			$num_letracm = "CIEN MIL";
		if ($numcmero >= 100000 && $numcmero <1000000){
			$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
		}
		if ($numcmero < 100000)
			$num_letracm = decmiles($numcmero);
		return $num_letracm;
	}

	function millon($nummiero){
		if ($nummiero >= 1000000 && $nummiero <2000000){
			$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
		}
		if ($nummiero >= 2000000 && $nummiero <10000000){
			$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
		}
		if ($nummiero < 1000000)
			$num_letramm = cienmiles($nummiero);

		return $num_letramm;
	}

	function decmillon($numerodm){
		if ($numerodm == 10000000)
			$num_letradmm = "DIEZ MILLONES";
		if ($numerodm > 10000000 && $numerodm <20000000){
			$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
		}
		if ($numerodm >= 20000000 && $numerodm <100000000){
			$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
		}
		if ($numerodm < 10000000)
			$num_letradmm = millon($numerodm);

		return $num_letradmm;
	}

	function cienmillon($numcmeros){
		if ($numcmeros == 100000000)
			$num_letracms = "CIEN MILLONES";
		if ($numcmeros >= 100000000 && $numcmeros <1000000000){
			$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
		}
		if ($numcmeros < 100000000)
			$num_letracms = decmillon($numcmeros);
		return $num_letracms;
	}

	function milmillon($nummierod){
		if ($nummierod >= 1000000000 && $nummierod <2000000000){
			$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
		}
		if ($nummierod >= 2000000000 && $nummierod <10000000000){
			$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
		}
		if ($nummierod < 1000000000)
			$num_letrammd = cienmillon($nummierod);

		return $num_letrammd;
	}


function convertir($numero){
		   $numf = milmillon($numero);
		return $numf;
}
function convierte_num_a_letras($num)
   {

      $numero_de_caracteres =strlen(strval($num));
      $enteros =$numero_de_caracteres - 3;
      $entera=  substr("$num",0,$enteros);  //Parte entera del numero
      $puntero_flotante = $numero_de_caracteres -2;
      $flotante= substr("$num",$puntero_flotante,2); //Parte flotante del numero
      $entera_no_caracteres =strlen(strval($entera));


      $pattern =",";
      $replacement = "";
      $num=  str_replace($pattern, $replacement, $entera);
      $imp = convertir($num);
      $impre ="$imp PESOS $flotante /100 M.N.";

      return $impre;
   }
function corrige_rfc($rfc){
$rfc= str_replace("-", "", "$rfc");
$rfc= str_replace(" ", "", "$rfc");
return $rfc;
}

?>
