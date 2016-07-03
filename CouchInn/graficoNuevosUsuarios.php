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
	.grafico{
	   background:#E00;	
	   border-radius:2px;
	   border:2px solid;
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
     
  
    $users=$conn->query( "Select * FROM usuarios order by fecha_registro desc");
       
 
  
   $filas=$users->num_rows;    
        
        
   if($filas==0){
	    echo "<span style='font-size:18px; color:#999;'>No tienes Usuarios Registrados<br><br><br>"; 
	 
	 
	 }else{
    
	
	
	echo '<table width="400" align="center" bordercolor="#CCCCCC" border="1px solid" >';
	echo '<tr style="background:#DDF;"><td>Perfil:</td><td>Fecha registrado:</td></tr>';
	
    while($row=$users->fetch_array()) {
       
        $fecha=$row['fecha_registro'];
		
       echo'<td class="separados">'.utf8_encode($row['nombredeusuario']).'</td>';
       echo'<td class="separados">'.$fecha.'</td></tr>';
    }
	echo '</table>';
	 }
    echo '<br><br><br>';
	
	
	$FechaHoy=date('y-m-d');
	$Fecha1sem= date('Y-m-d', strtotime('-1 week'));
	$Fecha2sem= date('Y-m-d', strtotime('-2 week'));
	$Fecha3sem= date('Y-m-d', strtotime('-3 week'));
    $Fecha4sem= date('Y-m-d', strtotime('-4 week'));
	$Fecha2mes= date('Y-m-d', strtotime('-2 month'));
    $Fecha3mes= date('Y-m-d', strtotime('-3 month'));
	$Fecha4mes= date('Y-m-d', strtotime('-4 month'));
    $Fecha5mes= date('Y-m-d', strtotime('-5 month'));
	

 $i=0;
while($i<12){
	    
		$mes= date('Y-m-00', strtotime('-'.(11-$i).' month'));
		$mesAntes= date('Y-m-00', strtotime('-'.(11-$i+1).' month'));
		$consultaMes=$conn->query( "Select fecha_registro, month(fecha_registro) as mes FROM usuarios  where fecha_registro Between '$mesAntes' AND '$mes'");
	    $columnas=$consultaMes->num_rows;
		echo $columnas.'<br>';
	 $datos[$i]=($columnas)*20;
  $i++;
  }









?>

 

  </div>
  <nav class="text-center">
    <!-- Add class .pagination-lg for larger blocks or .pagination-sm for smaller blocks-->
    <ul class="pagination">


    </ul>
  </nav>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
<?php




 
?>
 

<hr>
</body>
</html>