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
	
	function validar(){
        if( (!isset($_POST['nombre'])|| strlen(str_replace(' ','',$_POST['nombre']))==0) &(!isset($_POST['id']) ||
		  strlen(str_replace(' ','',$_POST['id']))==0)){
            return false;
        }
		 
        return true;
    }
	?>

<?php
    if (validar()){
		include("menu.php");
		include("conexion.php");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "Update tipos_Couch  Set tipo= '".$_POST['nombre']."' where id=  '".$_POST['id']."' ";
		$result = $conn->query($sql);
		echo' </br> </br> </br>';
		echo'<div class="divTipo">';
		echo '<h4 align="center">Se ha modificado correctamente el tipo '.$_POST['nombre'].'!</h4>';
		echo '<a href="consultaTipo.php">Volver a Tipos de Couch</a>';
		echo'</div>';
   }
   else {
   		echo 'Los datos ingresados son inválidos, reintentar...';
   }
?>
</body>
</html>
