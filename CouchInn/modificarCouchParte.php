<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CouchInn | Agregar Couch</title>

<script src="js/dropzone.js"></script>
<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
.docel {
	font-size: 10px;
}
.container .posicion_registo_usuario .docel {
	font-size: 13px;
	color:#039;
}
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


	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	   
	 

	   	     	 
	
	
	
	$id=isset($_GET['idCouch'])? $_GET['idCouch'] :0;
	$idvieja=isset($_POST['idF5'])? $_POST['idF5'] :$id;
	 
	if($idvieja==0){
		header("Location: index.php");
		}
	
	
	$titulo='';
	$descripcion='';	 
	

	
	$imagenActual=isset($_POST['fotoss']) ? $_POST['fotoss']:'';	
	$primerImagen=isset($_POST['primerImagen']) ? $_POST['primerImagen']:'';
	



if(!isset($_POST['unaVez'])){
	
			
	//Antes de seguir la página tengo que ver esto depende de ello que desvíe a otra página si tiene SOLICITUD o no!!!
	$paginaConsulta=$conn->query("Select * FROM couchs INNER JOIN solicitud ON couchs.id = solicitud.idcouch where couchs.id='$idvieja'"); 
	
	if($paginaConsulta->num_rows==0)
	  header("Location:modificarCouch.php?idCouch=$idvieja");  
	
	
	
	
	
	$esteUsuario=$_SESSION['usuario'];
    $traer_couch=$conn->query("select * from couchs where id='$idvieja' and usuario='$esteUsuario'");
	
	//Para que no cambiemos los couchs de otros USUARIOS::::::
	if($traer_couch->num_rows == 0) 
	  header("Location: index.php");	
	
	$imagen_couch=$conn->query("select * from fotos where idcouch='$idvieja'");
	
	$primerImagen=$imagen_couch->fetch_array();
	$primerImagen=$primerImagen['link'];
	$laImagen= $imagen_couch->num_rows;
	if($laImagen!=0){
	  //echo $laImagen;
	  $imagenActual='si';
	}else{ $imagenActual='';}
	
	$row=$traer_couch->fetch_array();
	//echo "UNA VEZ";
	
	$titulo= addslashes(utf8_encode($row["titulo"]));
	$descripcion=addslashes(utf8_encode($row["descripcion"]));	 
	}
	
	
	if($imagenActual=='no')
		$imagenActual='cambiar';  
	
	
	
	$titulo= isset($_POST['titulo']) ? $_POST['titulo']:$titulo;
	$descripcion= isset($_POST['descripcion']) ? $_POST['descripcion']:$descripcion;
	
	
    $confirmado=isset($_POST['enviar_todo']) ? $_POST['enviar_todo']:"";
	
		  $titulo_mal="";					
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

	







if($imagenActual=='cambiar'){
		
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
  


}





  //Si las imágenes pasaron la validación y ademàs tengo un total!=0 también pregunto si tengo confirmado
  //y mando toooodo los inputs::
   if($valido_todo==true){
     if($confirmado=='si'){
	    
		
		if(strlen($titulo)<3){
			$titulo_mal="Tiene que tener al menos un título";
			 $valido_todo=false;
			}
 
		if( $total==0 && $imagenActual=='cambiar'){
	      $imagen_mal="Debe tener al menos una imagen";
		  $valido_todo=false;
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
	$descripcion= utf8_decode($descripcion);

	$elUsuario=$_SESSION['usuario'];  
	   
	  // echo $titulo.'<br>'.$idvieja;
   
	   $sql3 = ("UPDATE couchs set titulo='$titulo',descripcion='$descripcion' where id=$idvieja");
	   
	   
	
	
	
	$titulo= utf8_encode($titulo);
	$descripcion= utf8_encode($descripcion);
	   
	   
	$result3=$conn->query($sql3); 
	
  if($imagenActual=='cambiar'){	
	    
			
		//Elimino estas imágenes en este momento:::::
		$imagenesNombres=$conn->query("select * from fotos where idcouch='$idvieja'");
	   while($cadaUna=$imagenesNombres->fetch_array()){
		   //echo $cadaUna['link'].'<br>';
		   unlink("images/couch/".utf8_decode($cadaUna['link'])."");
		   }
	    $EliminarViejas=$conn->query("delete from fotos where idcouch='$idvieja'");
			
	
		  
      //echo $idvieja;
	     
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
      $archivo_cortado= $idvieja.'@'.$i.'@'.$_SESSION['usuario'].''.$extension;


      if ((strpos($archivo,$_SESSION['usuario'])==true)){
         rename("./images/temporales/".utf8_decode($archivo)."","./images/couch/".$archivo_cortado."");
	     //Se lo agrego a la bd:	
	     $sql4 = ("INSERT INTO fotos(idcouch,link) VALUES ('$idvieja', '$archivo_cortado')"); 
         $result4=$conn->query($sql4); 	
      }
    $i++;
    }  	
		
  $i=0;	
	
  }
	
	
 
	  //Aca salgo de la página::::
    //echo "Sali de la páginaa::::.";

	   header("Location: estoModifica.php?dosPasadas");
	   }else{
		   $confirmado="";
		   }
 



?>
    
    
 
<div class="container">
<div class="posicion_registo_usuario" >
 <p class="titulo">Modificar Couch</p>
 <span class="docel">( Tiene solicitudes pendientes o aceptadas<br>
 Solo puede Cambiar los siguientes atributos )</span><br><br>
 <form method="post" onSubmit="return validaParte()" action="modificarCouchParte.php" name="registro"  ENCTYPE="multipart/form-data" > 
   
   <input name="titulo" type="text" id="titulo" placeholder="Título" onblur="validar_campo(this);" onclick="limpiar(this)" maxlength="50" value="<?php echo $titulo;?>"/> 
      </br>
      <span class="cancela_todas"><?php echo $titulo_mal; ?> </span>
      </br>



 
      <input type="hidden" id="imagenes_previas" name="imagenes_previas" value="<?php echo $imagenes_previas; ?>"> 
          
        <?php  if($imagenActual=='si'){
			
			echo '<input type="hidden" id="primerImagen" name="primerImagen" value="'.$primerImagen.'">';
            echo '<input type="button"  id="enviar" onClick="seguroCambiaImagen()"   value="Cambiar imágenes actuales" />';
			echo'&nbsp;&nbsp;&nbsp';
			
			?> <img src="images/couch/<?php echo $primerImagen;?>?<?php echo time();?>"  style="max-width:100px; max-height:100px;"> <?php
		
		}else{
		   ?>
      <?php  if($imagenes_previas=='no'){      ?>
      <input type="file" name="fotos[]" id="fotos[]" onChange="enviar_imagenes()" multiple>
        
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
		 }  }
		   echo '</span><br>';
		 
		 ?>
  
  
  
     <input type="hidden" id="fotoss" name="fotoss" value="<?php echo $imagenActual;?>">
     <input type="hidden" id="total_img" name="total_img" value="<?php echo $total;?>">
     <input type="hidden" id="enviar_todo" name="enviar_todo" value="<?php echo $confirmado;?>">
     <!-- </select> -->
       
      </br>
      <span class="cancela_todas"><?php echo $imagen_mal; ?> </span>
      </br>
       
       
    
        <input type="hidden" name="idF5" id="idF5" value="<?php echo $idvieja; ?>">
       <input type="hidden" name="unaVez" id="unaVez">
       <textarea name="descripcion" id="descripcion" cols="41" rows="6" placeholder="Inserte una descripcion.."  class="textArea_fijo" ><?php echo $descripcion; ?></textarea>
      </br>
      <span class="cancela_todas"><?php echo $descripcion_mal; ?> </span>
      </br>
      
    <input type="submit"  id="enviar"   value="Modificar Couch" />
      </br>
      </br>
    
</form>
       
    
</div>

<br><br>
 <hr>
</div>

              
<script language="javascript" src="agregarCouch.js"></script> 
<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>