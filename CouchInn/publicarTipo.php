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
		echo '<h4 algin="center">Se ha publicado correctamente el tipo de Couch!</h4></br>';
		
		echo '<a href="consultaTipo.php">Volver a Tipos de Couch</a>';
		header( "refresh:3; url=consultaTipo.php" );
	?>

</body>
</html>