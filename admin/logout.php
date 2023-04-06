<?php /* ------------------------------------------------
Código de Servnet México S.A. de C.V.
---------------------------------------------------*/
require("verificar_usuario.php");
$nivel_acceso=3; // Nivel de acceso para esta página.
if ($nivel_acceso < $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5&x=1");
exit;
}

session_destroy();
header("Location: index.php");
exit();
?>