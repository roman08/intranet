<?php 
	  $bus='';
	  if ($_GET['periodo']!=''){
	  $imes=  substr($_GET['periodo'],4,2);
	  $iano=  substr($_GET['periodo'],0,4);
	  $bus="where YEAR(registro)='$iano' and MONTH(registro)='$imes'";
	  $ar=$_GET['periodo'];
	  } else {
	  $ar='Total';
	  }
	  
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"reporte_".$ar.".xls\";");

include ("functions/config.php");
include ("functions/conect.php");


	  $consulta=ProcesaQuery("select * from intranet_contacto where registro>='".fecha_aaaammdd($inicial)."' and registro<='".fecha_aaaammdd($final)."' order by registro desc;");
	  
	  
	  
	  
	  
	  $total= NumRows($consulta);
?>  
<font color="#333333" face="Arial, Helvetica, sans-serif" size="3"><b><span class="tahoma14_gris_bold_3">Reporte Contacto Generado el <?php  echo date("d-m-Y");?> a las <?php  echo date("H:i:s");?></b></font><br><br>
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000">
          <tr>
            <td bgcolor="#F7F7F7" >ID</td>
            <td bgcolor="#F7F7F7" >Fecha y Hora</td>
            <td bgcolor="#F7F7F7" >Nombre Completo</td>
            <td bgcolor="#F7F7F7" >Destino</td>
            <td bgcolor="#F7F7F7" >Teléfono</td>
            <td bgcolor="#F7F7F7" >Correo</td>
            <td bgcolor="#F7F7F7" >Comentario</td>
          </tr>
<?php
while($A0= FetchArray($consulta)){
?>		
          <tr>
            <td bgcolor="#FFFFFF" ><?php echo $A0['id_contacto']; ?></td>
            <td bgcolor="#FFFFFF" > <?php  echo fecha_ddmmaaaahhmmss($A0['registro']); ?> </td>
            <td bgcolor="#FFFFFF" ><?php  echo $A0['nombre']; ?></td>
            <td bgcolor="#FFFFFF" ><?php echo $A0['destino']; ?></td>
            <td bgcolor="#FFFFFF" ><?php echo $A0['telefono']; ?></td>
            <td bgcolor="#FFFFFF" ><?php  echo $A0['correo']; ?></td>
            <td bgcolor="#FFFFFF" ><?php  echo nl2br($A0['comentario']); ?></td>
          </tr>
<?php
}
?>		
      </table>