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







//Valida las imagenes:::::


//if($valido_todo==true){
	 
	  $archivo="";
	   
	   if(isset($_FILES["fotos"])) {
	   
	  $maximo = 30500000; // 30 Mb esto es para probar  
	  
	  $destino='';
   		 	 
		 error_reporting(0);
         if($_FILES["fotos"]['size'] >$maximo) {
	         		 
			error_reporting(-1);
            $valido_todo=false; 
			 $imagen_mal="El archivo a cargar es muy pesado";
			 echo "ARCHIVOS PESADOS";
     
    }else{
		 error_reporting(-1);
   
	$status = "";
    $valida_todo=true;
    $tamano = $_FILES["fotos"]['size'];
    $tipo = $_FILES["fotos"]['type'];
    $archivo = $_FILES["fotos"]['name'];
 

   //verifico que solo sea formato para imagen y no OTRA COSA:::		
    $tipos = array('jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff', 'bmp');       

    $archivo = $_FILES["fotos"]['name']; 
    $array_nombre = explode('.',$archivo); 
    $cuenta_arr_nombre = count($array_nombre); 
    $extension = strtolower($array_nombre[--$cuenta_arr_nombre]); 
     
    if(!in_array($extension, $tipos) && $tamano>0){ 
	       $valido_todo=false; 
		   $imagen_mal="Tiene que ser una imagen";}
            echo "TIENE que ser IMAGEN";
     }

	   }
	// }














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
      <input type="file" name="fotos" id="fotos" multiple>

      </br>
      </br>
       <textarea name="descripcion" id="descripcion" cols="35" rows="6" placeholder="Inserte una descripcion.."  class="textArea_fijo" ><?php echo $descripcion; ?></textarea>
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

</body>
</html>