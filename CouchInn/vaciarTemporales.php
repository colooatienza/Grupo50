<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>


<?php

//Eliminar temporales y moverlos a permanentes


$total_imagenes = count(glob("images/temporales/{*.jpg,*.gif,*.png,*.bmp}",GLOB_BRACE));
//echo "total_imagenes = ".$total_imagenes;
  
 
$lista_archivos;  
$i=0;
$directorio=opendir("./images/temporales");  
//se leen 2 archivos que valen . y ..
$archivo = readdir($directorio);
$archivo = readdir($directorio);



while ($archivo = readdir($directorio)) {  
     
//echo "<BR>".$archivo; 
//$archivo_cortado= substr($archivo,3 );
//echo $archivo_cortado.'<br>';
//rename ("./images/temporales/".$archivo."","./images/permanentes/".$archivo_cortado."");
 $archivo=utf8_encode($archivo);
 if ((strpos($archivo,'colooatienza')==true))
     echo $archivo."<BR>";
	 //  unlink("images/temporales/".$archivo);
}  
?>


<body>
</body>
</html>