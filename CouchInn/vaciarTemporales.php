<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>


<?php

//Eliminar temporales 

 
$lista_archivos;  
$i=0;

$directorio=opendir("./images/temporales");  
//se leen 2 archivos que valen . y ..
$archivo = readdir($directorio);
$archivo = readdir($directorio);



while ($archivo = readdir($directorio)) {  
     
 $archivo=utf8_encode($archivo);
 if ((strpos($archivo,$_SESSION['usuario'])==true))
     echo $archivo."<BR>";
	 //  unlink("images/temporales/".$archivo);
}  
?>


<body>
</body>
</html>