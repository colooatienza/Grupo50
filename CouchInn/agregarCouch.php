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
function cargarCiudades(){
	var list = document.getElementById("ciudad");
	list.add(new Option("items[i].text", "items[i].value"));
    /*if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "gethint.php?q=" + str, true);
        xmlhttp.send();
    }*/

}
$(document).ready(function() {
  $(".select2").select2({
  	    placeholder: "Seleccione una categoría",
    maximumSelectionLength: 1
  });
   $(".selectCiudad").select2({
  	placeholder:"Seleccione una ciudad",
    maximumSelectionLength: 1
  });
   $(".selectProvincia").select2({
  	placeholder:"Seleccione una provincia",
    maximumSelectionLength: 1
  });
   $( ".selectProvincia" ).change(function() {
  		cargarCiudades();	
	});
});

	function validar_campo(elem){
		if (elem.value.length < 3) {
			elem.style.borderColor = "red"
		}
	}
	function limpiar(elem){
		//var foo = document.getElementById('titulo');
		elem.style.borderColor='#FFFFFF';// this.style.color='#FFFFFF';
		
	}
	 function valida(){

		valor = document.getElementById("titulo").value;
		if (valor.length < 3) {
			alert ('ERROR! Debe ingresar un título válido!');
			return false;
		}
		valor = document.getElementById("direccion").value;
		if (valor.length < 3) {
			alert ('ERROR! Debe ingresar una dirección válida!');
			return false;
		}
		if (!document.getElementById("fecha_inicio").value){
			alert ('ERROR! Debe seleccionar una fecha de inicio!');
			return false;
		}
		if (!document.getElementById("fecha_fin").value){
			alert ('ERROR! Debe seleccionar una fecha de fin!');
			return false;
		}
		if (document.getElementById("fecha_inicio").value>=document.getElementById("fecha_fin").value){
			alert ('ERROR! La fecha de fin debe ser mayor a la de inicio!');
			return false;
		}
		if (!document.getElementById("tipo").value){
			alert ('ERROR! Debe seleccionar una categoría!');
			return false;
		}
		if (!document.getElementById("provincia").value){
			alert ('ERROR! Debe seleccionar una provincia!');
			return false;
		}
		if (!document.getElementById("fotos").value){
			alert ('ERROR! Debe seleccionar como mínimo 1 foto!');
		return false;
		}
		valor = document.getElementById("descripcion").value;
		if (valor.length < 3) {
			alert ('ERROR! Debe ingresar una descripción!');
		return false;
		}
	}
	
	//Activo las imagenes que tengo
	function enviar_imagenes(){
		document.getElementById('imagenes_previas').value= "si";
		document.getElementById('total_img').value= 0;
		document.registro.submit();
		}

	//Cancela multiples imagenes		
		function cancela_multiples(){
			if(confirm('Está seguro de cancelar todas las imágenes?')){
				  document.getElementById('total_img').value= 0;
				  document.getElementById('imagenes_previas').value= "no";
			  document.registro.submit();
			  }
			}



		function enviar_provincia(){
		document.registro.submit();
		}
		
	function validarTodo(){
		document.registro.submit();
		//location.href="index.php";
		}
	
	
	
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

	$sqlciudades = "select * from ciudades";
	$ciudades=$conn->query($sqlciudades);
	
	$titulo= isset($_POST['titulo']) ? $_POST['titulo']:'';
	$direccion= isset($_POST['direccion']) ? $_POST['direccion']:'';
	$fecha_inicio= isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio']:'';
	$fecha_fin= isset($_POST['fecha_fin']) ? $_POST['fecha_fin']:'';
	$descripcion= isset($_POST['descripcion']) ? $_POST['descripcion']:'';
	
	
	$elTipo = isset($_POST['tipo']) ? $_POST['tipo']:0;
	$laProvincia = isset($_POST['provincia']) ? $_POST['provincia']:0;
    $laCiudad = isset($_POST['ciudad']) ? $_POST['ciudad']:0;
	
	$nombreDeProvincia="";
	$nombreDeCiudad="";
	$nombreDeTipo="";






//Validar múltiples FOTOS no es JODA::::.
  $cantidad_archivos=0;
  $valido_todo=true;
 
  $imagenes_previas=isset($_POST['imagenes_previas']) ? $_POST['imagenes_previas']:'no';
  $total=isset($_POST['total_img']) ? $_POST['total_img']:0;
 
  $arreglo_fotos;
   $arreglo_extension;
  $tamanios=0;
  $arreglo_fotos_previas;

  







//Caso que seleccionemos las imágenes:::::::::
if($imagenes_previas=='si' && $total==0){


//Valida las imagenes:::::
 if(isset($_FILES['fotos']['name']))
   $cantidad_archivos= count($_FILES['fotos']['name']);
        

 echo $cantidad_archivos;

	 
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
			 echo "<br><br>Archivos pesados<br><br>";
     
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
		   $imagen_mal="Tienen que ser todas imágenes";   echo "TIENE que ser IMAGEN<br><br>";  }
            
     }
      
	   }
	   $arreglo_fotos_previas[$i]=$_FILES['fotos']['name'][$i];
	    $arreglo_extension[$i]=$extension;
	   $i++;
	 }



    // Si las imágenes son CORRECTAS las guardo todas en una carpeta temporal  a menos que cancele couch 
	//o que lo cierre sin querer!!!!    una vez que valide el resto de los campos es cuando se ponen en permanente ::::::::
	
     if($valido_todo==true ){
		   echo "1 sola vez";  $i=0;
		   $total = $cantidad_archivos;
		   while($i<$total){ 
		    $nombre_imagen="T@@".$_SESSION['usuario']."@".utf8_decode($arreglo_fotos_previas[$i]).".". $arreglo_extension[$i]."";
   
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
   
  
  
 
 
 

  if($valido_todo==true && $total!=0){
          
		 while($i<$total){ 
            
	   $arreglo_fotos_previas[$i]= isset($_POST[$i.'cant']) ? $_POST[$i.'cant']:$arreglo_fotos_previas[$i];
	  // echo $arreglo_fotos_previas[$i];
		  
	  

		   $i++;
 		  }
       

	  }






?>
    
    
 
<div class="container">
<div class="posicion_registo_usuario" >
 <span class="titulo">Agregar Couch</span>
<form method="post" onSubmit="return valida()" action="agregarCouch.php" name="registro"  ENCTYPE="multipart/form-data" > 

    <input name="titulo" type="text" id="titulo" placeholder="Título" onblur="validar_campo(this);" onclick="limpiar(this)" maxlength="50" value="<?php echo $titulo;?>"/> 
      </br></br>

    <input name="direccion" type="text" id="direccion" placeholder="Dirección" onblur="validar_campo(this);" onclick="limpiar(this)"  maxlength="150" value="<?php echo $direccion;?>"/> 
      </br></br>
        
    <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fecha_inicio;?>" />  
    Fecha de inicio
      </br></br>
    
      <input type="date" name="fecha_fin" value="<?php echo $fecha_fin;?>"/>  
    Fecha de fin
      </br></br>
  
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
      </br>
    
    
    
    
    <select name="ciudad" id="ciudad" class="selectCiudad" multiple="false"  style="width:350px">
    <?php 
	$sqltipos = "select * from ciudad where provincia_id=".$laProvincia."";
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
      </br>
      
      <input type="hidden" id="imagenes_previas" name="imagenes_previas" value="<?php echo $imagenes_previas; ?>"> 
      
     
      <?php if($imagenes_previas=='no'){      ?>
      <input type="file" name="fotos[]" id="fotos[]" onChange="enviar_imagenes()" multiple>
        
        <?php    
		  }else{ 		  
		       $i=0;  
			echo "Fotos elejidas:"; 
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			
			echo '<img src="images/eliminar.png" width="15" height="15" alt="f"><input type=button class="cancela_todas" value="cancelar todas" onClick="cancela_multiples()"><br>';
		//  echo '<select name="previas" id="previas" multiple="false"  style="width:350px">';
		
		  while($i<$total){ 
            
	       // echo "<option>".$arreglo_fotos[$i]."</option>";
		  
		    echo  '<input type="text" id="'.$i.'cant" name="'.$i.'cant" 
			value="'.$arreglo_fotos_previas[$i]. '">"'; 
		  //  echo $arreglo_fotos[$i].'<br>';
		   $i++;
		  }
		 } 
		 
		 ?>
     
     <input type="text" id="total_img" name="total_img" value="<?php echo $total;?>">
     <!-- </select> -->
       
      </br>
      </br>
       
       
       
       <textarea name="descripcion" id="descripcion" cols="41" rows="6" placeholder="Inserte una descripcion.."  class="textArea_fijo" ><?php echo $descripcion; ?></textarea>
      </br>
      </br>
      
    <input type="button"  id="enviar" onClick="validarTodo();" value="Agregar" />
      </br>
      </br>
    
</form>
       
      
</div>

<br><br>
 <hr>
</div>


<script language="javascript" src="registrarUsuario.js"></script> 
</body>
</html>