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
	
	 $sql_rechazarOtras="UPDATE solicitud SET estado= 'rechazado' WHERE idusuario!='".$_GET['idusuario']."' and  idcouch= '".$_GET['idcouch']."' and ((fin BETWEEN '".$inicio."' AND '".$fin."') OR inicio BETWEEN  '".$inicio."'AND '".$fin."'  OR(('".$fin."' BETWEEN inicio AND fin) OR '".$inicio."' BETWEEN  inicio AND fin)) AND (inicio <> '".$fin."') AND (fin <> '".$inicio."')";
	$rechazos=$conn->query($sql_rechazarOtras);
	
	?>

</body>
</html>