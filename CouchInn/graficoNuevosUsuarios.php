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
<h2 class="text-center">Todos los Usuarios</h2>
<hr>
<div class="container">
  <div class="row text-center">

     


  <?php
                     
  
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