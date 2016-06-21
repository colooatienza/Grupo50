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
	if($_SESSION["admin"]==1){
	
	function validar(){
        if (!isset($_POST['nombre'])|| strlen(str_replace(' ','',$_POST['nombre']))==0){
            return false;
        }
        return true;
    }
	?>

	<?php
    if (validar()){
		include("menu.php");
		include("conexion.php");
		
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
	
		
		$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']:"";
		$texto = isset($_POST['texto']) ? $_POST['texto']:"";
		$couch = isset($_POST['couch']) ? $_POST['couch']:"";
		if($usuario=="" || strlen($texto)<=3 || $couch=="")
		  header("Location: consultaCouch.php");
		 
		echo $usuario.'<br>';
		echo $texto.'<br>';
		echo $couch.'<br>';
		
		
		$sql = "INSERT INTO 'comentarios'('idcouch', 'usuario', 'texto') VALUES('".$couch."','".$usuario."','".$texto."') ";
		$conn->query($sql);
		echo' </br> </br> </br>';
		echo'<div class="divTipo">';
		echo '<h4 align="center">Se ha agregado correctamente la categoría '.$_POST['nombre'].'!</h4>';
		echo '<a href="consultaTipo.php">Volver a Tipos de Couch</a>';
		echo'</div>';
   }
   else {
   	echo 'Los datos ingresados son inválidos, reintentar...';
   }
?>
<?php
}
else{
	//header("Location: index.php");
}
?>
</body>
</html>
