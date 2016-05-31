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
		$sql = "Select * FROM couchs where idtipo= ".$_GET["id"];
		$result=$conn->query($sql);
		//$row=$result->fetch_array();
		if($result->fetch_array()){
			echo '<p font="40px" align="center">Existen Couchs relacionados con este tipo, no se puede eliminar!</p>';
		}
		else{
			$query = $conn->query("Delete FROM tipos_couch WHERE id = '".$_GET['id']."' ") or die (mysql_error());
			echo '<h4 algin="center">Se ha eliminado correctamente el tipo de Couch!</h4></br>';
		}
		echo '<a href="consultaTipo.php">Volver a Tipos de Couch</a>';
		header( "refresh:3; url=consultaTipo.php" );
	?>

</body>
</html>