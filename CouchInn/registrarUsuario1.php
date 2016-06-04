<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrar Usuario</title>


<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
</style>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="icon" href="images/logo.jpg">



<body onload="nobackbutton();">
   <?php
	 session_start();
   include("conexion.php");
   include("menu.php");
		
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "select * from paises ";
	$result=$conn->query($sql);
	
    $nombre_nacion="Argentina";
 for ($i = 1; $i <= 9; $i++) {
   $evalua_campos[$i]="\"registro_ant > color_gris\"";
   }  $i=1;
     $tipo="password";
	 $tipo2="password";
	 
	 $usuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario']:"Nombre de usuario";
	 $clave = isset($_POST['clave']) ? $_POST['clave']:"Clave";
     $clave2 = isset($_POST['clave2']) ? $_POST['clave2']:"Repetir clave";
	 $fecha = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento']:"dd/mm/aaaa";
	 $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad']:13;
	 $email = isset($_POST['email']) ? $_POST['email']:"Email (con @extension. )";
	
	 $sql_nac = "select * from paises where id=$nacionalidad ";
     $result_nac=$conn->query($sql_nac);
	 $row_nac=$result_nac->fetch_array(MYSQLI_BOTH);
	 
	 $m = isset($_POST['m']) ? $_POST['m']:false;
	 $f = isset($_POST['f']) ? $_POST['f']:false;
	  if($m==false && $f==false) $m=true;
	 $sexo="Masculino";
	   $mail_mal="";
	 if($m==true){
		 $sexo=$sexo;
		 }
	  if($f==true){
		 $sexo="Femenino";
		 }

	 
	 $usuario_viejo=$usuario;
    
	
	 if($clave=="Clave"){
		 $tipo="text";
		 }
	  if($clave2=="Repetir clave"){
		 $tipo2="text";
		 }
	
	
	  $usuario_vacio="";   $clave_vacio="";  $clave_vacio2=""; $fecha_vacio;
	
	
	  $reg_us = isset($_POST['reg_us1']) ? 1:0;
	
	  
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
						 $sql2 = "select * from usuarios where BINARY nombredeusuario='".utf8_decode($usuario)."'";
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
				  
				  
		
     $cons_mail=("select * from usuarios where BINARY mail='".utf8_decode($email)."'");
                 $result_mail=$conn->query($cons_mail);
				 $cant_mail = $result_mail->num_rows;
				  if($cant_mail!=0){
				     $evalua_campos[6]="\"registro_ant > color_rojo\"";	  
					 $mail_mal="  Ya existe la dirección de mail nombre de usuario., use una distinta";
				$valido_todo=false;
					  }
		
		
   //compruebo unas cosas de E.MAIL
      $validando_mail=true;
     //Si sigue válido el todoo::::
	 if($valido_todo==true){
    if($email=="" || $email=="Email (con @extension. )"){
	           $evalua_campos[6]="\"registro_ant > color_rojo\"";
				       $mail_mal=" Falta la direccón de mail";		          
					   $valido_todo=false;
					   }else{
	  
	 
  
    //validar los pedazos de extension de E-MAIL:::::::::
	 function pedazo($i_viejo, $fin, $texto){
     $i=$i_viejo;
	 $letra= substr($texto, $i,1);	
	
	 while($letra!="" && $letra!=$fin){	
		$letra= substr($texto, $i,1);	
		$i++;
		
		}
		$i=$i-1;  
		if($i==$i_viejo) return "";
		
    return substr($texto,$i_viejo,$i-$i_viejo);
	}
  
  

    $texto= $email;  $i=0;
	$letra= substr($texto, 0,1); 
	$dominio= pedazo($i,'@',$texto);	
	$valido_mail = array('-','_','.'); 
	

   if ( ctype_alnum(str_replace($valido_mail, '', $dominio) )&& $dominio!=""){$i=$i;}else{   $validando_mail=false;}
  
    
	$i=strlen($dominio)+1;
	$dominio= pedazo($i,'.',$texto);
		
	$valido_mail = array('-'); 

    if( ctype_alnum(str_replace($valido_mail, '', $dominio) )&& $dominio!=""){$i=$i;}else{   $validando_mail=false;}
	 
	
	
    $i=$i+strlen($dominio)+1;
	
	while($i <= strlen($texto) ){
	
	$dominio= pedazo($i,'.',$texto);
		
    if( ctype_alnum(str_replace($valido_mail, '', $dominio) )&& $dominio!="" && strlen($dominio)<=4 && strlen($dominio)>=2){  }else{   $validando_mail=false;}
$i=$i+strlen($dominio)+1;
	}
					   }
     if($validando_mail==false ){
	        $evalua_campos[6]="\"registro_ant > color_rojo\"";
		     $mail_mal="El E-Mail está mal escrito";
			 $valido_todo=false;}
	 }

	     $i=1;

     if(strlen($usuario)>=29){
		  $evalua_campos[1]="\"registro_ant > color_rojo\"";
		     $usuario_vacio="El nombre de usuario es muy largo";
			 $valido_todo=false;}
	 
	  if(strlen($clave)>=29){
		  $evalua_campos[2]="\"registro_ant > color_rojo\"";
		     $clave_vacio="La clave es muy larga";
			 $valido_todo=false;}	 

	  if(strlen($email)>=49){
		  $evalua_campos[6]="\"registro_ant > color_rojo\"";
		     $mail_mal="El Email es muy largo";
			 $valido_todo=false;}
	
     
		 
	  if($valido_todo==true){

			$usuario = addslashes(utf8_decode($usuario)); 
            $clave=addslashes(utf8_decode($clave));
	        $clave2=addslashes(utf8_decode($clave2));
			$nacionalidad=addslashes(utf8_decode($nacionalidad));
	        $email = addslashes(utf8_decode($email)); 
			
			
			$sql2 = ("INSERT INTO usuarios(nombredeusuario, clave, nacionalidad, fechadenacimiento,sexo,mail) VALUES ('$usuario', '$clave','$nacionalidad','$fecha','$sexo','$email')");
            $result=$conn->query($sql2);
			$usuario_viejo= base64_encode($usuario_viejo);
  		?>
			<form method="post" name="regii" id="regii" action="registrarUsuario2.php"   ENCTYPE="multipart/form-data" >
			    <input type="hidden" name="usss" value="<?php echo $usuario;?>">
			</form>
          
         <script type="text/javascript"> document.regii.submit(); </script>  
           
        <?php
		
		
        //  echo "<body onload=\"document.regii.submit();\">";
   //header('Location:registrarUsuario2.php?us='.$usuario_viejo.'');
		  
		  }
		
		}
   
   
    ?>
    
   
    
    <div class="container">
<div class="posicion_registo_usuario" >
 <span class="titulo">Registrando Usuario</span>
<form method="post" action="registrarUsuario1.php"  name="registro"  ENCTYPE="multipart/form-data" >
  <p>
    
    <input name="nombre_usuario" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="nombre_usuario" onfocus="vaciar_nombre(this,'Nombre de usuario','text')" onblur="validar_nombre(this,'Nombre de usuario','text');" onkeypress="return sin_espacio(event);" value="<?php echo $usuario; ?>" maxlength="28"/> 
    (min 6 letras)  
  <p>
       <span class="rojo"><?php  echo $usuario_vacio; ?> </span>
    <p>
  
         <input type="<?php echo $tipo; ?>" id="clave" name="clave" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'Clave','text');" onfocus="vaciar_nombre(this,'Clave','password')" onkeypress="return sin_espacio(event);" value="<?php echo utf8_encode($clave); ?>" maxlength="28"/>  
         (min 6 letras)
    <p>
       <span class="rojo"><?php echo $clave_vacio; ?> </span>
    <p>
         
         
         <input type="<?php echo $tipo2; ?>" id="clave2" name="clave2" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'Repetir clave','text');" onfocus="vaciar_nombre(this,'Repetir clave','password')" onkeypress="return sin_espacio(event);" value="<?php echo utf8_encode($clave2); ?>" maxlength="28"/>              
    <p>
       <span class="rojo"><?php echo $clave_vacio2; ?> </span>
    <p>
    
      <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class=<?php echo $evalua_campos[$i]; $i++;?>  value="<?php echo $fecha; ?>"/>  
    Fecha de nacimiento.</p>
  <p>
  
    <select name="nacionalidad" size="1" class=<?php echo $evalua_campos[$i]; $i++;?>>
        <?php while($row=$result->fetch_array()) { 
       $nombre_nacion=addslashes(utf8_encode($row['nombre']));
	   $ide_nacion=$row['id'];
            echo "<option name=pais value=".$row['id']." selected=\"selected\">"
			
			.htmlentities($nombre_nacion )."</ option>"; } ?>
        <option selected value="<?php  echo $nacionalidad; ?>"><?php echo utf8_encode($row_nac['nombre']);?></option>
      </select> 
    Nacionalidad.  
  <p>  
  <p>
    <input name="email" type="email" class=<?php echo $evalua_campos[$i]; $i++; ?> id="email" onfocus="vaciar_nombre(this,'Email (con @extension. )','text')" onblur="validar_nombre(this,'Email (con @extension. )','text');"value="<?php echo $email; ?>" maxlength="48"/>  
  <p>    <span class="rojo"><?php echo $mail_mal; ?> </span>
  <p>
  Sexo:
    <input type="radio"  name="m";  id="m" <?php if($m==true){echo " checked";} ?>    onclick="seleccionar(this)" /> 
           Masculino &nbsp;&nbsp; 
            <input type="radio"   name="f";  id="f" <?php if($f==true){echo " checked";} ?>    onclick="seleccionar(this)" />
Femenino</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
   <input type="hidden" name="reg_us1"/>
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