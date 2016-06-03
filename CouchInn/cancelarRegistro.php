<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.ddf {
	color: #F00;
}
</style>
</head>

<body onload="nobackbutton();">

<p>
  <?php

   include("conexion.php");
		

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$user_name = isset($_GET['us']) ? $_GET['us']:"";
$sql = "delete from usuarios2 where nombredeusuario='".$user_name."'";
$result=$conn->query($sql);
?>
  <span class="ddf">Cancelando Registro...</span>
</p>
<p>&nbsp;</p>
  <?php
  
   header('Location: consultaUsuarios.php');  ?>
   <script language="javascript" src="registrarUsuario.js"></script>
</body>
</html>