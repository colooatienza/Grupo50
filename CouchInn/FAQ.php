<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="stylesheet" href="css/c.css">
  	<link rel="icon" href="images/logo.jpg">
  	
</head>
<body>
	<?php
		session_start();
		include("conexion.php");
		include("menu.php");

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		echo'</br></br></br><h1 align="center"> Preguntas Frecuentes</h1></br></br><div class="divTipo" style="width:600px; ">';
		?>

		<p align="left"><b>• Cuando puedo calificar a un Coucher o viajero?</b></p>
		<p align="left"> &nbsp; &nbsp; &nbsp; &nbsp; Una vez que haya finalizado la estadía.</p>

		<p align="left"><b>• Es necesario calificar?</b></p>
		<p align="left"> &nbsp; &nbsp; &nbsp; &nbsp; Si, es obligatorio calificar despues de alojarse/hospedar para poder aceptar nuevas solicitudes, solicitar, entre otras cosas.</p>

		<p align="left"><b>• Como hago para solicitar un Couch?</b></p>
		<p align="left"> &nbsp; &nbsp; &nbsp; &nbsp; Es obligatorio estar registrado, luego se puede solicitar entrando al detalle de un Couch.</p>

		<p align="left"><b>• Que beneficios tengo al ser Premium?</b></p>
		<p align="left"> &nbsp; &nbsp; &nbsp; &nbsp;  A diferencia de los usuarios comunes, los Couchs de los usuarios Premium figuran primero en la lista de Couchs y además muestran una foto.</p>


		<p align="left"><b>• Puedo aceptar un Couch una vez rechazado o viceversa?</b></p>
		<p align="left"> &nbsp; &nbsp; &nbsp; &nbsp; No, una vez tomada la decision, no hay forma de volver atrás.</p>

		<p align="left"><b>• Por qué no puedo modificar cierta información de mi Couch? </b></p>
		<p align="left"> &nbsp; &nbsp; &nbsp; &nbsp;  Una vez que tiene solicitudes aceptadas o pendientes solo es posible modificar el titulo, descripcion e imagenes.</p>
		<?php
   		echo'</div>';
	?>

</body>
</html>