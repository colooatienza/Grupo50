<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>CouchInn</title>
	<link rel="stylesheet" href="Css/c.css">
	<link rel="icon" href="images/logo.jpg">
	<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
	<?php
   include("verificarUsuario.php");
   include("menu.php");
   include("conexion.php");
		
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "INSERT INTO `calificaciones`(`resenia`, `puntuacion`, `tipo`, `idcouch`, `calificado`, `calificador` ) VALUES ('".$_POST['resena']."', '".$_POST['puntuacion']."', '".$_POST['tipo']."', '".$_POST['idcouch']."', '".$_POST['idusuario']."', '".$_SESSION['usuario']."') ";
		
		$r=$conn->query($sql);
		echo $r;
		echo' </br> </br> </br>';
		echo'<div class="divTipo">';
		echo '<h4 align="center">Ha calificado exitosamente!</h4>';
		echo '<a href="calificaciones.php">Volver a Calificaciones</a>';
		echo'</div>';
   
?>
</body>
</html>
