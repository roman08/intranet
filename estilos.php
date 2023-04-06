<?php
include ("admin/functions/config.php");
include ("admin/functions/conect.php");
$r=FetchArray(ProcesaQuery("SELECT * FROM intranet_header_menu_footer where id='1';"));
?>
.header_background { background-color:<?php echo $r['color11'];?>;}
.header_texto { color:<?php echo $r['color12'];?>;}
.header_texto_over { color:<?php echo $r['color13'];?>;}
.header_texto_logout { color:<?php echo $r['color14'];?>;}

.menu_background { background-color:<?php echo $r['color21'];?>;}
.menu_texto { color:<?php echo $r['color22'];?>;}
.menu_texto_over { color:<?php echo $r['color23'];?>;}
.menu_texto_subnivel_moviles { color:<?php echo $r['color24'];?>;}

.footer_background { background-color:<?php echo $r['color31'];?>;}
.footer_texto { color:<?php echo $r['color32'];?>;}
.footer_texto_over { color:<?php echo $r['color33'];?>;}
