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
<h2 class="text-center">Couchs donde me alojé</h2>
<hr>
<div class="container">
  <div class="row text-center">

     


  <?php
                     
  
  $elUsuario=$_SESSION['usuario'];
     
  
    $couchsql = "Select * FROM couchs INNER JOIN fotos ON couchs.id = fotos.idcouch INNER JOIN ciudad ON ciudad.id = couchs.ciudad INNER JOIN solicitud ON solicitud.idcouch= couchs.id WHERE solicitud.idusuario='$elUsuario' AND estado='aceptado' GROUP by couchs.id";
       
 
   $couchs=$conn->query($couchsql);
     
 
   $filas=$couchs->num_rows;    
        
        
   if($filas==0){
	    echo "<span style='font-size:18px; color:#999;'>Todavía no te has alojado en ningún Couch<br><br><br>"; 
	 
	 
	 }else{
    
	
	
	echo '<table width="1000" align="center" bordercolor="#CCCCCC" border="1px solid" >';
	echo '<tr style="background:#DDF;"><td>Título:</td><td>Imagen:</td><td>Dirección:</td>';
	echo '<td>Desde:</td><td>Hasta:</td>';
	echo '</tr><tr><td colspan=8 ><hr class="fondo"></td></tr>';
	
    while($row=$couchs->fetch_array()) {
        if($row['disponible']==0){ echo '<tr style="background:#EEEEEE;">';
		
		echo '<td><span style="color:#D00;">(Despublicado)</span><h3>'.utf8_encode($row["titulo"]).'</h3></td>';
		
		}else{ echo '<tr><td class="separados"><h3>'.utf8_encode($row["titulo"]).'</h3></td>';}
	     
	   
	    
      //  echo'<td><img src="images/couch/'.$row["link"].'?time()" style="max-width:100px; max-height:100px;"></td>';
		?> <td><img src="images/couch/<?php echo $row["link"];?>?<?php echo time();?>" style="max-width:100px; max-height:100px;"></td> <?php
           
       echo'<td class="separados">'.utf8_encode($row['ciudad_nombre']).'</td>';
			

		//Con estas líneas pongo la fecha inicio como hoy si llegara a ser anterior a la actual	
			
			$fecha= utf8_encode($row['fechainicio']);
			$fechaHoy=date('20y-m-d');
     
				
			     if($fechaHoy>=$fecha){ $fecha=date('d/m/20y');}else{ $fecha= date('d/m/20y',strtotime(utf8_encode($row['fechainicio'])));}
				 
		  
   ////----------------------
   
             
			echo'<td class="separados">'.$fecha.'</td>';
			
            echo'<td class="separados">';
			if($row['fechafin']=='0000-00-00')
			  echo 'Sin Especificar';
			  else
			  echo date('d/m/20y', strtotime(utf8_encode($row['fechafin'])));
			echo'</td>';
            
			
			
			echo '</tr><tr><td colspan=8 ><hr class="fondo"></td></tr>';
    }
	echo '</table>';
	 }

	    
?>

 
  
  </div>
  <nav class="text-center">
    <!-- Add class .pagination-lg for larger blocks or .pagination-sm for smaller blocks-->
    <ul class="pagination">


    </ul>
  </nav>
</div>
<footer class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p> </p>
      </div>
    </div>
  </div>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
<?php




 
?>
 

<hr>
</body>
</html>