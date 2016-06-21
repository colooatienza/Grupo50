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
		session_start();
		include("menu.php");
		include("conexion.php");
		
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "INSERT INTO `comentarios`(`idcouch`, `texto`, `idcomentario`, `usuario`) VALUES ('".$_POST['idcouch']."', '".$_POST['respuesta']."', '".$_POST['idcomentario']."', '".$_SESSION['usuario']."') ";
		
		$r=$conn->query($sql);
		echo $r;
		echo' </br> </br> </br>';
		echo'<div class="divTipo">';
		echo '<h4 align="center">Su respuesta ha sido envíada!</h4>';
		echo '<a href="preguntas.php">Volver a Preguntas</a>';
		echo'</div>';
   
?>
</body>
</html>
