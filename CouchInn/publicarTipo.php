<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>
</head>
<body>
	<?php
		include("verificarUsuario.php");
		include("conexion.php");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$query = $conn->query("UPDATE tipos_couch SET despublicado= 0 WHERE id = '".$_GET['id']."' ") or die (mysql_error());
		header( "Location: consultaTipo.php" );
	?>

</body>
</html>