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
       //Caso que tenga valores vacíos los retorno "";
       function retornarVacio($nuevo, $original, $sinCambiar){
			if($nuevo==$original)
			   return "";
			 else return $sinCambiar;  
			}


 for ($i = 1; $i <= 8; $i++) {
   $evalua_campos[$i]="\"registro_ant > color_gris\"";
   }  $i=1;
   
   
   
   
     $email = isset($_POST['email']) ? $_POST['email']:"Email (con @extension. )";
	 $telefono = isset($_POST['telefono']) ? $_POST['telefono']:"Teléfono fijo";
     $telefono_movil = isset($_POST['telefono_movil']) ? $_POST['telefono_movil']:"Teléfono móvil";
	 $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion']:"";
    
     $email_e = addslashes(utf8_decode($email)); 
     $telefono_e=addslashes(utf8_decode($telefono));
	 $telefono_movil_e=addslashes(utf8_decode($telefono_movil));
     $descripcion_e=addslashes(utf8_decode($descripcion));
   
   
     $mail_mal="";
     $imagen_mal="";
   
   
     $reg_us2 = isset($_GET['reg_us2']) ?$_GET['reg_us2']:0;
	 $user_name = isset($_GET['us']) ? $_GET['us']:
	 header('Location: consultaUsuarios.php');
	 echo '<br><br><br><br>'.$user_name;
	 $user_name_e=addslashes(utf8_decode($user_name));
     
		
		
		if($reg_us2==1){
          //
		 
		  $validar_todo=true;   
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
		              $evalua_campos[1]="\"registro_ant > color_rojo\"";
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

		 }  error_reporting(-1);
		  
		
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
		  
	$email_e=retornarVacio($email, "Email (con @extension. )",$email_e);
    $telefono_e=retornarVacio($telefono, "Teléfono fijo",$telefono_e);
	$telefono_movil_e=retornarVacio($telefono_movil, "Teléfono móvil",$telefono_movil_e);
    
			
             $imagen = isset($_POST['imagen']) ?$_POST['imagen']:''; 
			 echo filesize($imagen); 
			 $img_tipo='.jpeg';
           $foto_reconvertida='';
		   
           $img_size= $_FILES['imagen']['size'];       
           
           if($img_size>0){
           $img=fopen($_FILES['imagen']['tmp_name'],"rb");
		   
           $img_tipo=$_FILES['imagen']['type'];  
		 
           $foto_reconvertida = fread($img, $img_size);
           $foto_reconvertida=addslashes($foto_reconvertida); 
           }
				
				
			 
			$sql2 = ("UPDATE usuarios2 set mail='$email_e',telefono='$telefono_e',celular='$telefono_movil_e',descripcion='$descripcion_e', foto='$foto_reconvertida'   where nombredeusuario='$user_name_e'");
			 
             $result2=$conn->query($sql2);
            
               header('Location: registrarUsuario3.php? us='.$user_name.'');
				
				}
	   
	      
		}
   
    ?>
      <div class="container">
   <div class="posicion_registo_usuario" id="apDiv1" >
   <span class="titulo">Registrando Usuario</span>
   <form action="registrarUsuario2.php?reg_us2=1 & us=<?php echo $user_name; ?>  " method="post" name="registro" ENCTYPE="multipart/form-data" >
  <p class="resaltado">( Los siguientes atributos son opcionales )</P>
       <p>
         <input name="email" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="email" onfocus="vaciar_nombre(this,'Email (con @extension. )','text')" onblur="validar_nombre(this,'Email (con @extension. )','text');"value="<?php echo $email; ?>" maxlength="40"/>       
       <p>
       <span class="rojo"><?php echo $mail_mal; ?> </span>
    <p>
  
 
         <input name="telefono" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono" onfocus="vaciar_nombre(this,'Teléfono fijo','text')" onblur="validar_nombre(this,'Teléfono fijo','text');"  onkeypress="return justNumbers(event);" value="<?php echo $telefono; ?>" maxlength="25"/>      
       
       <p>
       <input name="telefono_movil" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono_movil" onfocus="vaciar_nombre(this,'Teléfono móvil')" onblur="validar_nombre(this,'Teléfono móvil','text');" onkeypress="return justNumbers(event);"
        value="<?php echo $telefono_movil; ?>" maxlength="25"/>       
       <p>       
    <p>Imagen de perfil de Usuario:</p>
       <p>
         <input type="file" name="imagen" id="imagen"/>
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