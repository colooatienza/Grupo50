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
	?>
	<h1 align="center"><hr>Preguntas Pendientes<hr></h1>
	<?php
	  //Las preguntas y las respuestas
		$sql = "SELECT * FROM comentarios INNER JOIN couchs ON couchs.id=comentarios.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE couchs.usuario='".$_SESSION["usuario"]."' AND idcomentario IS NULL";
		
	  $sql_res = "SELECT * FROM comentarios INNER JOIN couchs ON couchs.id=comentarios.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE couchs.usuario='".$_SESSION["usuario"]."' AND idcomentario IS not NULL";	
		
	$result=$conn->query($sql);
	$filas=$result->num_rows;
	
	$resp=$conn->query($sql_res);
	$resp=$resp->num_rows;
 
              if($filas-$resp == 0){
       echo "<h2 align='center'><span style='font-size:18px; color:#999;'>No tienes preguntas Pendientes</h2>";
	   echo "<br><br><br>"; 
	  
	 
	 }else{      ?>
    
	<table class="tablaTipos">
		<thead>
			<th >Couch</th>
			<th>Usuario</th>
			<th>Pregunta</th>
			<th>Respuesta</th>
			<th>Enviar</th>
		</thead>
		<?php 
			while($row=$result->fetch_array()){
				$sql = "SELECT * FROM comentarios WHERE idcomentario=".$row['0'];
				$r=$conn->query($sql);
				if(!$r->fetch_array()){
					echo '<tr>';
					echo '<form method="post" action="responder.php">';
					echo '<td>'.utf8_encode($row["titulo"]). '</td>';
					echo '<td><a href="perfil.php?id='.utf8_encode($row[2]). '">'.utf8_encode($row[2]). '</a></td>';
					echo '<td>'.utf8_encode($row["texto"]). '</td>';
					echo '<td> <input type="text" name="respuesta" id="respuesta" maxlength="50" style="width:500px"> </td>';
					echo '<td> <input type="submit" value="Responder"> </td>';
					echo '<input type="hidden" name="idcouch" id="idcouch" value='.$row[5].'>';
					echo '<input type="hidden" name="idcomentario" id="idcomentario" value='.$row[0].'>';
					echo '</form>';
					echo '</tr>';   
				}
			}
				?>
	</table>
    <?php }  ?>
</body>
</html>
