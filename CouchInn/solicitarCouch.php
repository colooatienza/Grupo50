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
		inicio = document.getElementById("inicio").value;
		if (!inicio){
			alert ('ERROR! Debe seleccionar la fecha de inicio!');
			return false;
		}
		fin = document.getElementById("fin").value;
		if (!fin) {
			alert ('ERROR! Debe seleccionar la fecha de fin!');
			return false;
		}
		if(inicio>=fin){
			alert ('ERROR! La fecha de fin debe ser mayor a la de inicio!');
			return false;
		}
		valor = document.getElementById("personas").value;
		if (valor.length == 0) {
			alert ('ERROR! Debe ingresar la cantidad de personas!');
			return false;
		}
		valor = document.getElementById("descripcion").value;
		if (valor.length == 0) {
			alert ('ERROR! Debe ingresar una descripción!');
			return false;
		}
	}

</script>

</head>
<body>
	<?php

		if(!isset($_GET['id']))
			header('Location: index.php');

		include("verificarUsuario.php");
		include("conexion.php");
  		include("menu.php");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "Select fechainicio, fechafin FROM couchs WHERE id='".$_GET['id']."'";


		$result=$conn->query($sql);
		$row=$result->fetch_array();
		$inicio=$row[0];
		$fin=$row[1];

	?> 

<h1 align="center">Solicitar Couch</h1>
<div class="divTipo" style="width:400px">
	<form onSubmit="return valida()" method="post" action="couchSolicitado.php" enctype="multipart/form-data">
    
		</br>
		<input type="hidden" name="id" id="id" value= <?php echo $_GET['id'] ?> /> 

    	Fecha de inicio
		<input type="date" name="inicio" id="inicio" value= <?php echo $inicio ?> min= <?php echo $inicio ?> max= <?php echo $fin ?>/>  
      	</br></br>

    	Fecha de fin
		<input type="date" name="fin" id="fin" value= <?php echo $fin ?>  min= <?php echo $inicio ?> max= <?php echo $fin ?> />  
      	</br></br>
		Cantidad de Personas
		<input type="number" name="personas" id="personas" value="1" min="1"> 
      	</br></br>

      <textarea name="descripcion" id="descripcion" placeholder="Inserte una descripción..." cols="41" rows="6"  ></textarea>
      </br>
      </br>

<input type= "submit" value= "Concretar solicitud" class= "botonAgregarPago">
	  </p> 
	</form>
</div>

</body>
</html>

