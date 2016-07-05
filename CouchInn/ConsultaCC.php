<?php
 include('conexion.php');
 
 
  $consultaCouch=$conn->query( "Select count(*),tipo from Solicitud inner join couchs on couchs.id=solicitud.idcouch inner join tipos_couch on tipos_couch.id=idtipo where estado='aceptado' group by tipo");
  
  

 $i=0;
 while( $filas=$consultaCouch->fetch_array()){

	$cantidad[$i]=$filas["0"];
	$i++;
	}




$columnas = array($cantidad[0],$cantidad[1]);

echo $cantidad[0];
echo $cantidad[1];

?>