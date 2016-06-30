<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="stylesheet" href="css/c.css">
  	<link rel="icon" href="images/logo.jpg">
</head>
<body>
	<?php
		include("verificarUsuario.php");
		include("conexion.php");
		include("menu.php");

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "select * from solicitud INNER JOIN couchs ON couchs.id=solicitud.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE usuarios.nombredeusuario='".$_SESSION["usuario"]."' and inicio<Curdate() ORDER BY solicitud.estado='pendiente' DESC";
  $result=$conn->query($sql);
  $b=false;
  while($row=$result->fetch_array()){
    $sql = "SELECT * FROM calificaciones WHERE calificador ='".$_SESSION["usuario"]."' AND idcouch = ".$row["idcouch"]." ";
        $r=$conn->query($sql);
        if(!$r->fetch_array()){
          $b=true;
        }
}
if($b){
    echo' </br> </br> </br>';
    echo'<div class="divTipo">';
    echo '<h4 align="center">Tiene calificaciones pendientes! Califique para agregar nuevo Couch!</h4>';
    echo'</div>';
  }
  else{
		echo'</br></br></br></br></br><div class="divTipo">';
		$inicio=$_GET['inicio'];
		$fin=$_GET['fin'];
		$sql = "Select * from solicitud where estado= 'aceptado' AND idcouch='".$_GET['idcouch']."' and ((fin BETWEEN '".$inicio."' AND '".$fin."') OR inicio BETWEEN  '".$inicio."'AND '".$fin."'  OR(('".$fin."' BETWEEN inicio AND fin) OR '".$inicio."' BETWEEN  inicio AND fin)) AND (inicio <> '".$fin."') AND (fin <> '".$inicio."') ";
		$result=$conn->query($sql);
		if(mysqli_num_rows($result)==0){
			$conn->query("UPDATE solicitud SET estado= 'aceptado' WHERE id = '".$_GET['id']."' ") or die (mysql_error());
			echo'<h3> Ha aceptado exitosamente la solicitud!</h3>';
			echo '<a href="solicitudes.php">Volver al listado de solicitudes</a>';
		}
		else{
			echo'<h3> No se pueden superponer las fechas de las solicitudes aceptadas!</h3>';
			echo '<a href="solicitudes.php">Volver al listado de solicitudes</a>';

		}
   echo'</div>';
     echo $inicio.'<br><br>';  echo $fin;
	 //Rechazar todas las peticiones para esa fecha:
	 $sql_rechazarOtras="UPDATE solicitud SET estado= 'rechazado' WHERE idusuario!='".$_GET['idusuario']."' and  idcouch= '".$_GET['idcouch']."' and ((fin BETWEEN '".$inicio."' AND '".$fin."') OR inicio BETWEEN  '".$inicio."'AND '".$fin."'  OR(('".$fin."' BETWEEN inicio AND fin) OR '".$inicio."' BETWEEN  inicio AND fin)) AND (inicio <> '".$fin."') AND (fin <> '".$inicio."')";
	$rechazos=$conn->query($sql_rechazarOtras);
	
	
	//Rechazar todas las peticiones del mismo usuario para esas fechas también:::
	  $sql_rechazarOtras2="UPDATE solicitud SET estado= 'rechazado' WHERE idusuario='".$_GET['idusuario']."' and estado='pendiente' and ((fin BETWEEN '".$inicio."' AND '".$fin."') OR inicio BETWEEN  '".$inicio."'AND '".$fin."'  OR(('".$fin."' BETWEEN inicio AND fin) OR '".$inicio."' BETWEEN  inicio AND fin)) AND (inicio <> '".$fin."') AND (fin <> '".$inicio."')";
	$rechazos2=$conn->query($sql_rechazarOtras2);

}

	?>

</body>
</html>