<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="icon" href="images/logo.jpg">
  <link rel="stylesheet" href="Css/c.css">
</head>
<body>
	<?php
		session_start();
		include("menu.php");
		echo'</br></br></br>';
		echo'<div class="divTipo">';
		if(!isset($_GET["id"]))
			header("Location: index.php");
		if($_SESSION["admin"]==0){
			header("Location: login.php");
		}
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
		echo'</div>';
	?>

</body>
</html>