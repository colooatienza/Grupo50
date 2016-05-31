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

$sql = "select * from paises ";
$result=$conn->query($sql);




  

?>

 <div id="apDiv2"><span class="logo"><img src="images/logo.png" width=160px; height=40px;></span> <span class="decorado"><img src="images/casas.png" width=200px; height=40px;> </span></div>
<div id="apDiv3"></div>
</head>

<body onload="nobackbutton();">
   <?php

 for ($i = 1; $i <= 8; $i++) {
   $evalua_campos[$i]="\"registro_ant > color_gris\"";
   }  $i=1;
     $tipo="password";
	 $tipo2="password";
	 $usuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario']:"Nombre de usuario";
	 $clave = isset($_POST['clave']) ? $_POST['clave']:"Clave";
     $clave2 = isset($_POST['clave2']) ? $_POST['clave2']:"Repetir clave";
	 $fecha = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento']:"dd/mm/aaaa";
	 $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad']:"";
	 
	 $m = isset($_POST['m']) ? $_POST['m']:false;
	 $f = isset($_POST['f']) ? $_POST['f']:false;
	  if($m==false && $f==false) $m=true;
	 $sexo="Masculino";
	 if($m==true){
		 $sexo=$sexo;
		 }
	  if($f==true){
		 $sexo="Femenino";
		 }

	 
	 $usuario_viejo=$usuario;
	 $usuario = addslashes(utf8_decode($usuario)); 
     $clave=addslashes(utf8_decode($clave));
	 $clave2=addslashes(utf8_decode($clave2));
	 
	
	 if($clave=="Clave"){
		 $tipo="text";
		 }
	  if($clave2=="Repetir clave"){
		 $tipo2="text";
		 }
	
	
	  $usuario_vacio="";   $clave_vacio="";  $clave_vacio2=""; $fecha_vacio;
	
	
	  $reg_us = isset($_GET['reg_us1']) ? $_GET['reg_us1']:0;
	
	  
	  	if($reg_us==1){
		  	   $valido_todo=true;
		  if($usuario=="Nombre de usuario"){
			   $evalua_campos[1]="\"registro_ant > color_rojo\"";
			   $usuario_vacio="Tiene que poner su nombre de usuario";
			    $valido_todo=false;
			  }else{
				  if(strlen($usuario)<6){
					  $evalua_campos[1]="\"registro_ant > color_rojo\"";
					  $usuario_vacio="  El usuario debe tener al menos 6 caracteres";
					  $valido_todo=false;
					  } 
					  else{
						 $sql2 = "select * from usuarios2 where nombredeusuario='".$usuario."'";
                          $result2=$conn->query($sql2);
						  $cant = $result2->num_rows;
						  if($cant!=0){
						  $evalua_campos[1]="\"registro_ant > color_rojo\"";	  
					      $usuario_vacio="  Ya existe el nombre de usuario., use un nombre distinto";
					      $valido_todo=false;
					   		  }
						
						  }
			 }
		  
		  
		  if($clave=="Clave"){
			   $evalua_campos[2]="\"registro_ant > color_rojo\"";
			   $clave_vacio="Tiene que poner su clave";
			   $valido_todo=false;
			  }else{
				  if(strlen($clave)<6){
					  $evalua_campos[2]="\"registro_ant > color_rojo\"";
					  $clave_vacio="  La clave tiene que tener al menos 6 caracteres";
					  $valido_todo=false;
					  } 
			   else{
				    if($clave!=$clave2){
						  $evalua_campos[3]="\"registro_ant > color_rojo\"";
					      $clave_vacio2="  Las claves tienen que ser iguales";
						  $valido_todo=false;
						}
				   }
			 }
			
			
			 
		    if($fecha==""){
			    $evalua_campos[4]="\"registro_ant > color_rojo\"";
				 $fecha_vacio="  La fecha tiene que ser válida";
                 $valido_todo=false;
			  }else{
			 
				 $esto= substr($fecha, -12, 4);
                  if($esto<1900 || $esto>2014){
					   $evalua_campos[4]="\"registro_ant > color_rojo\"";
				       $fecha_vacio="  La fecha tiene que ser válida";
					   $valido_todo=false;
					  }
				  } 
		  if($valido_todo==true){
			
			
			
			
			$sql2 = ("INSERT INTO usuarios2(nombredeusuario, clave, nacionalidad, fechadenacimiento,sexo) VALUES ('$usuario', '$clave','$nacionalidad','$fecha','$sexo')");
            $result=$conn->query($sql2);
			
			  header('Location: registrarUsuario2.php?us='.$usuario_viejo.'');
		  
		  }
		
		} 
   
   
    ?>
    
   
    
    <div class="container">
<div class="posicion_registo_usuario" >
 <span class="titulo">Registrando Usuario</span>
<form method="post" action="registrarUsuario1.php?reg_us1=1"  name="registro"  ENCTYPE="multipart/form-data" >
  <p>
    
    <input type="text" id="nombre_usuario" name="nombre_usuario" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'Nombre de usuario','text');" onfocus="vaciar_nombre(this,'Nombre de usuario','text')" onkeypress="return sin_espacio(event);" value="<?php echo $usuario; ?>"/> 
    (min 6 letras)  
  <p>
       <span class="rojo"><?php  echo $usuario_vacio; ?> </span>
    <p>
  
         <input type="<?php echo $tipo; ?>" id="clave" name="clave" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'Clave','text');" onfocus="vaciar_nombre(this,'Clave','password')" onkeypress="return sin_espacio(event);" value="<?php echo $clave; ?>"/>  
         (min 6 letras)
    <p>
       <span class="rojo"><?php echo $clave_vacio; ?> </span>
    <p>
         
         
         <input type="<?php echo $tipo2; ?>" id="clave2" name="clave2" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'Repetir clave','text');" onfocus="vaciar_nombre(this,'Repetir clave','password')" onkeypress="return sin_espacio(event);" value="<?php echo $clave2; ?>"/>              
    <p>
       <span class="rojo"><?php echo $clave_vacio2; ?> </span>
    <p>
    
      <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class=<?php echo $evalua_campos[$i]; $i++;?>  value="<?php echo $fecha; ?>"/>  
    Fecha de nacimiento.</p>
  <p>
  
    <select name="nacionalidad" size="1" class=<?php echo $evalua_campos[$i]; $i++;?>>
        <?php while($row=$result->fetch_array()) { 
            echo "<option name=pais value=".$row['nombre']." selected=\"selected\">".htmlentities($row['nombre'] )."</ option>"; } ?>
        <option selected>Argentina</option>
      </select> 
    Nacionalidad.
  <p>  
  <p>
  Sexo:
    <input type="radio"  name="m";  id="m" <?php if($m==true){echo " checked";} ?>    onclick="seleccionar(this)" /> 
           Masculino &nbsp;&nbsp; 
            <input type="radio"   name="f";  id="f" <?php if($f==true){echo " checked";} ?>    onclick="seleccionar(this)" />
Femenino</p>
  <p>&nbsp;</p>
    <input type="button" class="boton_esto"  id="enviar" onClick="validar_campos()"  value="Siguiente" />
    
           <p>&nbsp;</P><hr><p>
</form>
     
       <input type="button" class="boton_cancela"  id="cancela" onClick="seguro('consultaUsuarios.php')"  value="Cancelar Registro" />
    <span class="numeros">Página 1 de 2</span>
</div>

<br><br>
 <hr>
</div>

<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>