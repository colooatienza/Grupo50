<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>

  
    
<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="Css/c.css">
  <link rel="icon" href="Imagenes/icono.ico">

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
		include("verificarUsuario.php");
		?> 

<h1 align="center">Agregar Tipo de Couch </h1>
<div class="divTipo">
	<form onSubmit="return valida()" method="post" action="TipoAgregado.php" enctype="multipart/form-data">
		<input type="text" id="nombre" name="nombre" placeholder="Nombre del tipo"> 
		<input type= "submit" value= "Agregar" class= "botonAgregarTipo"> 
	</form>
</div>

<footer class="footer">
  <p>Atienza Tomas - Ruiz Matias </p>
</footer>
</body>

</html>
