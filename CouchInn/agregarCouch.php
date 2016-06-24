<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CouchInn | Agregar Couch</title>

<script src="js/dropzone.js"></script>
<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
</style>
<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="icon" href="images/logo.jpg">

<link href="js\select2\dist\css\select2.min.css" rel="stylesheet" />
<script src="js\select2\dist\js\select2.min.js"></script>

<script type="text/javascript">

</script>
  
</head>
 
<body>
<?php
include("verificarUsuario.php");
include("conexion.php");
include("menu.php");	 

 $sql = "select * from solicitud INNER JOIN couchs ON couchs.id=solicitud.idcouch INNER JOIN usuarios ON couchs.usuario=usuarios.nombredeusuario WHERE usuarios.nombredeusuario='".$_SESSION["usuario"]."' ORDER BY solicitud.estado='pendiente' DESC";
  $result=$conn->query($sql);
  if(mysqli_num_rows($result)>0){
    echo' </br> </br> </br>';
    echo'<div class="divTipo">';
    echo '<h4 align="center">Tiene calificaciones pendientes! Califique para agregar nuevo Couch!</h4>';
    echo'</div>';
  }
  else{

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	     
	$sqlciudades = "select * from ciudades order by ciudad_nombre";
	$ciudades=$conn->query($sqlciudades);
	
	$titulo= isset($_POST['titulo']) ? $_POST['titulo']:'';
	$direccion= isset($_POST['direccion']) ? $_POST['direccion']:'';
	$fecha_inicio= isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio']:'';
	$fecha_fin= isset($_POST['fecha_fin']) ? $_POST['fecha_fin']:'';
	$descripcion= isset($_POST['descripcion']) ? $_POST['descripcion']:'';
	
	
	$elTipo = isset($_POST['tipo']) ? $_POST['tipo']:0;
	$laProvincia = isset($_POST['provincia']) ? $_POST['provincia']:0;
    $laCiudad = isset($_POST['ciudad']) ? $_POST['ciudad']:0;
	
	
    $confirmado=isset($_POST['enviar_todo']) ? $_POST['enviar_todo']:"";
	
	$nombreDeProvincia="";
	$nombreDeCiudad="";
	$nombreDeTipo="";


		  $titulo_mal="";			
		  $direccion_mal="";		
		  $fechaI_mal="";
	      $fechaF_mal="";
		  $tipo_mal="";  
		  $provincia_mal=""; 
		  $ciudad_mal="";
	      $imagen_mal="";
          $descripcion_mal="";
			


//Validar múltiples FOTOS no es JODA::::.
  $cantidad_archivos=0;
  $valido_todo=true;
 
  $imagenes_previas=isset($_POST['imagenes_previas']) ? $_POST['imagenes_previas']:'no';
  $total=isset($_POST['total_img']) ? $_POST['total_img']:0;
 
  $arreglo_fotos;
   $arreglo_extension;
  $tamanios=0;
  $arreglo_fotos_previas;
 
 
  
 //Cuando recarga la página elimina temporales restos siemrpre:::: 

if($imagenes_previas=='no' && $total==0){	
$directorio=opendir("./images/temporales");  
//se leen 2 archivos que valen . y ..
$archivo = readdir($directorio);
$archivo = readdir($directorio);

while ($archivo = readdir($directorio)) {  
     
 $archivo=utf8_encode($archivo);
 if ((strpos($archivo, "@@".$_SESSION['usuario']."@")==true))
    unlink("images/temporales/".utf8_decode($archivo)."");
  }  
}

	








//Caso que seleccionemos las imágenes:::::::::
if($imagenes_previas=='si' && $total==0){
  

//Valida las imagenes:::::
 if(isset($_FILES['fotos']['name']))
   $cantidad_archivos= count($_FILES['fotos']['name']);
        

 //echo $cantidad_archivos;
 
	  $archivo="";  
	  $i=0;
	  while(  $i< $cantidad_archivos  &&   $valido_todo==true) {
		
	   if(isset($_FILES['fotos']['name'][$i])) {
	     
	     $maximo = 30500000;   //Permitimos maximo 30 mb para imágenes subir.
	     $destino='';
   		 $tamanios= $tamanios + $_FILES['fotos']['size'][$i]; 	 
		 error_reporting(0);
         
		 
		 if($tamanios > $maximo) {    		 
			error_reporting(-1);
            $valido_todo=false; 
			 $imagen_mal="Las imágenes son muy pesadas";
         }else{
		
		 error_reporting(-1);
   
	$status = "";
    $valida_todo=true;
    $tamano = $_FILES['fotos']['size'][$i];
    $tipo = $_FILES['fotos']['type'][$i];
    $archivo = $_FILES['fotos']['name'][$i];
    
   //verifico que solo sea formato para imagen y no OTRA COSA:::		
    $tipos = array('jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff', 'bmp');       

    
    $array_nombre = explode('.',$archivo); 
    $cuenta_arr_nombre = count($array_nombre); 
    $extension = strtolower($array_nombre[--$cuenta_arr_nombre]); 
     
    if(!in_array($extension, $tipos) && $tamano>0){ 
	       $valido_todo=false; 
		   $imagen_mal="Tienen que ser todas imágenes";}      
     }
    }
	$arreglo_fotos_previas[$i]=$_FILES['fotos']['name'][$i];
	$arreglo_extension[$i]=$extension;
	$i++;
	 }



    // Si las imágenes son CORRECTAS las guardo todas en una carpeta temporal  a menos que cancele couch 
	//o que lo cierre sin querer!!!!    una vez que valide el resto de los campos es cuando se ponen en permanente ::::::::
	
     if($valido_todo==true ){		   
		   $i=0;
		   $total = $cantidad_archivos;
		   while($i<$total){ 
		    $nombre_imagen="T@@".($_SESSION['usuario'])."@".utf8_decode($arreglo_fotos_previas[$i])."";
   
   $destino1="images/temporales/".$nombre_imagen;
     if (copy($_FILES['fotos']['tmp_name'][$i],$destino1)) {
       $status = "Archivo subido: <b>".$archivo."</b>";      
        }
    $i++;
    }
  }
}
$i=0;
$todas_fotos="";
   
  //Necesito su lista de nombres de las IMÁGENES POR TANTO LAS PONGO EN ESE LISTADO. 
  if($valido_todo==true && $total!=0){          
		 while($i<$total){          
	   $arreglo_fotos_previas[$i]= isset($_POST[$i.'cant']) ? $_POST[$i.'cant']:$arreglo_fotos_previas[$i];
	   $i++;
 		  }
	  }









  //Si las imágenes pasaron la validación y ademàs tengo un total!=0 también pregunto si tengo confirmado
  //y mando toooodo los inputs::
   if($valido_todo==true){
     if($confirmado=='si'){
	    
		
		if(strlen($titulo)<3){
			$titulo_mal="Tiene que tener al menos un título";
			 $valido_todo=false;
			}
        if(strlen($direccion)<3){
			$direccion_mal="Tiene que tener al menos una dirección";
			$valido_todo=false;
			}	
	   
	      if(($fecha_inicio)==""){
			$fechaI_mal="Necesita una fecha de inicio";
			$valido_todo=false;
			}	
	      	
	    $hoy= date("20y-m-d");
		
		if(($fecha_inicio) < $hoy){
			$fechaI_mal="Necesita ser una fecha igual o posterior a hoy";
			$valido_todo=false;
			}	
		 
		 if($fecha_fin <= $fecha_inicio && $fecha_fin!=""){
	       $fechaF_mal="La fecha Fin tiene que ser mayor que la de inicio";
		   $valido_todo=false;
		 }	
		
		 if(($elTipo)==0){
			$tipo_mal="Necesita un tipo de Couch";
			$valido_todo=false;
			}	
		if(($laProvincia)==0){
			$provincia_mal="Necesita una Provincia";
			$valido_todo=false;
			}	
	    if(($laCiudad)==0){
			$ciudad_mal="Necesita una Ciudad";
			$valido_todo=false;
		}
	    
		if( $total==0){
	      $imagen_mal="Debe tener al menos una imagen";
		  }
	   
	    if(strlen($descripcion)<3){
			$descripcion_mal="Debe tener una breve descripción";
			 $valido_todo=false;
			}
	 
	 }  

   }
 
 
 
 
 
 
 
 
 //UNA VEZ QUE ESTÁ TODO VALIDO LO ENVÍO A LA BD CON TODAS SUS FOTOS:::::::
 
   if($valido_todo==true && $confirmado=="si"){


    $titulo= utf8_decode($titulo);
	$direccion= utf8_decode($direccion);	
	$descripcion= utf8_decode($descripcion);

	$elUsuario=$_SESSION['usuario'];  
	   
	   $sql3 = ("INSERT INTO couchs(titulo,descripcion,fechainicio,fechafin,direccion,provincia,ciudad,idtipo,usuario,disponible) VALUES ('$titulo', '$descripcion','$fecha_inicio','$fecha_fin','$direccion','$laProvincia','$laCiudad','$elTipo','$elUsuario',1)");
	
	
	$titulo= utf8_encode($titulo);
	$direccion= utf8_encode($direccion);	
	$descripcion= utf8_encode($descripcion);
	   
	   
	$result3=$conn->query($sql3); 
	
		
	$query= $conn->query("SELECT @@identity AS id");

 if ($row = $query->fetch_array(MYSQLI_BOTH)) {
   $id = trim($row[0]);
   
  
  
  
    

 //Con las siguientes instrucciones cambio de directorio las imágenes::::
$directorio=opendir("./images/temporales");  
//se leen 2 archivos que valen . y ..
$archivo = readdir($directorio);
$archivo = readdir($directorio);

$i=0;
while ($i < $total) {  
 $archivo = readdir($directorio);
 $archivo= utf8_encode($archivo); 
 $extension= strstr($archivo, '.');
 
$archivo_cortado= $id.'@'.$i.'@'.$_SESSION['usuario'].''.$extension;

 if ((strpos($archivo,$_SESSION['usuario'])==true)){
     rename("./images/temporales/".utf8_encode($archivo)."","./images/couch/".$archivo_cortado."");
    
	//Se lo agrego a la bd:	
	$sql4 = ("INSERT INTO fotos(idcouch,link) VALUES ('$id', '$archivo_cortado')"); 
    $result4=$conn->query($sql4); 	
 }
$i++;
}  	
		
$i=0;	
	
	
	
	header("Location: couchAgregado.php");
 }
	   
	   }else{
		   $confirmado="";
		   }
 



?>
    
    
 
<div class="container">
<div class="posicion_registo_usuario" >
 <span class="titulo">Agregar Couch</span>
<form method="post" onSubmit="return valida()" action="agregarCouch.php" name="registro"  ENCTYPE="multipart/form-data" > 

    <input name="titulo" type="text" id="titulo" placeholder="Título" onblur="validar_campo(this);" onclick="limpiar(this)" maxlength="50" value="<?php echo $titulo;?>"/> 
      </br>
      <span class="cancela_todas"><?php echo $titulo_mal; ?> </span>
      </br>




    <input name="direccion" type="text" id="direccion" placeholder="Dirección" onblur="validar_campo(this);" onclick="limpiar(this)"  maxlength="150" value="<?php echo $direccion;?>"/> 
      </br>
      <span class="cancela_todas"><?php echo $direccion_mal; ?> </span>
      </br>
  
  
  
          
    <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fecha_inicio;?>" />  
    Fecha de inicio
      </br>
      <span class="cancela_todas"><?php echo $fechaI_mal; ?> </span>
      </br>
    
    
    
        
      <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo $fecha_fin;?>"/>  
    Fecha de fin
      </br>
      <span class="cancela_todas"><?php echo $fechaF_mal; ?> </span>
      </br>
  
  
  
  
  
  
  
    <select name="tipo"  id="tipo" class="select2" multiple="false"  style="width:350px">
    <?php 
	$sqltipos = "select * from tipos_couch";
	$tipos=$conn->query($sqltipos);

    while($row=$tipos->fetch_array()){ 
       $nombre_nacion=addslashes(utf8_encode($row['tipo']));
       echo "<option value=".$row['id'].">" .htmlentities($nombre_nacion )."</ option>"; 
   
   
    if($elTipo==$row['id'])
	  $nombreDeTipo= addslashes(utf8_encode($row['tipo']));	
	} 
    
     if($elTipo!=0)
       echo "<option value=".$elTipo." selected>" .$nombreDeTipo."</ option>";  
      ?>
      </select> 
      </br>
      <span class="cancela_todas"><?php echo $tipo_mal; ?> </span>
      </br>
    
    
 
    
    
    
    
    <select name="provincia" id="provincia" class="selectProvincia" multiple="false" style="width:350px" onChange="enviar_provincia();">
    <?php 
	$sqltipos = "select * from provincia";
	$tipos=$conn->query($sqltipos);

    while($row=$tipos->fetch_array()){ 
       $nombre_nacion=addslashes(utf8_encode($row['provincia_nombre']));
       echo "<option value=".$row['id'].">" .htmlentities($nombre_nacion )."</ option>"; 
     
	 if($laProvincia==$row['id'])
	  $nombreDeProvincia= addslashes(utf8_encode($row['provincia_nombre']));	
	} 
    
     if($laProvincia!=0)
       echo "<option value=".$laProvincia." selected>" .$nombreDeProvincia."</ option>";  
      ?>
    </select> 
      </br>
      <span class="cancela_todas"><?php echo $provincia_mal; ?> </span>
      </br>
    
    
    
 
 
 
    
    <select name="ciudad" id="ciudad" class="selectCiudad" multiple="false"  style="width:350px">
    <?php 
	$sqltipos = "select * from ciudad where provincia_id=".$laProvincia." order by ciudad_nombre";
	$tipos=$conn->query($sqltipos);

    while($row=$tipos->fetch_array()){ 
       $ciudad=addslashes(utf8_encode($row['ciudad_nombre']));
       echo "<option value=".$row['id'].">" .htmlentities($ciudad )."</ option>"; 
    
	 if($laCiudad==$row['id'])
	  $nombreDeCiudad= addslashes(utf8_encode($row['ciudad_nombre']));	
	} 
    
     if($laCiudad!=0 && $laProvincia!=0)
       echo "<option value=".$laCiudad." selected>" .$nombreDeCiudad."</ option>";  
    ?>
      </select>   
      </br>
      <span class="cancela_todas"><?php echo $ciudad_mal; ?> </span>
      </br>
   
   
 
 
 
 
      
      <input type="hidden" id="imagenes_previas" name="imagenes_previas" value="<?php echo $imagenes_previas; ?>"> 
          
      <?php if($imagenes_previas=='no'){      ?>
      <input type="file" name="fotos[]" id="fotos[]" onChange="enviar_imagenes()" multiple accept=image/*>
        
        <?php    
		  }else{ 		  
		       $i=0; 
			echo "Fotos elejidas:"; 
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			
			echo '<img src="images/eliminar.png" width="15" height="15" alt="f"><input type=button class="cancela_todas" value="cancelar todas" onClick="cancela_multiples()"><br>';
		//  echo '<select name="previas" id="previas" multiple="false"  style="width:350px">';
		   echo '<span style="border:1px solid;">';
		  while($i<$total){ 
            
	       // echo "<option>".$arreglo_fotos[$i]."</option>";
		  
		    echo  '<input type="text" class="sin_nada" id="'.$i.'cant" name="'.$i.'cant" 
			value="'.$arreglo_fotos_previas[$i]. '"><br>'; 
		  //  echo $arreglo_fotos[$i].'<br>';
		   $i++;
		  }
		 } 
		   echo '</span><br>'.$confirmado;
		 ?>
  
  
  
     
     <input type="hidden" id="total_img" name="total_img" value="<?php echo $total;?>">
     <input type="hidden" id="enviar_todo" name="enviar_todo" value="<?php echo $confirmado;?>">
     <!-- </select> -->
       
      </br>
      <span class="cancela_todas"><?php echo $imagen_mal; ?> </span>
      </br>
       
       
    
    
       
       <textarea name="descripcion" id="descripcion" cols="41" rows="6" placeholder="Inserte una descripcion.."  class="textArea_fijo" ><?php echo $descripcion; ?></textarea>
      </br>
      <span class="cancela_todas"><?php echo $descripcion_mal; ?> </span>
      </br>
      
    <input type="button"  id="enviar" onClick="valida()"  value="Agregar" />
      </br>
      </br>
    
</form>
       
    
</div>

<br><br>
 <hr>
</div>
<?php 
}
?>
<script language="javascript" src="agregarCouch.js"></script> 
<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>