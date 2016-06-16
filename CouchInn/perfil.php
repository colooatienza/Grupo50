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
		echo'</br></br></br></br></br><div class="divTipo">';
		$sql = "Select * from usuarios where nombredeusuario='".$_GET['id']."' ";
		$result=$conn->query($sql);
		if(mysqli_num_rows($result)==1){
			if($row=$result->fetch_array()){
				echo'<p><b>'.$_GET['id'].'</p>';
				if($row["foto"]!="")
        			echo'<div style="width:200px; height:150px"> <img src="'.$row["foto"].'"  class="img-responsive"> </div>';
				echo'<p> Sexo: '.$row['sexo'].'</p>';
				echo'<p> Nacimiento: '.date('d/m/y', strtotime(utf8_encode($row['fechadenacimiento']))).'</b></p>';
			}
		}
		$sql = "Select AVG(puntuacion) as calif from usuarios INNER JOIN couchs ON couchs.usuario=usuarios.nombredeusuario INNER JOIN calificaciones ON calificaciones.idusuario=nombredeusuario where nombredeusuario='".$_GET['id']."' AND calificaciones.tipo='viajero' GROUP BY nombredeusuario";
		$result=$conn->query($sql);
		if(mysqli_num_rows($result)==1){
			if($row=$result->fetch_array()){
				echo'<h5> Calificacion como viajero</h5>';
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
						echo'<p>Aún no tiene calificaciones como viajero</p>';

		}
				$sql = "Select AVG(puntuacion) as calif from usuarios INNER JOIN couchs ON couchs.usuario=usuarios.nombredeusuario INNER JOIN calificaciones ON calificaciones.idusuario=nombredeusuario  where nombredeusuario='".$_GET['id']."' AND calificaciones.tipo='coucher' GROUP BY nombredeusuario";
		$result=$conn->query($sql);
		if(mysqli_num_rows($result)==1){
		echo'<h5> Calificacion como Coucher</h5>';
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
						echo'<p>Aún no tiene calificaciones como Coucher</p>';

		}
   		echo'</div>';
	?>

</body>
</html>