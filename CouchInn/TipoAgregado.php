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
		$texto="No se pudo agregar porque ya existe una categoría con el mismo nombre!"; 
		$consulta = $conn->query("select * from tipos_Couch where tipo=('".utf8_decode($_POST['nombre'])."')");
		 if($consulta->num_rows==0){
			  		$sql = "Insert INTO tipos_Couch (tipo) VALUES ('".utf8_decode($_POST['nombre'])."') ";
		$conn->query($sql); 
		$texto="Se ha agregado correctamente la categoría!";
			 }
		   
	
		echo' </br> </br> </br>';
		echo'<div class="divTipo">';
		echo '<h4 align="center">'.$texto.'</h4>';
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
	header("Location: index.html");
}
?>
</body>
</html>
