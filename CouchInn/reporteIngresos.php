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
    .separados{
  margin: 10px;
  padding: 10px;
  
	}
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
 .bot{
	  background:#66F;
	  color:#FFF;
	   border-radius:4px;
	  border-color:2px black solid;
	  margin:2px;
	  padding:2px;
	 }
</style>



</head>
<body>
  
<?php 
  include("libchart/libchart/classes/libchart.php");
  include("verificarUsuario.php");
  include("menu.php");
  include("conexion.php");
   
   if($_SESSION["admin"]==false)
      header("Location: index.php");
	 
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
<h2 class="text-center">Reporte de Ingresos
  <hr></h2>

<div class="container">
  <div class="row text-center">
      <?php
      $fecha_inicio = isset($_GET['fechaI']) ? $_GET['fechaI']:''; 
      $fecha_fin = isset($_GET['fechaF']) ? $_GET['fechaF']:''; 
	  $inpu="";
	  $Cadena_inicio='';
	  $Cadena_fin='';
	   
	    if($fecha_inicio!='' and $fecha_fin!=''){
			 if($fecha_inicio > $fecha_fin)
			    $fecha_inicio=$fecha_fin;
			} 
	    
	    if($fecha_inicio!='' ){	
		 
		 $Cadena_inicio='AND (( fecha>= "'.$fecha_inicio.'"))';}
	   
	
	   if($fecha_fin!=''){	
		 $Cadena_fin='AND (( fecha<= "'.$fecha_fin.'"))'; }
	
	    
	
	    $Cadena_total= ' '.$Cadena_inicio.' '.$Cadena_fin.' ';
	  
	  ?>
      
    
     
    
    
      <div class="filtros">
      <form method="get"  action="reporteIngresos.php"  name="filtro" id="filtro"  ENCTYPE="multipart/form-data" >
    <table align="center"><tr>
    <td><b> Filtrar fechas
    <br>(antes que hoy)</b></td>
    
    <td class="separados" ><p>Fecha desde:
      </p>
      <p>
        <input type="date" class="<?php echo $inpu;?>" name="fechaI" value="<?php echo $fecha_inicio;?>"onBlur="enviar_filtro()">
      </p></td>
    
    <td class="separados"><p>Hasta:
      </p>
      <p>
        <input type="date" class="<?php echo $inpu;?>" name="fechaF" value="<?php echo $fecha_fin;?>"onBlur="enviar_filtro()">
      </p></td>
     
    </tr></table>
      <form>
    </div>
    
  <?php
   
   
   //Realizo paginación con lo siguiente::::::     
   $TAMANIO_PAGINA = 60;
   $ULTIMO_ELEMENTO=$TAMANIO_PAGINA;
   $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1 ;
   $inicio = ($pagina-1) * $TAMANIO_PAGINA;   
			          
    
  $consulta=( "
  SELECT * FROM pagos INNER JOIN tarjetas ON pagos.tarjeta = tarjetas.id WHERE usuario=usuario  ".$Cadena_total." order by fecha desc");
  $consulta_lim="".$consulta." limit ".$inicio.",".$ULTIMO_ELEMENTO."";	  
  $users= $conn->query($consulta_lim);
  
   
  $filas=$users->num_rows;    
     
  $cant_todo= mysqli_num_rows($conn->query($consulta));		
  $total_paginas = ceil($cant_todo/ $TAMANIO_PAGINA);       
        
  
  
  
  
  $sql2="SELECT tarjetas.tarjeta, sum(monto) FROM pagos  INNER JOIN tarjetas ON pagos.tarjeta = tarjetas.id  ".$Cadena_total." GROUP BY tarjetas.id";
			$result2=$conn->query($sql2) or die (mysql_error());
	$num_results = $result2->num_rows;
     $total=0; $sum=0;
	if( $num_results > 0){
	      //new pie chart instance
	    $chart = new PieChart( 700, 300 );
	 
	    //data set instance
	    $dataSet = new XYDataSet();
	    
        while( $row = $result2->fetch_array() ){
            $name= $row[0];
            $sum=$row[1];
            $dataSet->addPoint(new Point("{$name} $ ".$sum, $sum));
        }
		$total=$sum;
        //finalize dataset
        $chart->setDataSet($dataSet);
 
        //set chart title
        $chart->setTitle("Monto por tarjeta");
        
        //render as an image and store under "generated" folder
        $chart->render("images/1.png");
    
        //pull the generated chart where it was stored
        echo " <center> <img  align='middle' alt='Pie chart'  src='images/1.png' style='border: 1px solid gray;'/></center>";
    
    }else{
    }
  
  
  
    echo '<br><br>Suma total: <b>$ '.$total.'</b><br><br>';
  
  
  
  
  
  
   if($filas==0){
	    echo "<span style='font-size:18px; color:#999;'>No tienes Usuarios Registrados en la fecha<br><br><br>"; 
	 
	 
	 }else{
    
	
	
	echo '<table width="400" align="center" bordercolor="#CCCCCC" border="1px solid" >';
	echo '<tr style="background:#DDF;">';
	echo '<td class="separados">Fecha</td><td class="separados">Usuario</td><td class="separados">Monto</td><td class="separados">Targeta</td></tr>';
	$mesViejo='';
	$anioViejo=''; 
    $total = 0;
	
	
	
	while($row=$users->fetch_array()){
		$total+= $row["monto"];
		
		echo' <tr><td class="separados">'.date('d/m/y', strtotime(utf8_encode($row['fecha']))).'</td>';
	    echo '<td class="separados"><a href="perfil.php?id='.utf8_encode($row["usuario"]). '">'.utf8_encode($row["usuario"]). '</a></td>
			<td class="separados">$ '.$row["monto"].'</td>
			<td class="sepadados">'.$row[6].'</td>
			</tr>';

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

        $cadena_get='fechaI='.$fecha_inicio.'&fechaF='.$fecha_fin.'';
 
       $inpu='inpu';
      //Paginación!!!
	     if($pagina>1){
	    		echo '<li> <a href="reporteIngresos.php?'.$cadena_get.'&pagina=1" aria-label="Previous"> <span aria-hidden="true">&laquo;&laquo;</span> </a> </li>';
	   
	    echo '<li> <a href="reporteIngresos.php?'.$cadena_get.'&pagina='.($pagina-1).'" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a> </li>'; 
		} 
	    //Si pagina está en mayor a 60:::
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
      echo '<li><a href="reporteIngresos.php?'.$cadena_get.'&pagina='.$i.'">'.$i.'</a></li>';
			 }
	  } 
	  
	  
	   if($pagina< $total_paginas){
		   echo '<li> <a href="reporteIngresos.php?'.$cadena_get.'&pagina='.($pagina+1).'" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>';
		    echo '<li> <a href="reporteIngresos.php?'.$cadena_get.'&pagina='.($total_paginas).'" aria-label="Next"> <span aria-hidden="true">&raquo;&raquo;</span> </a> </li>';
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