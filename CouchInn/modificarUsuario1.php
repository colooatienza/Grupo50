<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registrar Usuario</title>
	<link rel="stylesheet" href="estilo/estilo.css">
	<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="icon" href="images/logo.jpg">
</head>

<body>

<?php
   include("verificarUsuario.php");
 	include("conexion.php");
 	include("menu.php");
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "select * from paises ";
	$result=$conn->query($sql);


 	for ($i = 1; $i <= 14; $i++) {
   		$evalua_campos[$i]="\"registro_ant > color_gris\"";
   	}  
   	$i=1;
     
	 //cargo los datos de usuario:::
	$reg_us = isset($_GET['reg_us1']) ? $_GET['reg_us1']:0;
	
	$usuario_vacio="";
	$clave_vacio="";
	$clave_vacio2="";
	
	if(!isset($_POST["nombre_usuario"])){
		
		
		$consulta = "select * from usuarios where nombredeusuario='".$_SESSION['usuario']."'";
     	$result2=$conn->query($consulta);

	 	$row=$result2->fetch_array();
	 
	
	 	$usuario= addslashes(utf8_encode($_SESSION['usuario']));
		 
		$usuario_viejo=$usuario;
		$clave= addslashes(utf8_encode($row["clave"]));
		$clave2= $clave;
		$fecha= addslashes(utf8_encode($row["fechadenacimiento"]));
		$nacionalidad= addslashes(utf8_encode($row["nacionalidad"]));
		$sexo=addslashes(utf8_encode($row["sexo"]));
		$email=addslashes(utf8_encode($row["mail"]));
		$telefono=addslashes(utf8_encode($row["telefono"]));
		$telefono_movil=addslashes(utf8_encode($row["celular"])); 
		$descripcion=addslashes(utf8_encode($row["descripcion"])); 
		 
		$m=false; $f=false;
		if($row["sexo"]=="Masculino")
			 $m=true;
	     
		if($row["sexo"]=="Femenino")
			$f=true;		 
			 
		$imagen_mal="";
	  
		  //algunas cosas:
		$tipo="password";
		$tipo2="password"; 
		$mail_mal="";
		 
	
		$usuario_vacio="";   $clave_vacio="";  $clave_vacio2=""; $fecha_vacio;
	
	
	}else{
		
		//Caso que valide por PHP para subir la modificación::::
		
		
		 $usuario_viejo = '$SESSION["usuario"]';
			
		 $usuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario']: "";
		 
	     $tipo="password";
	     $tipo2="password";
	     $clave = isset($_POST['clave']) ? $_POST['clave']:"";
         $clave2 = isset($_POST['clave2']) ? $_POST['clave2']:"";
	     $fecha = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento']:"";
	     $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad']:"";
		 $m = isset($_POST['m']) ? $_POST['m']:"";
	     $f = isset($_POST['f']) ? $_POST['f']:"";
		 $email = isset($_POST['email']) ? $_POST['email']:"";
	     $telefono = isset($_POST['telefono']) ? $_POST['telefono']:"";
         $telefono_movil = isset($_POST['telefono_movil']) ? $_POST['telefono_movil']:"";
	     $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion']:"";
		 
		  $m = isset($_POST['m']) ? $_POST['m']:"";
	      $f = isset($_POST['f']) ? $_POST['f']:"";
	      $sexo="Masculino";
	     if($m==true){
		   $sexo=$sexo;
		  }
	     if($f==true){
		   $sexo="Femenino";
		  }
	   
		echo "<br><br>";
			
			
		$usuario_viejo = addslashes(utf8_decode($usuario_viejo)); 	
	    $usuario_e = $SESSION["usuario"]; 
        $clave_e=addslashes(utf8_decode($clave));
	    $clave2_e=addslashes(utf8_decode($clave2));
		$nacionalidad_e=addslashes(utf8_decode($nacionalidad));
			
		$email_e = addslashes(utf8_decode($email)); 
        
		$telefono_e=addslashes(utf8_decode($telefono));
	    $telefono_movil_e=addslashes(utf8_decode($telefono_movil));
        $descripcion_e=addslashes(utf8_decode($descripcion));
   
   
       $mail_mal="";
       $imagen_mal="";	
			
			
			
		  	   $validar_todo=true;
		  if($usuario==""){
			   $evalua_campos[1]="\"registro_ant > color_rojo\"";
			   $usuario_vacio="Tiene que poner su nombre de usuario";
			    $validar_todo=false;
			  }else{
				  if(strlen($usuario)<6){
					  $evalua_campos[1]="\"registro_ant > color_rojo\"";
					  $usuario_vacio="  El usuario debe tener al menos 6 caracteres";
					  $validar_todo=false;
					  } 
					  else{
						 $sql2 = "select * from usuarios where nombredeusuario='".$usuario."'";
                          $result2=$conn->query($sql2);
						  $cant = $result2->num_rows;
						  if($cant!=0 && $usuario != $usuario_viejo){
						  $evalua_campos[1]="\"registro_ant > color_rojo\"";	  
					      $usuario_vacio="  Ya existe el nombre de usuario., use un nombre distinto";
					      $validar_todo=false;
					   		  }
						
						  }
			 }
		  
		  
		  if($clave==""){
			   $evalua_campos[2]="\"registro_ant > color_rojo\"";
			   $clave_vacio="Tiene que poner su clave";
			   $validar_todo=false;
			  }else{
				  
				  if(strlen($clave)<6){
					  $evalua_campos[2]="\"registro_ant > color_rojo\"";
					  $clave_vacio="  La clave tiene que tener al menos 6 caracteres";
					  $validar_todo=false;
					  } 
			   else{
				    if($clave!=$clave2){
						  $evalua_campos[3]="\"registro_ant > color_rojo\"";
					      $clave_vacio2="  Las claves tienen que ser iguales";
						  $validar_todo=false;
						}
				   }
			 }
			
			
			 
		    if($fecha==""){
			    $evalua_campos[4]="\"registro_ant > color_rojo\"";

				 $fecha_vacio="  La fecha tiene que ser válida";
                 $validar_todo=false;
			  }else{
			 
				 $esto= substr($fecha, -12, 4);
                  if($esto<1900 || $esto>2014){
					   $evalua_campos[4]="\"registro_ant > color_rojo\"";
				       $fecha_vacio="  La fecha tiene que ser válida";
					   $validar_todo=false;
					  }
		
				  } 
				  
				  
			
			   
		 $mail_correcto=0;	
		 if($email== "Email (con @extension. )"){  $mail_correcto=1;  } 
   //compruebo unas cosas primeras
   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
      if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
         //miro si tiene caracter .
         if (substr_count($email,".")>= 1){
            //obtengo la terminacion del dominio
            $term_dom = substr(strrchr ($email, '.'),1);
            //compruebo que la terminación del dominio sea correcta
            if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
               //compruebo que lo de antes del dominio sea correcto
               $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
               $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
               if ($caracter_ult != "@" && $caracter_ult != "."){
                  $mail_correcto = 1;
               }
            } } }}
         if ($mail_correcto!=1){
		              $evalua_campos[6]="\"registro_ant > color_rojo\"";
				       $mail_mal=" El mail está escrito incorrecto";
		               $validar_todo=false;
		 }
			
		
			
		 //verifico que la IMAGEN PESE MENOS DE 5.5 MB:::	
         $maximo = 5500000; //4.8 Mb esto es para probar 
		   	 
		 error_reporting(0);
         if($_FILES['imagen']['size'] >$maximo) {
	         		 
			error_reporting(-1);
            $validar_todo=false; 
			 $imagen_mal="El archivo a cargar es muy pesado";

		 }
		   
		   error_reporting(-1);
		  
		 
		
		   if($validar_todo==true){
		  //verifico que solo sea formato para imagen y no OTRA COSA:::		
		    $tipos = array('jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff', 'bmp');       
             $nombrebre_orig = $_FILES['imagen']['name']; 
			$array_nombre = explode('.',$nombrebre_orig); 
            $cuenta_arr_nombre = count($array_nombre); 
            $extension = strtolower($array_nombre[--$cuenta_arr_nombre]); 
            if(!in_array($extension, $tipos) && $_FILES['imagen']['size']>0){ 
	           $validar_todo=false; 
			   $imagen_mal="Tiene que ser una imagen";
			}
		   }
			
		
		if($validar_todo==true){
		  
	   
    
			
            $imagen = isset($_POST['imagen']) ?$_POST['imagen']:''; 
			//echo filesize($imagen); 
			$img_tipo='.jpeg';
        
		
		
		$foto_reconvertida='';
		
		   
           $img_size= $_FILES['imagen']['size'];       
           
           if($img_size>0){
           $img=fopen($_FILES['imagen']['tmp_name'],"rb");
		   
           $img_tipo=$_FILES['imagen']['type'];  
		 
           $foto_reconvertida = fread($img, $img_size);
           $foto_reconvertida=addslashes($foto_reconvertida); 
           }
				
			//Modificar con FOTO NUEVA::	
			 if($img_size>0){
			$sql2 = ("UPDATE usuarios set nombredeusuario='$usuario_e', clave='$clave_e', fechadenacimiento='$fecha',nacionalidad='$nacionalidad_e',sexo='$sexo',  mail='$email_e',telefono='$telefono_e',celular='$telefono_movil_e',descripcion='$descripcion_e', foto='$foto_reconvertida'   where nombredeusuario='$usuario_viejo'");
			 
             $result2=$conn->query($sql2);
			 }
			 else{  //Modificar sin foto Nueva
			     $sql2 = ("UPDATE usuarios set nombredeusuario='$usuario_e', clave='$clave_e', fechadenacimiento='$fecha',nacionalidad='$nacionalidad_e',sexo='$sexo',  mail='$email_e',telefono='$telefono_e',celular='$telefono_movil_e',descripcion='$descripcion_e'    where nombredeusuario='$usuario_viejo'");
				  $result2=$conn->query($sql2); 
				 }
				 
               header('Location: registrarUsuario3.php? us='.$usuario.' & tipo=2');
				
				}
	   
	      
		}	
		   
   
    ?>
    
   
    
   <div class="contenedor">  
<div class="posicion_registo_usuario" >
 <span class="titulo">Qué desea modificar?</span>
 <form method="post" action="modificarUsuario1.php?reg_us1=1 & nombre_usuario=<?php echo $usuario ?> & usuario_viejo=<?php echo $usuario_viejo ?>"  name="registro"  ENCTYPE="multipart/form-data" >
  <p>
  
  
    <input type="text" id="nombre_usuario" name="nombre_usuario" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'','text');" onfocus="vaciar_nombre(this,'','text')" onkeypress="return sin_espacio(event);" value="<?php echo $usuario; ?>"/>
    Nombre de usuario<p>
       <span class="rojo"><?php  echo $usuario_vacio; ?> </span>
    <p>
    
    
      <input type="password" id="clave" name="clave" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'','text');" onfocus="vaciar_nombre(this,'','password')" onkeypress="return sin_espacio(event);" value="<?php echo $clave; ?>"/>
    Clave
    <p>
       <span class="rojo"><?php echo $clave_vacio; ?> </span>
   
   
    <p>
      <input type="password" id="clave2" name="clave2" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'','text');" onfocus="vaciar_nombre(this,'','password')" onkeypress="return sin_espacio(event);" value="<?php echo $clave2; ?>"/>
      Repetir clave
    <p>
       <span class="rojo"><?php echo $clave_vacio2; ?> </span>
   
   
    <p>
      <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class=<?php echo $evalua_campos[$i]; $i++;?>  value="<?php echo $fecha; ?>"/>
    Fecha de nacimiento    </p>
  
  
  <p>
    <select name="nacionalidad" size="1" class=<?php echo $evalua_campos[$i]; $i++;?>>
        <?php while($row=$result->fetch_array()) { 
		  $nombre_nacion=addslashes(utf8_encode($row['nombre']));
            echo "<option name=pais value=".$nombre_nacion." selected=\"selected\">"
			
			.htmlentities($nombre_nacion )."</ option>"; } ?>
        <option selected><?php echo $nacionalidad; ?></option>
      </select>
  Nacionalidad<p>  
  
  
  <p>
  Sexo:
    <input  name="m" type="radio"  id="m"  onclick="seleccionar(this)"<?php if($m==true){echo " checked";} ?> /> 
           Masculino &nbsp;&nbsp; 
            <input type="radio"   name="f"  id="f" onclick="seleccionar(this)" <?php if($f==true){echo " checked";} ?> />
Femenino&nbsp;</p>
  <p>&nbsp;</p>
  <p>Atributos (opcionales):</p>
  <p>
  
  
    <input type="text" name="email"  class=<?php echo $evalua_campos[$i]; $i++; ?> id="email" onfocus="vaciar_nombre(this,'','text')" onblur="validar_nombre(this,'','text');"value="<?php echo $email; ?>" maxlength="40"/>
    Email (con @extension.)
  </p>
  <p> <span class="rojo"><?php echo $mail_mal; ?></span> </p>
  <p>
 
 
    <input name="telefono" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono" onfocus="vaciar_nombre(this,'','text')" onblur="validar_nombre(this,'','text');"  onkeypress="return justNumbers(event);" value="<?php echo $telefono; ?>" maxlength="25"/>
  Teléfono fijo</p>
  <p>
 
 
    <input name="telefono_movil" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono_movil" onfocus="vaciar_nombre(this,'','text')" onblur="validar_nombre(this,'','text');" onkeypress="return justNumbers(event);"
        value="<?php echo $telefono_movil; ?>" maxlength="25"/>
  Teléfono móvil</p>
  <p>&nbsp; </p>
 
 
  <p>Modificar Imagen de perfil actual:
     &nbsp; &nbsp; &nbsp; &nbsp;</p> 
  <p>
    <input type="file" name="imagen" id="imagen"/>
    &nbsp;</p>
  <p>&nbsp;</p>
  <p> <span class="rojo"><?php echo $imagen_mal; ?></span>
    
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
</p>
  <p>&nbsp;</p>
  <p>Descripción:</p>
  <p>


    <textarea name="descripcion" id="descripcion" cols="35" rows="6"  ><?php echo $descripcion; ?></textarea>
  </p>
  <p>&nbsp;</p>


     &nbsp;&nbsp;&nbsp;<input type="button" class="boton_esto"  id="enviar" onClick="validar_modificar()"  value="Modificar" />
    
           <p>&nbsp;</P><hr><p>           
           <p>           
           <p>
  </form>
</div>
<br><br>
 <hr>
</div>

<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>