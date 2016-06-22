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
	
	?>

	<?php
    
		include("menu.php");
		include("conexion.php");
		
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
	
		
		$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']:"";
		$texto = isset($_POST['texto']) ? $_POST['texto']:"";
		$couch = isset($_POST['couch']) ? $_POST['couch']:"";
		if($usuario=="" || strlen($texto)<=3 || $couch==""){
            header("Location:consultaCouch.php?id=".$couch."");}else{
		echo '<br><br>'.strlen($texto);
		$texto=utf8_decode($texto); 
		$usuario=utf8_decode($usuario); 
			
		$sql = "INSERT INTO comentarios(idcouch, usuario, texto) VALUES('$couch','$usuario','$texto') ";
		$conn->query($sql);
		
		 header("Location:consultaCouch.php?id=".$couch."");
			}
  
?>
</body>
</html>
