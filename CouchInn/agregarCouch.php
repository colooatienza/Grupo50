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
  	    placeholder: "asd",
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
		valor = document.getElementById("tarjeta").value;
		if (valor=="-1"){
			alert ('ERROR! Debe seleccionar su tarjeta de credito!');
			return false;
		}
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
	
?>
    
   
    
<div class="container">
<div class="posicion_registo_usuario" >
 <span class="titulo">Agregar Couch</span>
<form method="post" action="registrarUsuario1.php" onSubmit="return valida()" action="couchAgregado.php" name="registro"  ENCTYPE="multipart/form-data" > 

    <input name="titulo" type="text" id="titulo" placeholder="Título" onblur="validar_campo(this);" onclick="limpiar(this)" maxlength="50"/> 
      </br></br>

    <input name="direccion" type="text" id="direccion" placeholder="Dirección" onblur="validar_campo(this);" onclick="limpiar(this)"  maxlength="150"/> 
      </br></br>
        
    <input type="date" name="fecha_inicio" id="fecha_inicio" />  
    Fecha de inicio
      </br></br>
    
      <input type="date" name="fecha_fin" id="fecha_fin"/>  
    Fecha de inicio
      </br></br>
  
    <select name="tipo"  class="select2" multiple="false"  style="width:350px">
    <?php 
	$sqltipos = "select * from tipos_couch";
	$tipos=$conn->query($sqltipos);

    while($row=$tipos->fetch_array()){ 
       $nombre_nacion=addslashes(utf8_encode($row['tipo']));
       echo "<option value=".$row['id'].">" .htmlentities($nombre_nacion )."</ option>"; 
    } 
    ?>
      </select> 
      </br>
      </br>
    <select name="provincia"  class="selectProvincia" multiple="false" style="width:350px">
    <?php 
	$sqltipos = "select * from provincia";
	$tipos=$conn->query($sqltipos);

    while($row=$tipos->fetch_array()){ 
       $nombre_nacion=addslashes(utf8_encode($row['provincia_nombre']));
       echo "<option value=".$row['id'].">" .htmlentities($nombre_nacion )."</ option>"; 
    } 
    ?>
    </select> 
      </br>
      </br>
    <select name="ciudad" id="ciudad" class="selectCiudad" multiple="false"  style="width:350px">
    <?php 
	$sqltipos = "select * from ciudad";
	$tipos=$conn->query($sqltipos);

    /*while($row=$tipos->fetch_array()){ 
       $ciudad=addslashes(utf8_encode($row['ciudad_nombre']));
       echo "<option value=".$row['id'].">" .htmlentities($ciudad )."</ option>"; 
    } */
    ?>
      </select> 
      </br>
      </br>
      <input type="file" name="fotos" multiple>

      </br>
      </br>
    <input type="submit"  id="enviar" value="Agregar" />
    
</form>
       
      
</div>

<br><br>
 <hr>
</div>

</body>
</html>