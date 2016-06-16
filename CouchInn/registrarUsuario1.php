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

</head>

<body>

<?php
 	
   session_start();
   include("conexion.php");
   include("menu.php");
 
   if (isset($_SESSION['usuario'])) 
     header("Location: index.php");
		
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "select * from paises order By 'nombre'";
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
	 
	 $sexo = isset($_POST['sexo']) ? $_POST['sexo']:"Masculino";

	   $m=false;  $f=false;  $mail_mal="";
	 if($sexo=="Masculino"){
		 $m=true;
		 }else{  $f=true;}

	 
	 $usuario_viejo=$usuario;
    
	
	 if($clave=="Clave"){
		 $tipo="text";
		 }
	  if($clave2=="Repetir clave"){
		 $tipo2="text";
		 }
	
	
    $usuario_vacio=isset($_POST['usuario_vacio']) ? $_POST['usuario_vacio']:"";
	$clave_vacio=isset($_POST['clave_vacio']) ? $_POST['clave_vacio']:"";
	$clave_vacio2=isset($_POST['clave_vacio2']) ? $_POST['clave_vacio2']:"";   
	$fecha_vacio=isset($_POST['fecha_vacio']) ? $_POST['fecha_vacio']:""; 
	$mail_mal=isset($_POST['mail_mal']) ? $_POST['mail_mal']:""; 
    $telefonoLargo=isset($_POST['telefonoLargo']) ? $_POST['telefonoLargo']:""; 
	$movilLargo=isset($_POST['movilLargo']) ? $_POST['movilLargo']:""; 
	
    $reg_us = isset($_POST['reg_us1']) ? 1:0;
  
  
  
    if($usuario_vacio!="") $evalua_campos[1]="\"registro_ant > color_rojo\"";
	if($clave_vacio!="")   $evalua_campos[2]="\"registro_ant > color_rojo\"";
    if($clave_vacio2!="")  $evalua_campos[3]="\"registro_ant > color_rojo\"";
	if($mail_mal!="")      $evalua_campos[6]="\"registro_ant > color_rojo\"";
   if($telefonoLargo!="") $evalua_campos[7]="\"registro_ant > color_rojo\"";
	if($movilLargo!="")    $evalua_campos[8]="\"registro_ant > color_rojo\"";

 
  $imagen_mal="";
  
  
  
  
  
  
  
  
  
  ?>
    

    
<div class="container">
<div class="posicion_registo_usuario_2" >
 <span class="titulo"> Registrando Usuario</span>
   <table width="852" border="0" align="center" style="margin-bottom:20px;">
    <tr>
   <td width="450" valign="top" style="position:relative; top:20px;">
<form method="post" action="comprobarRegistro.php"  name="registro" id="registro"  ENCTYPE="multipart/form-data" >
  <p>
    
    
    
    
    <input name="nombre_usuario" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="nombre_usuario" onfocus="vaciar_nombre(this,'Nombre de usuario','text')" onblur="validar_nombre(this,'Nombre de usuario','text');" onkeypress="return sin_espacio(event);" value="<?php echo $usuario; ?>" maxlength="28"/> 
    (min 6 letras)  
    <p>&nbsp;<span class="rojo"><?php  echo $usuario_vacio; ?> </span><p>
      
      
      
      
      
      
      <input type="<?php echo $tipo; ?>" id="clave" name="clave" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'Clave','text');" onfocus="vaciar_nombre(this,'Clave','password')" onkeypress="return sin_espacio(event);" value="<?php echo utf8_encode($clave); ?>" maxlength="28"/>  
      (min 6 letras)
      <p> <span class="rojo"><?php echo $clave_vacio; ?> </span> <p>
        
        
        
        
        
        
        <input type="<?php echo $tipo2; ?>" id="clave2" name="clave2" class=<?php echo $evalua_campos[$i]; $i++; ?> onblur="validar_nombre(this,'Repetir clave','text');" onfocus="vaciar_nombre(this,'Repetir clave','password')" onkeypress="return sin_espacio(event);" value="<?php echo utf8_encode($clave2); ?>" maxlength="28"/>              
        <p>&nbsp;<span class="rojo"><?php echo $clave_vacio2; ?> </span><p>
          
          
          
          
          
          <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class=<?php echo $evalua_campos[$i]; $i++;?>  value="<?php echo $fecha; ?>"/>  
          Fecha de nacimiento.
          </p>
  <p><span class="rojo"><?php echo $fecha_vacio; ?> </span><p>
    
    
    
    
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
      <input name="email" type="email" class=<?php echo $evalua_campos[$i]; $i++; ?> id="email" onfocus="vaciar_nombre(this,'Email (con @extension. )','text')" onblur="validar_nombre(this,'Email (con @extension. )','text');"value="<?php echo $email; ?>" maxlength="48"/>
    </p>
    <p>    <span class="rojo"><?php echo $mail_mal; ?> </span><p>
        
        
        
        
        
        Sexo:
        <input type="radio" name="m"; <?php if($m==true){echo " checked";} ?>    onclick="seleccionar(this)" /> 
        
        Masculino &nbsp;&nbsp; 
        <input type="radio"  name="f";  <?php if($f==true){echo " checked";} ?>    onclick="seleccionar(this)" />
        
        
        Femenino</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  </td><td width=2 style="background:#900">
  </td><td width="400" valign="top" style="position:relative; padding-left:40px;"><p><strong>( Los siguientes atributos son opcionales )</strong>
  <p>
      <input name="telefono" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono" onfocus="vaciar_nombre(this,'Teléfono fijo','text')" onblur="validar_nombre(this,'Teléfono fijo','text');"  onkeypress="return justNumbers(event);" value="<?php echo $telefono; ?>" maxlength="48"/>     
     </p>
    <p>  
    <span class="rojo"><?php  echo $telefonoLargo; ?> </span><p>
      
      
      
      
      
       <input name="telefono_movil" type="text" class=<?php echo $evalua_campos[$i]; $i++; ?> id="telefono_movil" onfocus="vaciar_nombre(this,'Teléfono móvil')" onblur="validar_nombre(this,'Teléfono móvil','text');" onkeypress="return justNumbers(event);"
        value="<?php echo $telefono_movil; ?>" maxlength="48"/> 
       </p>
    <p><span class="rojo"><?php  echo $movilLargo; ?></span>
      <p>&nbsp;      
      <p>Imagen de perfil de Usuario:</p>
      <p>
        
        
        
        
        <input type="file" name="archivo" id="archivo" accept="image/*" >
         
        <div id="vista_previa"><!-- miniatura --></div>
         <input type="button" class="boton_cancela" value="cancelar imagen"  style="display: none;" onclick="cancela('registro');" id="resetear" />
   
       <p>&nbsp;
      <p> <span class="rojo"><?php echo $imagen_mal; ?></span>
      <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
      </p>
     <p> <p>Descripción:</p>
      <p>
        <textarea name="descripcion" id="descripcion" cols="35" rows="6"  class="textArea_fijo" ><?php echo $descripcion; ?></textarea>
      </p>
      <p>       
        
        <p>&nbsp;
        <p>&nbsp;
         <span style="position: absolute; left: 185px;">
    <input type="button" class="boton_registrar_usuario"  id="enviar" onClick="validar_campos()"  value="Registrar Usuario" /></span><br>
   <span style="position: absolute; left: -140px; bottom:25px;">
   <input type="button" class="cancela_registro"  id="cancelar" onClick="cancelar_registro()"  value="Cancelar Registro" />
 </span>
  </form>
  <p>
  </span> 
        
       
     
        
      <p> &nbsp;     
      <p></td>
 </tr>
</table>
</div>

<br><br>
 <hr>
</div>

<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>