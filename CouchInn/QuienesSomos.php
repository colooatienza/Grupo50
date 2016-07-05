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
  	<style>
   
    

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
		echo '<h1 align="center"><hr> Quienes Somos?<hr></h1>';
		echo'<div class="divTipo" style="width:800px;">';
		?>
		<table><tr><td style="margin:15px; padding:15px;"><img src="images/quienesSomos1.png" ></td><td style="margin:15px; padding:15px;">
        <p><b>Autores</b></p>
		<p>Dos viajeros recurrentes, amantes de los intercambios culturales, idearon un sistema denominado CouchInn.
El mismo busca conectar gente que quiere ofrecer un espacio en su hogar para alojar a visitantes con viajeros
que busquen convivir con nativos del lugar compartiendo sus tradiciones y costumbres.</p>
       <br><p><b>Algunas funcionalidades:</b></p>
       <p> El sitio web en general se construye a partir de las personas que lo utilicen. Los usuarios pueden tanto solicitar alojamientos para hospedarse, como Publicar sus propios hogares para recibir viajeros. Además los usuarios pueden mejorar a Premiun siempre que den un único aporte al sitio que es a voluntad. La persona Premiun puede visualizar sus Couchs publicados con imagen en la página principal. <p>
       <p>Otras funciones son: por cada Couch visitado el usuario califica al Coucher, y el Coucher califica a su viajero. También los viajeros pueden hacerle preguntas al dueño del Couch. </p>
       <br><p><b>Objetivo del sitio:</b></p>
       <p> Simplemente proporcionar una aplicación útil que pueda unir viajeros temporales con personas que ofrezcan un espacio en su hogar.</p>
       <br><p><span style="color:#22A"><b>Contáctenos</b></span></p>
       <p><b>info@couchin.com.ar</b></p>
        </td><td style="margin:15px; padding:15px;"><img src="images/quienesSomos2.png" ></td></tr></table>


		<?php
   		echo'</div>';
	?>

</body>
</html>