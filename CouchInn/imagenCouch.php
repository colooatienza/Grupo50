<?php

if(isset($_GET['id'])) {  $sql="select * from fotos where id=".$_GET['id']."";
  
   
   }else{ $sql=null;}

   include("conexion.php");

if (mysqli_connect_errno()) {
    die("Error al conectar: ".mysqli_connect_error());
	
}
 
# Buscamos la imagen a mostrar

$result=$conn->query($sql);

$row=$result->fetch_array();


//$row=$result->fetch_array(MYSQLI_ASSOC);"
 
# Mostramos la imagen
header("Content-type:".$row["tipo"]);
echo $row["foto"];

?>
