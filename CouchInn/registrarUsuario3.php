<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrar Usuario</title>


<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
</style>

<?php
	//include("file:///C|/wamp/www/verificarUsuario.php");
   include("conexion.php");
		
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
   $user_name = isset($_POST['usss']) ? $_POST['usss']:"";
   //$user_name =base64_decode( $user_name);
$sql = "select * from usuarios where nombredeusuario='".utf8_decode($user_name)."'";
$result=$conn->query($sql);

$funcion = isset($_GET['tipo']) ? $_GET['tipo']:"1";

$titulo_prin="Usted se registró exitósamente:";
if($funcion==2){
	$titulo_prin="Se modificaron los datos exitósamente:";
	}

?>
 <div id="apDiv2"><span class="logo"><img src="images/logo.png" width=160px; height=40px;></span> <span class="decorado"><img src="images/casas.png" width=200px; height=40px;> </span></div>
<div id="apDiv3"></div>
</head>

<body onload="nobackbutton();">

   <?php  ?>
   
      <div class="container">
   <div class="posicion_registo_usuario" id="apDiv1" >
    <span class="titulo"> <a href="consultaUsuarios.php"><img src="images/correcto.gif" width="20" height="20" alt="c" /></a><?php echo $titulo_prin;?> </span>     </p>
     <p><a href="consultaUsuarios.php" class="d"> | Volver a la página principal |</a>
       <?php   while($row=$result->fetch_array(MYSQLI_BOTH)){  ?> 
     </p>
     <table width="485" border="0" style="position: relative; left: -25px; border:none;" >
     <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr>
       <tr>
    <td width="230">Nombre de usuario:</td>
    <td width="239"><?php  echo utf8_encode($row["nombredeusuario"]); ?></td>
   
</tr>
  <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr> 
  <tr>
    <td>Clave de usuario:</td>
    <td><?php  echo utf8_encode($row["clave"]);?></td>
  </tr>
    <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr> 
   
  <tr>
    <td>Fecha de nacimiento:</td>
    <td><?php  echo utf8_encode($row["fechadenacimiento"]);?></td>
  </tr>
   <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr> 
    <tr>
    <td>Sexo:</td>
    <td><?php  echo utf8_encode($row["sexo"]); ?></td>
  </tr>
   <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr> 
  <tr>
    <td>Nacionalidad:</td>
    <td><?php

$sql_n=$conn->query("select * from paises where id=".$row['nacionalidad']."");
      $consulta_nac=$sql_n->fetch_array(MYSQLI_BOTH);
	
	  echo utf8_encode($consulta_nac['nombre']); ?></td>
  </tr>
  <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr>
  <tr>
    <td>e-Mail:</td>
    <td><?php  echo utf8_encode($row["mail"]); ?></td>
  </tr>
  <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr>
  <tr>
    <td>Teléfono fijo:</td>
    <td><?php  echo utf8_encode($row["telefono"]); ?></td>
  </tr>
  <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr>
  <tr>
    <td>Teléfono móvil:</td>
    <td><?php  echo utf8_encode($row["celular"]); ?></td>   
  </tr>
  <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr>
  <tr>
    <td valign="bottom">Imagen de perfil:</td>
      <td>
       
   <?php
     $directorio_foto=$row["foto"];

   
    echo '<img src="'.$directorio_foto.'""  style="max-width:150px; max-height:150px;    min-height:110px; " onerror="this.src=\'images/sin_imagen.png\'">'; ?> </td>
</tr>
<tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr>
  <tr>
    <td>Descripción personal:</td>
    <td><?php  echo utf8_encode($row["descripcion"]); ?></td>
  </tr>
 <tr> <td colspan="2"><hr class="linea_tabla"></td>  </tr>
  
 
</table>
     <p>
       <?php } ?>
     </p>
     <p><br>
       <br>
     </p>
     
</div>
 
<br><br>
 <hr>
</div>

<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>