<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
</style>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="icon" href="images/logo.jpg">

</head>

<body>

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
 for ($i = 1; $i <= 19; $i++) {
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
	
	 $telefono = isset($_POST['telefono']) ? $_POST['telefono']:"Teléfono fijo";
     $telefono_movil = isset($_POST['telefono_movil'])? $_POST['telefono_movil']:"Teléfono móvil";
     $descripcion = isset($_POST['descripcion'])? $_POST['descripcion']:"";
	
	
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


	 if($clave=="Clave"){
		 $tipo="text";
		 }
	  if($clave2=="Repetir clave"){
		 $tipo2="text";
		 }
	
	
	  $usuario_vacio="";   $clave_vacio="";  $clave_vacio2=""; $fecha_vacio="";
	   $telefonoLargo="";   $movilLargo=""; 

	  $valido_todo=true;
		
		
		  if($usuario=="Nombre de usuario"){
			   $usuario_vacio="Tiene que poner su nombre de usuario";
			    $valido_todo=false;
			  }else{
				  
				   $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_"; 
                       for ($i=0; $i<strlen($usuario); $i++){ 
                       if (strpos($permitidos, substr($usuario,$i,1))===false){ 
                       $usuario_vacio="No se  permite ñ ni acentos";
                       $valido_todo=false; 
                    } 
                } 
                
                 
                
				  
				  
				  
				  if(strlen($usuario)<6){
					  $usuario_vacio="  El usuario debe tener al menos 6 caracteres";
					  $valido_todo=false;
					  } 
					  else{
						 $sql2 = "select * from usuarios where nombredeusuario='".utf8_decode($usuario)."'";
                          $result2=$conn->query($sql2);
						  $cant = $result2->num_rows;
						  if($cant!=0){	  
					    $usuario_vacio="  Ya existe el nombre de usuario., use un nombre distinto";
					      $valido_todo=false;
					          }
						     }
		                   }
		  
		  
		  if($clave=="Clave"){		
			   $clave_vacio="Tiene que poner su clave";
			   $valido_todo=false;
			  }else{
				  if(strlen($clave)<6){
					  $clave_vacio="  La clave tiene que tener al menos 6 caracteres";
					  $valido_todo=false;
					  } 
			   else{
				    if($clave!=$clave2){ 
					      $clave_vacio2="  Las claves tienen que ser iguales";
						  $valido_todo=false;
						}
				   }
			 }
			
			
			 
		    if($fecha==""){
				 $fecha_vacio="  La fecha tiene que ser válida";
                 $valido_todo=false;
			  }else{
			 
				 $esto= substr($fecha, -12, 4);
                  if($esto<1900 || $esto>2014){
				       $fecha_vacio="  La fecha tiene que ser válida";
					   $valido_todo=false;
					  }
				  } 
				  
				  
		
     $cons_mail=("select * from usuarios where BINARY mail='".utf8_decode($email)."'");
                 $result_mail=$conn->query($cons_mail);
				 $cant_mail = $result_mail->num_rows;
				  if($cant_mail!=0){ 
			   $mail_mal="  Ya existe la dirección de mail nombre de usuario., use una distinta";
				$valido_todo=false;
					  }
		
		
   //compruebo unas cosas de E.MAIL
      $validando_mail=true;
     //Si sigue válido el todoo::::
	 if($mail_mal==""){
    if($email=="" || $email=="Email (con @extension. )"){     
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
		     $mail_mal="El E-Mail está mal escrito";
			 $valido_todo=false;}
	 }

	     $i=1;

     if(strlen($usuario)>=29){	  
		     $usuario_vacio="El nombre de usuario es muy largo";
			 $valido_todo=false;}
	 
	  if(strlen($clave)>=29){	 
		     $clave_vacio="La clave es muy larga";
			 $valido_todo=false;}	 

	  if(strlen($email)>=49){ 
		     $mail_mal="El Email es muy largo";
			 $valido_todo=false;}
	
      if(strlen($telefono)>=48){		 
		     $telefonoLargo="El teléfono fijo es muy largo";
			 $valido_todo=false;}
		
		if(strlen($telefono_movil)>=48){	  
		     $movilLargo="El teléfono móvil es muy largo";
			 $valido_todo=false;}
	 

	 
	 
	 
	 
	 
	 if($valido_todo==true){
	 
	  $archivo="";
	   
	   if(isset($_FILES["archivo"])) {
	   
	  $maximo = 30500000; // 30 Mb esto es para probar  
	  
	  $destino='';
   		 	 
		 error_reporting(0);
         if($_FILES["archivo"]['size'] >$maximo) {
	         		 
			error_reporting(-1);
            $valido_todo=false; 
			 $imagen_mal="El archivo a cargar es muy pesado";
     
    }else{
		 error_reporting(-1);
   
	$status = "";
    $valida_todo=true;
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
 

   //verifico que solo sea formato para imagen y no OTRA COSA:::		
    $tipos = array('jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff', 'bmp');       

    $archivo = $_FILES["archivo"]['name']; 
    $array_nombre = explode('.',$archivo); 
    $cuenta_arr_nombre = count($array_nombre); 
    $extension = strtolower($array_nombre[--$cuenta_arr_nombre]); 
     
    if(!in_array($extension, $tipos) && $tamano>0){ 
	       $valido_todo=false; 
		   $imagen_mal="Tiene que ser una imagen";}
   
     }

	   }
	 }
	 
    if($valido_todo==false){
    ?>
   
	<form method="post" name="devuelve" id="devuelve" action="registrarUsuario1.php"   ENCTYPE="multipart/form-data" >
   <input type="hidden" name="nombre_usuario" id="nombre_usuario" value="<?php echo $usuario;?>">
   <input type="hidden" name="clave" value="<?php echo $clave;?>">
   <input type="hidden" name="clave2" value="<?php echo $clave2;?>">
   <input type="hidden" name="fecha_nacimiento" value="<?php echo $fecha;?>">
   <input type="hidden" name="email" value="<?php echo $email;?>">
   <input type="hidden" name="sexo" value="<?php echo $sexo;?>">
   <input type="hidden" name="nacionalidad" value="<?php echo $nacionalidad;?>">
   <input type="hidden" name="telefono" value="<?php echo $telefono;?>">
   <input type="hidden" name="telefono_movil" value="<?php echo $telefono_movil;?>">
   <input type="hidden" name="descripcion" value="<?php echo $descripcion;?>">
  
   <input type="hidden" name="usuario_vacio" value="<?php echo $usuario_vacio;?>">
   <input type="hidden" name="clave_vacio" value="<?php echo $clave_vacio;?>">
   <input type="hidden" name="clave_vacio2" value="<?php echo $clave_vacio2;?>">
   <input type="hidden" name="fecha_vacio" value="<?php echo $fecha_vacio;?>">
   <input type="hidden" name="mail_mal" value="<?php echo $mail_mal;?>">
   <input type="hidden" name="telefonoLargo" value="<?php echo $telefonoLargo;?>">
   <input type="hidden" name="movilLargo" value="<?php echo $movilLargo;?>">
 </form> 
	 
	<script type="text/javascript"> document.devuelve.submit(); </script>  

	<?php
	}
	
	  if($valido_todo==true){

			$usuario = addslashes(utf8_decode($usuario)); 
            $clave=addslashes(utf8_decode($clave));
			$nacionalidad=addslashes(utf8_decode($nacionalidad));
	        $email = addslashes(utf8_decode($email)); 
			$descripcion=  addslashes(utf8_decode($descripcion)); 
		    if($telefono=="Teléfono fijo"){ $telefono="";}
	        if($telefono_movil=="Teléfono móvil"){$telefono_movil="";}
			// $telefono,  telefono movil , sexo y fecha de nacimiento no tienen decode
			//imagen si la tiene
            
	  $destino="";
	 if($archivo!=""){
	    
   $destino="us@".utf8_decode($usuario).".".$extension."";
   
   $destino1="images/usuario/us@".utf8_decode($usuario).".".$extension."";
  if (copy($_FILES['archivo']['tmp_name'],$destino1)) {
     $status = "Archivo subido: <b>".$archivo."</b>";
   } else {
   $status = "Error al subir el archivo";}
     
  }
 
			
				
						$sql3 = ("INSERT INTO usuarios(nombredeusuario, clave, nacionalidad, fechadenacimiento,sexo,mail,telefono,celular,descripcion,foto,destacado,admin) VALUES ('$usuario', '$clave','$nacionalidad','$fecha','$sexo','$email','$telefono','$telefono_movil','$descripcion','$destino',0,0)");
			 
             $result3=$conn->query($sql3);
             
            $_SESSION["usuario"]=$usuario;
            $_SESSION["logueado"]=true;
			$_SESSION["admin"]=0;
            $_SESSION["premium"]=0;
			 
			
			?>
			<form method="post" name="regii" id="regii" action="registrarUsuario3.php"   ENCTYPE="multipart/form-data" >
			    <input type="hidden" name="usss" value="<?php echo $usuario;?>">
			</form> 
     <script type="text/javascript"> document.regii.submit(); </script>    
           
        <?php		
        //  echo "<body onload=\"document.regii.submit();\">";
   //header('Location:registrarUsuario2.php?us='.$usuario_viejo.'');
		  }
	
  		?>
<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>