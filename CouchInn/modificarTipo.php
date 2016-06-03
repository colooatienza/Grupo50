<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>

  
    
  <link rel="stylesheet" href="Css/c.css">
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="icon" href="images/logo.jpg">

<script type="text/javascript" >
	function valida(){
		valor = document.getElementById("nombre").value;
		if ((valor == null) || (valor.length == 0)) {
			alert ('ERROR! Debe ingresar un nombre para el tipo de Couch!');
			return false;
		}
	}

</script>

</head>
<body>
		<?php	
		session_start();
		include("menu.php");
	if($_SESSION["admin"]==0)
		header("Location: login.php");
	?> 

<h1 align="center">Modificar Tipo de Couch </h1>
<div class="divTipo">
	<form onSubmit="return valida()" method="post" action="TipoModificado.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?> ">
		Nombre:<input type="text" id="nombre" name="nombre" value= <?php echo getName(); ?> placeholder="Nombre del tipo"> </br>
		<input type= "submit" class= "botonAgregarTipo" value= "Guardar Cambios"> 
	</form>
</div>

</body>
<?php
function getName(){
include("conexion.php");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "select * from tipos_couch WHERE id = ".$_GET['id'];
$result=$conn->query($sql);
$row=$result->fetch_array();
return $row['tipo'];
}

?>
</html>
