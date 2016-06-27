<!DOCTYPE HTML>
<html>
<head>
  
  	<meta charset="UTF-8">
  	<title>CouchInn</title>

<style>
.separados{
  margin: 10px;
  padding: 10px;
  text-align-last:center;
	}	
	.back{
		 text-align-last:center;
		background:#DDF;
		}
</style>


<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
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
	
	$sql = "select * from solicitud INNER JOIN couchs ON couchs.id=solicitud.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE usuarios.nombredeusuario='".$_SESSION["usuario"]."' and estado!='rechazado' order by couchs.id,estado ";
	$result=$conn->query($sql);
	$filas=$result->num_rows;    
	
	echo '<h1 align="center"><hr>Solicitudes a mis Couchs<hr></h1>';
      
       if($filas==0){
       echo "<h2 align='center'><span style='font-size:18px; color:#999;'>Todavía no tienes ninguna Solicitud</h2>";
	   echo "<br><br><br>"; 
	 
	 
	 }else{      ?>
      
      <table width="1000" align="center" bordercolor="#CCCCCC" border="1px solid" >
		<thead>
			<th class="back">Couch</th>
			
			<th class="back">Solicitante</th>
			<th class="back">Desde</th>
			<th class="back">Hasta</th>
			<th class="back">Cant. Personas</th>
			<th class="back">Descripción</th>
			<th class="back">Aceptar</th>
			<th class="back">Rechazar</th>
		</thead>
		<?php
		    $tituloViejo='';
			echo $tituloViejo;
			while($row=$result->fetch_array()){
				echo '<tr>';
				
				if(utf8_encode($row["titulo"])!= $tituloViejo){
				   echo '</tr><tr><td colspan="8"><br><br>&nbsp;'.utf8_encode($row["titulo"]).'<br></td></tr><tr>';
				 
				}
				    
				$tituloViejo= utf8_encode($row['titulo']);   
				
				echo '<td colspan=2  class="separados"><a href="perfil.php?id='.utf8_encode($row["idusuario"]). '">'.utf8_encode($row["idusuario"]). '</a></td>';
				
				echo '<td  class="separados">'. date('d/m/y', strtotime(utf8_encode($row['inicio']))). '</td>';
				echo '<td  class="separados">'. date('d/m/y', strtotime(utf8_encode($row['fin']))). '</td>';
				echo '<td  class="separados">'. utf8_encode($row['personas']). '</td>';
				echo '<td  class="separados">'. utf8_encode($row['4']). '</td>';
			
				if($row["estado"]=='pendiente'){
					$ruta= 'aceptarSolicitud.php?id='.$row[0].'&idcouch='.utf8_encode($row['idcouch']).'&inicio='.utf8_encode($row['inicio']).'&fin='.utf8_encode($row['fin']).'&idusuario='.utf8_encode($row['idusuario']);
        			echo '<td  class="separados"><button onclick="aceptar(\''.$ruta.'\')">Aceptar</button></td>';
        			$ruta= 'rechazarSolicitud.php?id='.$row[0];
        			echo '<td  class="separados"><button onclick="rechazar(\''.$ruta.'\')">Rechazar</button></td>';
				}
				else{
					echo '<td colspan="2"  class="separados">'.$row['estado'].'</td>';
					
				}
				echo '</tr>'; 
				
			}
				?>
	</table>
     <?php } ?>
		 <br><br>
         <br>
</body>
</html>
