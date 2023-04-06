<?php /* ------------------------------------------------
C�digo de Servnet M�xico S.A. de C.V.
---------------------------------------------------*/

// Cargar datos conexion y otras variables.
//require ("functions/config.php");
// chequear p�gina que lo llama para devolver errores a dicha p�gina.
$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir='index.php';
// chequear si se llama directo al script.
//if ($_SERVER['HTTP_REFERER'] == ""){
//die ("Error cod.:1 - Acceso incorrecto!");
//exit;
//}

// Chequeamos si se est� autentificandose un usuario por medio del formulario


if (isset($_POST['user']) && isset($_POST['pass'])) {

// Conexi�n base de datos.
// si no se puede conectar a la BD salimos del scrip con error 0 y
// redireccionamos a la pagina de error.
$db_conexion= mysqli_connect(HOST, DBUSER, DBPASSWORD) or die(header ("Location:  $redir?error_login=0"));
$db_conexion->select_db(DBNAME);
// mysql_select_db(DBNAME);
// realizamos la consulta a la BD para chequear datos del Usuario.
$usuario_consulta = $db_conexion->query("SELECT id_usuario,nombre,usuario,password,nivel FROM intranet_usuarios WHERE usuario='".$_POST['user']."' and nivel<='3'") or die(header ("Location:  $redir?error_login=1"));
 // miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)

 if (mysqli_num_rows($usuario_consulta) != 0) {
    // eliminamos barras invertidas y dobles en sencillas
    $login = stripslashes($_POST['user']);
    // encriptamos el password en formato md5 irreversible.
    $password = $_POST['pass'];
    // almacenamos datos del Usuario en un array para empezar a chequear.
 	$usuario_datos = mysqli_fetch_array($usuario_consulta);
      // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.

      mysqli_free_result($usuario_consulta);
      // cerramos la Base de dtos.
      $db_conexion->close();
   //  mysql_close($db_conexion);
    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // p�gina de error.
    if ($login != $usuario_datos['usuario']) {
       	Header ("Location: $redir?error_login=4");
		exit;}

    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la p�gina de error
    if ($password != $usuario_datos['password']) {
        Header ("Location: $redir?error_login=3");
	    exit;}

    // Paranoia: destruimos las variables login y password usadas
    unset ($login);
    unset ($password);

     // le damos un mobre a la sesion.
    session_name('administracion_intranet_servnet');
     // incia sessiones
    session_start();

    // Paranoia: decimos al navegador que no "cachee" esta p�gina.
    session_cache_limiter('nocache,private');

    // definimos usuarios_id como IDentificador del usuario en nuestra BD de usuarios
    $_SESSION['usuario_id']=$usuario_datos['id_usuario'];

    // definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    $_SESSION['usuario_nivel']=$usuario_datos['nivel'];	
	 $_SESSION['usuario_nombre']=$usuario_datos['nombre'];

    //definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    $_SESSION['usuario_login']=$usuario_datos['usuario'];

    //definimos usuario_password con el password del usuario de la sesi�n actual (formato md5 encriptado)
    $_SESSION['usuario_password']=$usuario_datos['password'];
	
	ProcesaQuery("UPDATE intranet_usuarios set ultimo=NOW() where id_usuario='".$usuario_datos['id_usuario']."';");
    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
	
    $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag?");
    exit;
   } else {
      // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      Header ("Location: $redir?error_login=2");
      exit;}
} else {
// -------- Chequear sesi�n existe -------
// usamos la sesion de nombre definido.
session_name('administracion_intranet_servnet');
// Iniciamos el uso de sesiones
session_start();

// Chequeamos si estan creadas las variables de sesi�n de identificaci�n del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.

if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){
// Borramos la sesion creada por el inicio de session anterior
session_destroy();
Header ("Location: $redir?error_login=7");
exit;
}
}
?>