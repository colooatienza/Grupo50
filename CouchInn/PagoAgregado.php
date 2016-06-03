<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CouchInn</title>
</head>
<body>
	<?php
	include("verificarUsuario.php");
	
    function validar(){
        if (!isset($_POST['monto'])|| strlen(str_replace(' ','',$_POST['monto']))==0){
            return false;
        }
		if (!isset($_POST['tarjeta'])|| strlen(str_replace(' ','',$_POST['tarjeta']))==0){
            return false;
        }
        return true;
    }
	
    if (validar()){
		include("conexion.php");
		
		
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "Insert INTO pagos (usuario, monto, tarjeta) VALUES ('".$_SESSION['usuario']."', '".$_POST['monto']."', '".$_POST['tarjeta']."') ";
		$conn->query($sql);
		$sql = "UPDATE usuarios set destacado = 1 WHERE nombredeusuario= '".$_SESSION['usuario']."' ";
		$conn->query($sql);
		$_SESSION['premium'] = true;
		echo $_SESSION['premium'];
		
		
		

		echo '<h4 align="center"> Felicitaciones! Ahora usted es Usuario Premium! </h4>';
		echo '<a href="index.php">Volver al inicio</a>';
		header( "refresh:3; url=index.php" );
   }
   else {
   		echo 'Los datos ingresados son inválidos, reintentar...';
   }
?>
</body>
</html>