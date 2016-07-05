<!DOCTYPE HTML>
<html>
<head>
  
  <meta charset="UTF-8">
  <title>CouchInn</title>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	
  	<link rel="icon" href="images/logo.jpg">
  	<style>
   	.divTipo{
	background-color:#DDF;
	border: solid 1px black;
	box-shadow: 0 2px 4px 0;
	border-radius:5px;
	width:240px;
	display:block;
	margin:auto;
	padding:10px;
	margin-bottom:250px;
	}
    

  	</style>
</head>
<body>
	<?php
	
	
		session_start();
		include("conexion.php");
		include("menu.php");

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		echo '<h1 align="center"><hr> Preguntas Frecuentes<hr></h1>';
		echo'<div class="divTipo" style="width:800px;">';
		?>
		<table><tr>
		  <td style="margin:15px; padding:15px;">
          <img src="images/pregs.jpg" width="130" height="59" alt="a"></td></tr><tr>
        <td style="margin:15px; padding:15px;">
        
		<p align="left"><b>• Cuando puedo calificar a un Coucher o viajero?</b></p>
		<p align="left"> <span style="text-align: left">&nbsp; &nbsp; &nbsp; &nbsp; Una vez que haya finalizado la estadía.</span></p>

		<p align="left"><b>• Es necesario calificar?</b></p>
		<p align="left"> <span style="text-align: left">&nbsp; &nbsp; &nbsp; &nbsp; Si, es obligatorio calificar despues de alojarse/hospedar para poder aceptar nuevas solicitudes, solicitar, entre otras cosas.</span></p>

		<p align="left"><b>• Como hago para solicitar un Couch?</b></p>
		<p align="left"> <span style="text-align: left">&nbsp; &nbsp; &nbsp; &nbsp; Es obligatorio estar registrado, luego se puede solicitar entrando al detalle de un Couch.</span></p>

		<p align="left"><b>• Que beneficios tengo al ser Premium?</b></p>
		<p align="left"> <span style="text-align: left">&nbsp; &nbsp; &nbsp; &nbsp;  A diferencia de los usuarios comunes, los Couchs de los usuarios Premium figuran primero en la lista de Couchs y además muestran una foto.</span></p>


		<p align="left"><b>• Puedo aceptar un Couch una vez rechazado o viceversa?</b></p>
		<p align="left"> <span style="text-align: left">&nbsp; &nbsp; &nbsp; &nbsp; No, una vez tomada la decision, no hay forma de volver atrás.</span></p>

		<p align="left"><b>• Por qué no puedo modificar cierta información de mi Couch? </b></p>
		<p align="left"> <span style="text-align: left">&nbsp; &nbsp; &nbsp; &nbsp;  Una vez que tiene solicitudes aceptadas o pendientes solo es posible modificar el titulo, descripcion e imagenes.</span></p>
        </td></tr></table>


		<?php
   		echo'</div>';
	?>

</body>
</html>



