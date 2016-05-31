<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>

  
    
  <link rel="stylesheet" href="file:///C|/wamp/www/Css/c.css">
  <link rel="icon" href="file:///C|/wamp/www/Imagenes/icono.ico">

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
		include("conexion.php");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "Update tipos_Couch  Set tipo= '".$_POST['nombre']."' where id=  '".$_POST['id']."' ";
		$result = $conn->query($sql);
		echo '<h4 align="center">Se ha modificado correctamente el tipo '.$_POST['nombre'].'!</h4>';
		echo '<a href="consultaTipo.php">Volver a Tipos de Couch</a>';
		header( "refresh:3; url=consultaTipo.php" );
   }
   else {
   		echo 'Los datos ingresados son inválidos, reintentar...';
   }
?>
<footer class="footer"><p>Atienza Tomas - Capra Agustin </p></footer>
</body>
</html>
