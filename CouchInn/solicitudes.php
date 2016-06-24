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
	<script type="text/javascript">
	function aceptar(ruta) {
		if(confirm("Confirma aceptar la solicitud?")){
			window.location.href = ruta;
		}
	}	
	function rechazar(ruta) {
		if(confirm("Confirma rechazar la solicitud?")){
			window.location.href = ruta;
		}
	}
	</script>
</head>
<body>
	<?php
	session_start();
   	include("conexion.php");
  	include("menu.php");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql = "select * from solicitud INNER JOIN couchs ON couchs.id=solicitud.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE usuarios.nombredeusuario='".$_SESSION["usuario"]."' ORDER BY solicitud.estado='pendiente' DESC";
	$result=$conn->query($sql);
	?>
	<h1 align="center">Solicitudes a mis Couchs</h1> </br> </br>
	<table class="tablaTipos">
		<thead>
			<th >Couch</th>
			<th>Solicitante</th>
			<th>Estado</th>
			<th>Desde</th>
			<th>Hasta</th>
			<th>Cant. Personas</th>
			<th>Descripción</th>
			<th>Aceptar</th>
			<th>Rechazar</th>
		</thead>
		<?php
			while($row=$result->fetch_array()){
				echo '<tr>';
				echo '<td width="80%">'.utf8_encode($row["titulo"]). '</td>';
				echo '<td><a href="perfil.php?id='.utf8_encode($row["idusuario"]). '">'.utf8_encode($row["idusuario"]). '</a></td>';
				echo '<td>'. utf8_encode($row['estado']). '</td>';
				echo '<td>'. date('d/m/y', strtotime(utf8_encode($row['inicio']))). '</td>';
				echo '<td>'. date('d/m/y', strtotime(utf8_encode($row['fin']))). '</td>';
				echo '<td>'. utf8_encode($row['personas']). '</td>';
				echo '<td>'. utf8_encode($row['4']). '</td>';
				if($row["estado"]=='pendiente'){
					$ruta= 'aceptarSolicitud.php?id='.$row[0].'&idcouch='.utf8_encode($row['idcouch']).'&inicio='.utf8_encode($row['inicio']).'&fin='.utf8_encode($row['fin']);
        			echo '<td align="center"><button onclick="aceptar(\''.$ruta.'\')">Aceptar</button></td>';
        			$ruta= 'rechazarSolicitud.php?id='.$row[0];
        			echo '<td align="center"><button onclick="rechazar(\''.$ruta.'\')">Rechazar</button></td>';
				}
				else{
					echo '<td></td>';
					echo '<td></td>';
				}
				echo '</tr>';   
			}
				?>
	</table>
		
</body>
</html>
