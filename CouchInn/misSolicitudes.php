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
	
	$sql = "select * from solicitud INNER JOIN usuarios ON solicitud.idusuario=usuarios.nombredeusuario inner join couchs on solicitud.idcouch=couchs.id inner JOIN fotos ON couchs.id = fotos.idcouch where usuarios.nombredeusuario='".$_SESSION['usuario']."' and fin > Curdate() GROUP BY solicitud.id";
	$result=$conn->query($sql);
	$filas=$result->num_rows;
	echo '<h1 align="center"><hr>Mis Solicitudes<hr></h1>';
   
         if($filas==0){
       echo "<h2 align='center'><span style='font-size:18px; color:#999;'>Todavía no Solicitaste</h2>";
	   echo "<br><br><br>"; 
	 
	 
	 }else{ 
      ?>
    <table width="1000" align="center" bordercolor="#CCCCCC" border="1px solid" >
		<thead>
			<th class="back">Couch</th>
			
			<th class="back">Foto</th>
			<th class="back">Desde</th>
			<th class="back">Hasta</th>
            <th class="back">Cant. personas</th>
			<th  class="back">Respuesta</th>
		</thead>
		<?php
		    $tituloViejo='';
			echo $tituloViejo;
			while($row=$result->fetch_array()){
				echo '<tr>';

				   echo '<td  class="separados">'.utf8_encode($row["titulo"]).'</td>';	    
			       echo '<td  class="separados">';	
			           	
		?> <img src="images/couch/<?php echo $row["link"];?>?<?php echo time();?>"  style="max-width:100px; max-height:100px;"> <?php
				echo '</td>';
				
				echo '<td  class="separados">'. date('d/m/y', strtotime(utf8_encode($row['inicio']))). '</td>';
				echo '<td  class="separados">'. date('d/m/y', strtotime(utf8_encode($row['fin']))). '</td>';
				
				echo '<td  class="separados">'.$row['personas']. '</td>';
			    
				 
				  
					
					 echo '<td   class="separados">';
					 
					 
					 if($row['estado']=='aceptado')
					  echo '<span style="color:#FB0; font-size:16px;">';
					 if($row['estado']=='rechazado')
					  echo '<span style="color:#E20; font-size:16px;">'; 
					 
					 echo $row['estado'].'</span></td>';
					
				
				echo '</tr>'; 
				
			}
				?>
	</table>
    <?php  } ?>
		 <br><br>
         <br>
</body>
</html>
