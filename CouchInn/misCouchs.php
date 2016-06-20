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
</head>
<body>
<?php 
  include("verificarUsuario.php");
  include("menu.php");
  include("conexion.php");
      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
    ?>

<hr>
<h2 class="text-center">Mis COUCHS</h2>
<hr>
<div class="container">
  <div class="row text-center">




  <?php
  

 
  $elUsuario=$_SESSION['usuario'];
  
    $couchsql = "Select * FROM couchs INNER JOIN fotos ON couchs.id = fotos.idcouch INNER JOIN ciudad ON ciudad.id = couchs.ciudad  WHERE disponible=1 and usuario='$elUsuario'  AND fechafin> CURDATE() GROUP BY couchs.id order by couchs.fechafin desc";
       
 
   $couchs=$conn->query($couchsql);
 
 
    
   

 
    
	echo '<table width="200" align="center" border="1">';
	
    while($row=$couchs->fetch_array()) {
           
	     
	    echo'<tr><td><h3>'.utf8_encode($row["titulo"]).'</h3></td>';
	 
        echo'<td><img src="images/couch/'.$row["link"].'" style="max-width:100px; max-height:100px;"></td>';
		
           
       echo'<td>'.utf8_encode($row['ciudad_nombre']).'</td>';
			

		//Con estas líneas pongo la fecha inicio como hoy si llegara a ser anterior a la actual	
			
			$fecha= date('d/m/y', strtotime(utf8_encode($row['fechainicio']))). '<br><br>';
			$dia_bd= intval(substr($fecha,0,2));
			$mes_bd= intval(substr($fecha,3,2));
			$anio_bd = intval(substr($fecha,6,2));
		    
			$fecha=date('d/m/y');  
			$dia_hoy=intval(substr($fecha,0,2));	
			$mes_hoy=intval(substr($fecha,3,2));	
			$anio_hoy=intval(substr($fecha,6,2));	
               $fecha_menor=false;
			  if($anio_bd <= $anio_hoy){
			          
					   if($anio_bd==$anio_hoy){
						   if($mes_bd<=$mes_hoy){
							   
							   if($mes_bd==$mes_hoy){
								    if($dia_bd<=$dia_hoy){
										$fecha_menor=true;}
								   }else{$fecha_menor=true;}
							}}else{ $fecha_menor=true; }
			   
				  }
				
			     if($fecha_menor==true){ $fecha=date('d/m/y');}else{ $fecha= date('d/m/y',strtotime(utf8_encode($row['fechainicio'])));}
				 
		  
   ////----------------------
   
             
			echo'<td>'.$fecha.'</td>';
            echo'<td>'.date('d/m/y', strtotime(utf8_encode($row['fechafin']))).'</td>';
             echo'<td><a href="consultaCouch.php?id='.$row[0].'" role="button"></span>Ver Detalles</a></td>';
			 echo'<td><a href="consultaCouch.php?id='.$row[0].'" role="button"></span>Modificar</a></td>';
			 echo'<td><a href="consultaCouch.php?id='.$row[0].'" role="button"></span>Despublicar</a></td>';
			echo '</tr>';
    }
	echo '</table>';
?>
  


  </div>
  <nav class="text-center">
    <!-- Add class .pagination-lg for larger blocks or .pagination-sm for smaller blocks-->
    <ul class="pagination">


    </ul>
  </nav>
</div>
<hr>




<footer class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p> ______</p>
      </div>
    </div>
  </div>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
</body>
</html>