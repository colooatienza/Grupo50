<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>

  
<script src="js/jquery-1.11.3.min.js"></script> 
	<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="Css/c.css">
  	<link rel="icon" href="images/logo.jpg">

<script type="text/javascript" >
	function valida(){
		valor = document.getElementById("tarjeta").value;
		if (valor=="-1"){
			alert ('ERROR! Debe seleccionar su tarjeta de credito!');
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
  		include("menu.php");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "Select destacado FROM usuarios WHERE nombredeusuario='".$_SESSION['usuario']."'";
		$tarjetas = "Select id, tarjeta FROM tarjetas";
		$tarjetas=$conn->query($tarjetas);
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
    
		</br>
	  <select  id="tarjeta" name="tarjeta" >
	  		<option value="-1">Seleccione Tarjeta</option>
	  		<?php
	  		while($row=$tarjetas->fetch_array()){
	  			echo '<option value="'.$row["id"].'">'.$row["tarjeta"].'</option>';

	  		}
	  		?>
		</select>
		</br>
		</br>
		<p>Número de tarjeta:
		  <input type="text" id="numero" name="numero" placeholder="16 caracteres" maxlength="16" onkeypress='return event.charCode >= 48 && event.charCode <= 57'> 
	  </p>
        <p>Código de Seguridad:
          <input type="text" id="codigo" name="codigo"  maxlength="3" style="text-align:center; " onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
      </p>
		<p>Monto:
          <input type="text" id="monto" name="monto" value="$100" style="text-align:center; margin-bottom:10px" readonly>
<input type= "submit" value= "Agregar Pago" class= "botonAgregarPago">
	  </p> 
	</form>
</div>

</body>
<?php } ?>
</html>
