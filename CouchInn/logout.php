<?php   
session_start(); //asegurar que estas usando la misma sesion
session_destroy(); //elimina la sesion
header("location:index.php"); 
exit();
?>
