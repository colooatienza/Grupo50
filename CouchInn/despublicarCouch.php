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
		$hacer=  isset($_GET['hacer'])?  $_GET['hacer'] : -1;
		$id=isset($_GET['id'])? $_GET['id']:-1;
		
		if($hacer!=0 && $hacer!=1) 
		 header("Location: index.php"); 
		 if($id==-1)
		 header("Location: index.php"); 
		
		$query = $conn->query("UPDATE couchs SET disponible='".$hacer."' WHERE id = '".$id."'  and usuario='".$_SESSION['usuario']."'") or die (mysql_error());
		header( "Location: misCouchs.php" );
	?>

</body>
</html>