<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <title>CouchInn</title>
  <link rel="stylesheet" href="Css/c.css">
  <link rel="icon" href="images/icono.ico">
</head>
<body>
	<?php
	if($_SESSION["admin"]==1){
	include("verificarUsuario.php");
	
	function validar(){
        if (!isset($_POST['nombre'])|| strlen(str_replace(' ','',$_POST['nombre']))==0){
            return false;
        }
        return true;
    }
	?>

	<?php
    if (validar()){
		include("conexion.php");
		
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "Insert INTO tipos_Couch (tipo) VALUES ('".$_POST['nombre']."') ";
		$result = $conn->query($sql);

		echo '<h4 align="center">Se ha agregado correctamente la categoría '.$_POST['nombre'].'!</h4>';
		echo '<a href="consultaTipo.php">Volver a Tipos de Couch</a>';
		header( "refresh:3; url=consultaTipo.php" );
   }
   else {
   	echo 'Los datos ingresados son inválidos, reintentar...';
   }
?>
<footer class="footer"><p>CouchInn </p></footer>
<?php
}
else{
	header("Location: index.html");
}
?>
</body>
</html>
