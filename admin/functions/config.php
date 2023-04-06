<?php

/// CONEXION MYSQL

define('USUARIOS_ADMIN_SESSION', 'autenticacion');

define('USUARIOS_WEB_SESSION', 'autenticacion');



ini_set("register_globals",1);

extract($_REQUEST);



/// CONEXION MYSQL

define('USUARIOS_SESSION', 'autenticacion');

define('HOST', '127.0.0.1');

define('DBUSER', 'root');

define('DBPASSWORD', '');

define('DBNAME', 'intranet');



/// DATOS FTP

define('DOMINIO', 'ftp.doitright.solutions');

define('FTP_USER', 'intranet@doitright.solutions');

define('FTP_PASSWORD', 'txoE.Ta@r)Zm');



/// DATOS ADICIONALES

define('URL_HTTP', "http://fuentesasociados.com.mx/intranet/");

define('URL_HTTPS', "http://fuentesasociados.com.mx/intranet/");

define('CORREO_SMTP', "smtp.servnet.mx");

define('CORREO_PUERTO', "25");

define('CORREO_CUENTA', "arteyprog@servnet.mx");

define('CORREO_PASSWORD', "9W5yZckhD2");

define('CORREO_ENVIO', "erick.nava@servnet.mx");

?>