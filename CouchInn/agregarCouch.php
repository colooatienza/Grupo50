<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CouchInn | Agregar Couch</title>


<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
</style>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="icon" href="images/logo.jpg">



<body>
   <?php
   include("verificarUsuario.php");
   include("conexion.php");
   include("menu.php");
		
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sqlciudades = "select * from ciudades";
	$ciudades=$conn->query($sqlciudades);
	
?>
    
   
    
<div class="container">
<div class="posicion_registo_usuario" >
 <span class="titulo">Agregar Couch</span>
<form method="post" action="registrarUsuario1.php"  name="registro"  ENCTYPE="multipart/form-data" >    
    <input name="titulo" type="text" id="titulo" placeholder="Título" onblur="validar_nombre(this,'Nombre de usuario','text');" maxlength="50"/> 
    
       <span class="rojo"><?php  echo $usuario_vacio; ?> </span>

    <input name="direccion" type="text" id="direccion" placeholder="Dirección" onblur="validar_nombre(this,'Nombre de usuario','text');" maxlength="150"/> 
         

    
      <input type="date" name="fecha_inicio" id="fecha_inicio" class=<?php echo $evalua_campos[$i]; $i++;?>  value="<?php echo  date_create(); ?>"/>  
    Fecha de inicio</p>
        <p>
    
      <input type="date" name="fecha_fin" id="fecha_fin" value="<?php date_create(); ?>"/>  
    Fecha de inicio</p>
  <p>
  
    <select name="tipo" size="1">
    <option value="-1">Seleccione categoría </option>
        <?php 
	$sqltipos = "select * from ciudades";
	$tipos=$conn->query($sqltipos);

    while($row=$tipos->fetch_array()){ 
       $nombre_nacion=addslashes(utf8_encode($row['tipo']));
       echo "<option value=".$row['id'].">" .htmlentities($nombre_nacion )."</ option>"; 
    } 
    ?>
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