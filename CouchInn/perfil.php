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
		include("verificarUsuario.php");
		include("conexion.php");
		include("menu.php");

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		echo'</br></br></br></br></br><div class="divTipo" style="width:400px; margin-bottom:30px">';
		$sql = "Select * from usuarios where nombredeusuario='".$_GET['id']."' ";
		$result=$conn->query($sql);
		if(mysqli_num_rows($result)==1){
			if($row=$result->fetch_array()){
				echo'<p><b>'.$_GET['id'].'</p>';
				if($row["foto"]!=""){    
					?><img src="images/usuario/<?php echo $row["foto"];?>?<?php echo time();?>" class="img-responsive" width="180"> <?php }
                 
				    
		
				echo'<p> Sexo: '.$row['sexo'].'</p>';
				echo'<p> Nacimiento: '.date('d/m/Y', strtotime(utf8_encode($row['fechadenacimiento']))).'</b></p>';
				echo'<p><b>e-Mail: </b>'.utf8_encode($row['mail']).'</b></p>';
				if($row['destacado']==1)
				   echo'<p><div style="color:#E90"> (Destacado) </div></p>';
			}
		} echo '<br>';
		$sql = "Select AVG(puntuacion) as calif from usuarios INNER JOIN calificaciones ON calificaciones.calificado=nombredeusuario where nombredeusuario='".$_GET['id']."' AND calificaciones.tipo='coucher' GROUP BY nombredeusuario";
		$result=$conn->query($sql);
		if(mysqli_num_rows($result)==1){
			if($row=$result->fetch_array()){
				echo'<h5> Calificación como Coucher :</h5>';
				for($i=1;$i<=5;$i++)
					if($row['calif']<$i)
						echo'<span style="font-size:200%">☆</span>';
					else
						echo'<span style="font-size:200%">★</span>';

			}
			else{
				//header("Locaion: index.php")
			}
		}
		else{
						echo'<p>Aún no tiene calificaciones como Coucher</p>';

		}
				$sql = "Select AVG(puntuacion) as calif from usuarios INNER JOIN calificaciones ON calificaciones.calificado=nombredeusuario  where nombredeusuario='".$_GET['id']."' AND calificaciones.tipo='viajero' GROUP BY nombredeusuario";
		$result=$conn->query($sql);
		if(mysqli_num_rows($result)==1){
		echo'<h5> Calificación como Viajero :</h5>';
			if($row=$result->fetch_array()){
				for($i=1;$i<=5;$i++)
					if($row['calif']<$i)
						echo'<span style="font-size:200%">☆</span>';
					else
						echo'<span style="font-size:200%">★</span>';

			}
			else{
				//header("Locaion: index.php")
			}
		}
		else{
						echo'<p>Aún no tiene calificaciones como Viajero</p>';

		}
   		echo'</div>';
   			$sql = "Select calificador, resenia, tipo from calificaciones where calificado='".$_GET['id']."' order by tipo,id desc LIMIT 10";
		$result=$conn->query($sql);
		echo'<div class="divTipo" style="width:400px;">';
		echo'<h4> Últimas 10 reseñas:</h4>';
         $tipoViejo='';
		while($row=$result->fetch_array()){
			    
				if($row['tipo']!=$tipoViejo){
				echo '<b> Como '.$row['tipo'].'</b><br><br>';
				$tipoViejo=$row['tipo'];
				}
				
				echo '<b>'.$row[0].':</b>  '.$row[1].'</br>' ;

			}

   		echo'</div>';
	?>

</body>
</html>