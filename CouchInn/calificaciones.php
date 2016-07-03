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
	function confirmar(id) {
		if(confirm("Realmente desea eliminar?")){
			window.location.href = "borrarTipo.php?id="+id;
		}
	}
	</script>
</head>
<body>
	<?php
  include("verificarUsuario.php");
  include("menu.php");
  include("conexion.php");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql = "SELECT * FROM solicitud INNER JOIN couchs ON couchs.id=solicitud.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE solicitud.idusuario='".$_SESSION["usuario"]."' AND estado = 'aceptado' AND solicitud.fin<CURDATE()";
	$result=$conn->query($sql);
	
    
	echo '<hr><h1 align="center">Calificar a Couchers<hr></h1>';
	
	
		 if($result->num_rows!=0){
                 $sumarCantidad=0;
				 $cantidadTotal=$result->num_rows;
			while($row=$result->fetch_array()){
				$sql = "SELECT * FROM calificaciones WHERE tipo = 'coucher' AND calificador ='".$_SESSION["usuario"]."'  and idcouch = ".$row["idcouch"];
				$r=$conn->query($sql);
                
				if(!$r->fetch_array()){
				echo '<table class="tablaTipos"><thead>';
			    echo '<th >Couch</th><th>Coucher</th><th>Puntuación</th>';
			    echo '<th>Reseña</th><th>Calificar</th></thead>';
                echo '<tr>';
				echo '<form method="post" action="calificar.php">';
				echo '<td width="80%">'.utf8_encode($row["titulo"]). '</td>';
				echo '<td><a href="perfil.php?id='.utf8_encode($row['usuario']). '">'.utf8_encode($row["usuario"]). '</a></td>';
				echo '<td> <input type="number" name="puntuacion" id="puntuacion" min="1" max="5" value="5"> </td>';
				echo '<td> <input type="text" name="resena" id="resena" maxlength="50"> </td>';
				echo '<td> <input type="submit" value="Calificar"> </td>';
				echo ' <input type="hidden" name="tipo" id="tipo" value="coucher">';
				echo '<input type="hidden" name="idusuario" id="idusuario" value='.$row["usuario"].'>';
				echo '<input type="hidden" name="idcouch" id="idcouch" value='.$row["idcouch"].'>';
				echo '</form></tr></table>';
				
				}else{ $sumarCantidad=$sumarCantidad+1;}
			}
			 if($cantidadTotal==$sumarCantidad) {
					 echo "<h2 align='center'><span style='font-size:18px; color:#999;'>";
                     echo "No tienes Couchers para Calificar</h2><br>"; 
				}
			
			
			}else{
				 echo "<h2 align='center'><span style='font-size:18px; color:#999;'>";
                     echo "No tienes Couchers para Calificar</h2><br>"; 
				}
		?>
	

	</br> </br>






	<h1 align="center"><hr>Calificar a Viajeros<hr></h1> 
	<?php
		$sql = "SELECT * FROM solicitud INNER JOIN couchs ON couchs.id=solicitud.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE usuarios.nombredeusuario='".$_SESSION["usuario"]."' AND solicitud.fin<CURDATE() and estado='aceptado'";
	$result=$conn->query($sql);
             
	       if($result->num_rows!=0){
	              $sumarCantidad=0;
				 $cantidadTotal=$result->num_rows;
				 
			while($row=$result->fetch_array()){
				$sql = "SELECT * FROM calificaciones WHERE tipo = 'viajero' AND calificador ='".$_SESSION["usuario"]."' and calificado='".$row["idusuario"]."' AND idcouch = ".$row["idcouch"];
				
				$r=$conn->query($sql);
				if(!$r->fetch_array()){
		 		
	    	echo '<table class="tablaTipos"><thead>
			<th >Couch</th><th>Viajero</th><th>Puntuación</th>
			<th>Reseña</th><th>Calificar</th></thead>';		
			echo '<tr><form method="post" action="calificar.php">';
			echo '<td width="80%">'.utf8_encode($row["titulo"]). '</td>';
			echo '<td><a href="perfil.php?id='.utf8_encode($row['idusuario']). '">'.utf8_encode($row["idusuario"]). '</a></td>';
					echo '<td> <input type="number" name="puntuacion" id="puntuacion" min="1" max="5" value="5"> </td>';
					echo '<td> <input type="text" name="resena" id="resena" maxlength="50"> </td>';
					echo '<td> <input type="submit" value="Calificar"> </td>';
					echo '<input type="hidden" name="tipo" id="tipo" value="viajero">';
					echo '<input type="hidden" name="idusuario" id="idusuario" value='.$row["idusuario"].'> ';
					echo '<input type="hidden" name="idcouch" id="idcouch" value='.$row["idcouch"].'> ';
					echo '</form>';
					echo '</tr>	</table>';   
				}else{ $sumarCantidad=$sumarCantidad+1;}
			}
			 if($cantidadTotal==$sumarCantidad) {
					 echo "<h2 align='center'><span style='font-size:18px; color:#999;'>";
                     echo "No tienes Viajeros para Calificar</h2><br>"; 
				}
			
			
			}else{
				 echo "<h2 align='center'><span style='font-size:18px; color:#999;'>";
                     echo "No tienes Viajeros para Calificar</h2><br>"; 
				}

      ?>
</body>
</html>
