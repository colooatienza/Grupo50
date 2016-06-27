<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <title>CouchInn</title>
  <link rel="stylesheet" href="Css/c.css">
  	<link rel="icon" href="images/logo.jpg">
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
	<?php
	include("verificarUsuario.php");
	
	function validar(){
        if (!isset($_POST['titulo'])|| strlen(str_replace(' ','',$_POST['titulo']))==0){
            return false;
        }
        if (!isset($_POST['direccion'])|| strlen(str_replace(' ','',$_POST['direccion']))==0){
            return false;
        }
        if (!isset($_POST['tipo'])|| strlen(str_replace(' ','',$_POST['tipo']))==0){
            return false;
        }
        if (!isset($_POST['provincia'])|| strlen(str_replace(' ','',$_POST['provincia']))==0){
            return false;
        }
        if (!isset($_POST['fechainicio'])){
            return false;
        }
        if (!isset($_POST['fechafin'])){
            return false;
        }
        if ($_FILES['fotos']['size'] == 0)
            return false;
        if (!isset($_POST['descripcion'])|| strlen(str_replace(' ','',$_POST['descripcion']))==0){
            return false;
        }
        return true;
    }
	?>

	<?php
    //if (validar()){
		include("menu.php");
		include("conexion.php");
		
		
		// Check connection
		/*if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

  $sql = "select * from solicitud INNER JOIN couchs ON couchs.id=solicitud.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE usuarios.nombredeusuario='".$_SESSION["usuario"]."' ORDER BY solicitud.estado='pendiente' DESC";
  $result=$conn->query($sql);
  if(mysqli_num_rows($result)>0){
    echo' </br> </br> </br>';
    echo'<div class="divTipo">';
    echo '<h4 align="center">Tiene calificaciones pendientes! Califique para agregar nuevo Couch!</h4>';
    echo'</div>';
  }
  else{
		$sql = "INSERT INTO `couchs`(`titulo`, `descripcion`, `fechafin`, `fechainicio`, `direccion`, `disponible`, `ciudad`, `usuario`, `idtipo`) 
		VALUES (".$_POST['titulo'].",".$_POST['descripcion'].",".$_POST['fecha_fin'].",".$_POST['fecha_inicio'].",".$_POST['direccion'].",1,0,".$_SESSION['nombredeusuario'].",".$_POST['tipo'].")";
		$conn->query($sql);*/
		echo' </br> </br> </br>';
		echo'<div class="divTipo">';
		echo '<h4 align="center">Se ha agregado correctamente su Couch!</h4>';
		echo'</div>';
 /* }
   }
   else {
   	echo 'Los datos ingresados son inválidos, reintentar...';
   }*/
?>

</body>
</html>
