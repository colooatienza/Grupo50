<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>

  
    
  <link rel="stylesheet" href="Css/c.css">
  <link rel="icon" href="Imagenes/icono.ico">

<script type="text/javascript" >
	function valida(){
		valor = document.getElementById("nombre").value;
		if ((valor == null) || (valor.length == 0)) {
			alert ('ERROR! Debe ingresar el nombre de la tarjeta de credito!');
			return false;
		}
		valor = document.getElementById("numero").value;
		if (valor.length != 16) {
			alert ('ERROR! Debe ingresar un número de tarjeta válido!(16 dígitos)');
			return false;
		}
		valor = document.getElementById("codigo").value;
		if (valor.length != 3) {
			alert ('ERROR! Debe ingresar un código de seguridad válido!(Son los últimos 3 digitos que aparecen en su tarjeta de credito)');
			return false;
		}
	}

</script>

</head>
<body>
	<?php
		include("verificarUsuario.php");
		include("conexion.php");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "Select destacado FROM usuarios WHERE nombredeusuario='".$_SESSION['usuario']."'";
		$result=$conn->query($sql);
		$row=$result->fetch_array();
		if($row[0]==1){
			echo "<h2> Usted ya es usuario Premium </h2>";
		}
		else{
	?> 

<h1 align="center">Mejorar a Usuario Premium</h1>
<div class="divTipo">
	<form onSubmit="return valida()" method="post" action="AgregandoPago.php" enctype="multipart/form-data">
    
	  <p>Nombre de la tarjeta:
		<input type="text" id="tarjeta" name="tarjeta" placeholder="Ej: Visa, Mastercard"> 
		<p>Numero de tarjeta:
		  <input type="text" id="numero" name="numero" placeholder="16 caracteres" maxlength="16" onkeypress='return event.charCode >= 48 && event.charCode <= 57'> 
	  </p>
        <p>Codigo de Seguridad:
          <input type="text" id="codigo" name="codigo"  maxlength="3" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
      </p>
		<p>Monto:
          <input type="text" id="monto" name="monto" value="$100" readonly>
<input type= "submit" value= "Agregar Pago" class= "botonAgregarPago">
	  </p> 
	</form>
</div>

<footer class="footer">
  <p>Atienza Tomas - Ruiz Matias </p>
</footer>
</body>
<?php } ?>
</html>
