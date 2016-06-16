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

			$conn->query("UPDATE solicitud SET estado= 'rechazado' WHERE id = '".$_GET['id']."' ") or die (mysql_error());
		header(Location: "solicitudes.php");
	?>

</body>
</html>