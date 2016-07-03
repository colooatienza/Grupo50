<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CouchInn</title>


<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estilo.css';>
</style>
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" href="images/logo.jpg">
<style>

	.fondo{
  border-color:#000;
  
	}

.inpu{
	border-radius:3px;
	border-width:1px;
	border-color:#CCC;
	width:180px;
	height:25px;
	font-family:Verdana;
	font-size:14px;
	}	

</style>

<script>
 function despublicar(pagina){
	 
	 direccion="despublicarCouch.php?id="+ pagina +"&hacer="+0;
	 if(confirm("seguro que quiere DESPUBLICAR este Couch?")){
		 
		 location.href=direccion;
		 }
		
	 } 


 function republicar(pagina){
	 
	 direccion="despublicarCouch.php?id="+ pagina +"&hacer="+1;
	 if(confirm("Seguro que quiere RE-PUBLICAR este Couch?")){
		 
		 location.href=direccion;
		 }
		
	 } 

</script>


</head>
<body>
  
<?php 
  include("verificarUsuario.php");
  include("menu.php");
  include("conexion.php");
      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
	


  function nombremes($mes){
    setlocale(LC_TIME, 'spanish');  
    $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
    return $nombre;
  } 	
	 

    ?>
      
<hr>
<h2 class="text-center">Todos los Usuarios<hr></h2>
<hr>
<div class="container">
  <div class="row text-center">

  <?php
   
   
   //Realizo paginación con lo siguiente::::::     
   $TAMANIO_PAGINA = 60;
   $ULTIMO_ELEMENTO=$TAMANIO_PAGINA;
   $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1 ;
   $inicio = ($pagina-1) * $TAMANIO_PAGINA;   
			          
  
  $consulta=( "Select * FROM usuarios order by fecha_registro desc");
  $consulta_lim="".$consulta." limit ".$inicio.",".$ULTIMO_ELEMENTO."";	  
  $users= $conn->query($consulta_lim);
  
   
  $filas=$users->num_rows;    
     
  $cant_todo= mysqli_num_rows($conn->query($consulta));		
  $total_paginas = ceil($cant_todo/ $TAMANIO_PAGINA);       
        
  
  
   if($filas==0){
	    echo "<span style='font-size:18px; color:#999;'>No tienes Usuarios Registrados<br><br><br>"; 
	 
	 
	 }else{
    
	
	
	echo '<table width="400" align="center" bordercolor="#CCCCCC" border="1px solid" >';
	echo '<tr style="background:#DDF;"><td>Perfil:</td><td>Fecha registrado:</td></tr>';
	$mesViejo='';
	$anioViejo='';
    while($row=$users->fetch_array()) {
       
        $fecha=utf8_encode($row['fecha_registro']);
		$anio= date("Y",strtotime($fecha)); 
		$mes= date("m",strtotime($fecha)); 
		
	    if($anio!=$anioViejo){
		   echo'<tr><td colspan="2" style="color:#22F;" ><br><br><b>Año '.$anio.'</b></td></tr>';
		   $anioViejo=$anio;
		  }
		
		if($mes!=$mesViejo){
		  echo'<tr><td colspan="2" ><br><b>'.nombreMes($mes).'</b></td></tr>';
		  $mesViejo=$mes;
		  }

		
	   echo'<td class="separados">'.utf8_encode($row['nombredeusuario']).'</td>';
       echo'<td class="separados">'.$fecha.'</td></tr>';
	   
	   
       }
	echo '</table>';
	 }
    echo '<br><br><br>';
	

   ?>
   
   
   
   
   
    <!--Las flechitasss y PAGINACIÓN:               -->
  <nav class="text-center">
    <!-- Add class .pagination-lg for larger blocks or .pagination-sm for smaller blocks-->
    <ul class="pagination">
   
   <?php

	     if($pagina>1){
	    		echo '<li> <a href="reporteListaUsuarios.php?&pagina=1" aria-label="Previous"> <span aria-hidden="true">&laquo;&laquo;</span> </a> </li>';
	   
	    echo '<li> <a href="reporteListaUsuarios.php?&pagina='.($pagina-1).'" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a> </li>'; 
		} 
	    //Si pagina está en mayor a 6:::
            if($pagina>5){
				$diferencia=5; 
				}else{ $diferencia=($pagina-1);}
		 //Si la pagina está en un índice menor a 5 del último
		    if(($total_paginas - $pagina)>5){
				$diferencia2=5; 
				}else{ $diferencia2=($total_paginas-$pagina);}
		 
		  
		for($i=$pagina-($diferencia); $i<=$pagina+$diferencia2; $i++){ 
         
		 if($pagina==$i){
			 echo '<li><a><span style="color:#000"><b>'.$i.'</b></span></a></li>';
			 } else{    
      echo '<li><a href="reporteListaUsuarios.php?&pagina='.$i.'">'.$i.'</a></li>';
			 }
	  } 
	  
	  
	   if($pagina< $total_paginas){
		   echo '<li> <a href="reporteListaUsuarios.php?&pagina='.($pagina+1).'" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>';
		    echo '<li> <a href="reporteListaUsuarios.php?&pagina='.($total_paginas).'" aria-label="Next"> <span aria-hidden="true">&raquo;&raquo;</span> </a> </li>';
		    } 
	
?>



    </ul>
  </nav>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
<?php




 
?>
 

<hr>
</body>
</html>