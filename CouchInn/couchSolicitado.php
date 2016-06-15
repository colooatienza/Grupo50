<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CouchInn</title>
<script src="js/jquery-1.11.3.min.js"></script> 
<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="Css/c.css">
  	<link rel="icon" href="images/logo.jpg">
</head>
<body>
	<?php
	include("verificarUsuario.php");
	
    function validar(){
        if (!isset($_POST['inicio'])){
            return false;
        }
        if (!isset($_POST['fin'])){
            return false;
        }
		if (!isset($_POST['descripcion'])|| strlen(str_replace(' ','',$_POST['descripcion']))==0){
            return false;
        }
		if (!isset($_POST['id'])|| strlen(str_replace(' ','',$_POST['id']))==0){
            return false;
        }
		if (!isset($_POST['personas'])|| strlen(str_replace(' ','',$_POST['personas']))==0){
            return false;
        }
        return true;
    }
	
    if (validar()){
		include("conexion.php");
		include("menu.php");
		
		echo'</br></br></br></br></br><div class="divTipo">';
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$inicio=$_POST['inicio'];
		$fin=$_POST['fin'];
$sql = "Select * from solicitud where estado= 'aceptado' AND idcouch='".$_POST['id']."' and ((fin BETWEEN '".$inicio."' AND '".$fin."') OR inicio BETWEEN  '".$inicio."'AND '".$fin."'  OR(('".$fin."' BETWEEN inicio AND fin) OR '".$inicio."' BETWEEN  inicio AND fin)) AND (inicio <> '".$fin."') AND (fin <> '".$inicio."') ";

		$result=$conn->query($sql);
		if(!$result){


		$sql = "INSERT INTO `solicitud`(`inicio`, `fin`, `personas`, `descripcion`, `estado`, `idcouch`, `idusuario`) VALUES ('".$_POST['inicio']."','".$_POST['fin']."','".$_POST['personas']."','".$_POST['descripcion']."', 'pendiente', '".$_POST['id']."', '".$_SESSION['usuario']."' ) ";
		$conn->query($sql);
		echo '<h4 align="center"> Ha solicitado el Couch exitosamente! </h4>';
		echo '<a href="index.php">Volver al inicio</a>';
		}
		else{
		echo '<h4 align="center"> El Couch se encuentra ocupado en la fecha solicitada! </h4>';
		}
   }
   else {
   		echo 'Los datos ingresados son inválidos, reintentar...';
   }
   echo'</div>';
?>
</body>
</html>