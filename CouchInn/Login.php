<DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<title>	CouchInn</title>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/c.css">
<script type="text/javascript" >
	function valida(){
		valor = document.getElementById("usuario").value;
		if ((valor == null) || (valor.length == 0)) {
			alert ('ERROR Debe ingresar un usuario!');
			return false;
		}
		valor = document.getElementById("clave").value;
		if ((valor == null) || (valor.length == 0)) {
			alert ('ERROR Debe ingresar la clave!');
			return false;
		} 
	}
</script>
</head>
<body>	
	<?php
  		include("menu.php");
		
  	?>
	<div class="divLogin">
		<form method="POST" action="Logueo.php" onSubmit="return valida()">
			<input type= "text" id="usuario" placeholder="Usuario" name="usuario" class="txtLogin">  <br>
			<input type= "password" id="clave" placeholder="Clave" name="clave" class="txtLogin"> <br>
			<input type= "submit" value= "Entrar" class="btnLogin"> 
		</form>
	</div>
</body>
</html>
