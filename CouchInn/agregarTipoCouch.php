<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/bootstrap.js"></script>

  
    
<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="Css/c.css">
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
		if($_SESSION["admin"]==0){
			header("Location: login.php");
		}
		include("menu.php");

		?> 

<h1 align="center">Agregar Tipo de Couch </h1> </br> </br>
<div class="divTipo">
	<form onSubmit="return valida()" method="post" action="TipoAgregado.php" enctype="multipart/form-data">
		<input type="text" id="nombre" name="nombre" placeholder="Nombre del tipo"> 
		<input type= "submit" value= "Agregar" class= "botonAgregarTipo"> 
	</form>
</div>

</body>

</html>
