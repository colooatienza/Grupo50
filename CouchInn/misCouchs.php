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
  margin: 15px;
  padding: 15px;
  
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
    ?>

<hr>
<h2 class="text-center">Mis COUCHS</h2>
<hr>
<div class="container">
  <div class="row text-center">




  <?php
  

 
  $elUsuario=$_SESSION['usuario'];
  
    $couchsql = "Select * FROM couchs INNER JOIN fotos ON couchs.id = fotos.idcouch INNER JOIN ciudad ON ciudad.id = couchs.ciudad  WHERE usuario='$elUsuario' AND (fechafin> CURDATE() or fechafin='0000-00-00') GROUP BY couchs.id order by couchs.disponible desc";
       
 
   $couchs=$conn->query($couchsql);
 
 
   $filas=$couchs->num_rows;    

   if($filas==0){
	    echo "<br><br><span style='font-size:18px; color:#999;'>Todavía no cargaste ningún Couch<br><br><br>"; 
	 
	 
	 }else{
    
	
	
	echo '<table width="1000" align="center" bordercolor="#CCCCCC" border="1px solid" >';
	echo '<tr style="background:#DDF;"><td>Título:</td><td>Imagen:</td><td>Dirección:</td>';
	echo '<td>Desde:</td><td>Hasta:</td>';
	echo '</tr><tr><td colspan=8 ><hr class="fondo"></td></tr>';
	
    while($row=$couchs->fetch_array()) {
        if($row['disponible']==0){ echo '<tr style="background:#EEEEEE;">';
		
		echo '<td><span style="color:#D00;">(Despublicado)</span><h3>'.utf8_encode($row["titulo"]).'</h3></td>';
		
		}else{ echo '<tr><td class="separados"><h3>'.utf8_encode($row["titulo"]).'</h3></td>';}
	     
	   
	    
        echo'<td><img src="images/couch/'.$row["link"].'" style="max-width:100px; max-height:100px;"></td>';
		
           
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
            
			 echo'<td class="separados"><a href="consultaCouch.php?id='.$row[0].'" role="button"></span><img src="images/detalles.png" width="15" height="15"> Ver Detalles</a></td>';
			 
			 
			 echo'<td class="separados"><a href="modificarCouch.php?idCouch='.$row[0].'" role="button"></span><img src="images/editar.png" width="15" height="15" alt="sd"> Modificar</a></td>';
			
			
			 if($row['disponible']==0){
			
				  echo'<td class="separados"><a  role="button" onClick="republicar('.$row[0].')"></span> Republicar</a></td>';
				 
				 
			 }else{
			 echo'<td class="separados"><a  role="button" onClick="despublicar('.$row[0].')"></span><img src="images/eliminar.png" width="15" height="15" > Despublicar</a></td>';}
			
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
<hr>




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
</body>
</html>