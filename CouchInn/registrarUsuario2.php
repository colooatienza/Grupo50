<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrar Usuario</title>

  	<link rel="icon" href="images/logo.jpg">

<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
</style>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
</head>

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

       //Caso que tenga valores vacíos los retorno "";
       function retornarVacio($nuevo, $original, $sinCambiar){
			if($nuevo==$original)
			   return "";
			 else return $sinCambiar;  
			}


 for ($i = 1; $i <= 8; $i++) {
   $evalua_campos[$i]="\"registro_ant > color_gris\"";
   }  $i=1;
  
  

   
     $usuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario']:"";
	 $clave = isset($_POST['clave']) ? $_POST['clave']:"";    
	 $fecha = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento']:"";
	 $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad']:"";
	 $email = isset($_POST['email']) ? $_POST['email']:"";
     $sexo = isset($_POST['sexo']) ? $_POST['sexo']:"";


	 $telefono = isset($_POST['telefono']) ? $_POST['telefono']:"Teléfono fijo";
     $telefono_movil = isset($_POST['telefono_movil']) ? $_POST['telefono_movil']:"Teléfono móvil";
	 $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion']:"";
    
     $email_e = addslashes(utf8_decode($email)); 
     $telefono_e=addslashes(utf8_decode($telefono));
	 $telefono_movil_e=addslashes(utf8_decode($telefono_movil));
     $descripcion_e=addslashes(utf8_decode($descripcion));
   
   
     $mail_mal="";
     $imagen_mal="";
   
   
     $reg_us2 = isset($_POST['reg_us2']) ?1:0;
	
    $user_name = isset($_POST['usss']) ? $_POST['usss']:
	
	 header('Location: consultaUsuarios.php');
	 
	 echo '<br><br><br>';
	 $user_name_e=addslashes(utf8_decode($user_name));
     
	 
	 
	   //La primer Pasada:::
	    if($reg_us2==0){
			
			$sql2 = "select * from usuarios where nombredeusuario='$user_name_e'";
			$result2=$conn->query($sql2);
			$roww=$result2->fetch_array(MYSQLI_BOTH);
			
			$usuario = utf8_encode($roww['nombredeusuario']); 
	        $clave =    utf8_encode($roww['clave']); 
	        $fecha = utf8_encode($roww['fechadenacimiento']); 
	        $nacionalidad = utf8_encode($roww['nacionalidad']); 
	        $email = utf8_encode($roww['mail']); 
	        $sexo = utf8_encode($roww['sexo']); 
	       $sql3 = "delete from usuarios where nombredeusuario='$user_name_e'";
			$result3=$conn->query($sql3);
			}
		


		//LA SEGUNDA PASADA::
		      $telefonoLargo="";
              $movilLargo="";
		
		if($reg_us2==1){
			$validar_todo=true;  
			if(strlen($telefono)>=48){
		  $evalua_campos[1]="\"registro_ant > color_rojo\"";
		     $telefonoLargo="El teléfono fijo es muy largo";
			 $validar_todo=false;}
		
		if(strlen($telefono_movil)>=48){
		  $evalua_campos[2]="\"registro_ant > color_rojo\"";
		     $movilLargo="El teléfono móvil es muy largo";
			 $validar_todo=false;}
			 
		  
	   $archivo="";
	   
	   if(isset($_FILES["archivo"])) {
	   
	  $maximo = 30500000; // 30 Mb esto es para probar  
	  
	  $destino='';
   		 	 
		 error_reporting(0);
         if($_FILES["archivo"]['size'] >$maximo) {
	         		 
			error_reporting(-1);
            $validar_todo=false; 
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
	       $validar_todo=false; 
		   $imagen_mal="Tiene que ser una imagen";}
   
     }

	   }
	  
	  
			if($validar_todo==true){
		  
    $telefono_e=retornarVacio($telefono, "Teléfono fijo",$telefono_e);
	$telefono_movil_e=retornarVacio($telefono_movil, "Teléfono móvil",$telefono_movil_e);
    
	  $destino="";
		  	 if($archivo!=""){
	          
   $destino="images/usuario/us@".utf8_decode($usuario)."";

  if (copy($_FILES['archivo']['tmp_name'],$destino)) {
     $status = "Archivo subido: <b>".$archivo."</b>";
   } else {
   $status = "Error al subir el archivo";}
     
  }

						
			$usuario = utf8_decode($usuario); 
	        $clave = utf8_decode($clave); 
	        $fecha = utf8_decode( $fecha); 
	        $nacionalidad = utf8_decode( $nacionalidad); 
	        $email = utf8_decode( $email); 
	        $sexo = utf8_decode( $sexo); 	
							 
			$sql3 = ("INSERT INTO usuarios(nombredeusuario, clave, nacionalidad, fechadenacimiento,sexo,mail,telefono,celular,descripcion,foto) VALUES ('$usuario', '$clave','$nacionalidad','$fecha','$sexo','$email','$telefono_e','$telefono_movil_e','$descripcion_e','$destino')");
			 
             $result3=$conn->query($sql3);
             
            $_SESSION["usuario"]=$usuario;
            $_SESSION["logueado"]=true;
			$_SESSION["admin"]=0;
            $_SESSION["premium"]=0;
			 
			
			?>
			<form method="post" name="regii2" id="regii2" action="registrarUsuario3.php"   ENCTYPE="multipart/form-data" >
			    <input type="hidden" name="usss" value="<?php echo $user_name;?>">
			</form> 
         <script type="text/javascript"> document.regii2.submit(); </script>
           
        <?php 
			 
					
		
		  }      
		}
   
   
    ?>
      <div class="container">
   <div class="posicion_registo_usuario" id="apDiv1" >
   <span class="titulo">Registrando Usuario</span>
   <form action="registrarUsuario2.php?us=<?php echo base64_encode($user_name); ?>  " method="post" name="registro" ENCTYPE="multipart/form-data" >
  <p class="resaltado">( Los siguientes atributos son opcionales )    </P>
  <p>
  
 
         <input name="telefono" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono" onfocus="vaciar_nombre(this,'Teléfono fijo','text')" onblur="validar_nombre(this,'Teléfono fijo','text');"  onkeypress="return justNumbers(event);" value="<?php echo $telefono; ?>" maxlength="48"/>     
                    <span class="rojo"><p><?php  echo $telefonoLargo; ?> </span>
      <p>
       <input name="telefono_movil" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono_movil" onfocus="vaciar_nombre(this,'Teléfono móvil')" onblur="validar_nombre(this,'Teléfono móvil','text');" onkeypress="return justNumbers(event);"
        value="<?php echo $telefono_movil; ?>" maxlength="48"/> 
      <span class="rojo"><p><?php  echo $movilLargo; ?> </span>      
      <p>       
    <p>Imagen de perfil de Usuario:</p>
       <p>
         <input type="file" name="archivo" id="archivo"/>
       <p>
       <span class="rojo"><?php echo $imagen_mal; ?> </span>
       <p>
    
         
         <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
        
    </p>
    <p>Descripción:</p>
       <p> 
        
         <textarea name="descripcion" id="descripcion" cols="35" rows="6"  ><?php echo $descripcion; ?></textarea>
    </p>
       <p>&nbsp;</p>
    <p>
           <input type="button"  id="enviar" class="boton_esto"  value="Enviar" onClick="validar_opcionales();"  />
     <p>&nbsp;</P><hr><p>
     
     
 
 
 <input name="nombre_usuario" type="hidden"  value="<?php echo $usuario;?>" /> 
  <input name="clave" type="hidden" value="<?php echo $clave; ?>" /> 
   <input name="nacionalidad" type="hidden"  value="<?php echo $nacionalidad; ?>" /> 
    <input name="email" type="hidden" value="<?php echo $email;?>" /> 
     <input name="fecha_nacimiento" type="hidden"  value="<?php echo $fecha ?>" /> 
      <input name="sexo" type="hidden" value="<?php echo $sexo ?>" /> 
      <input name="reg_us2" type="hidden"/>
      <input name="usss" type="hidden" value="<?php echo $user_name;?>"/>
  </form>
    <input type="button" class="boton_cancela"  id="cancela" onClick="seguro('cancelarRegistro.php?us=<?php echo $user_name;?>')"  value="Cancelar Registro" />
     <span class="numeros">Página 2 de 2</span>
</div>
<br><br>
 <hr>
</div>



<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>