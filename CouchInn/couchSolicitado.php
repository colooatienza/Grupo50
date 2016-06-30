<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CouchInn</title>
<script src="js/jquery-1.11.3.min.js"></script> 
<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="Css/c.css">
  	<link rel="icon" href="images/logo.jpg">
</head>
<body>
	<?php
	include("verificarUsuario.php");
	
    function validar(){
        if (!isset($_POST['inicio'])){
            return false;
        }
        if (!isset($_POST['fin'])){
            return false;
        }
		if (!isset($_POST['descripcion'])|| strlen(str_replace(' ','',$_POST['descripcion']))==0){
            return false;
        }
		if (!isset($_POST['id'])|| strlen(str_replace(' ','',$_POST['id']))==0){
            return false;
        }
		if (!isset($_POST['personas'])|| strlen(str_replace(' ','',$_POST['personas']))==0){
            return false;
        }
        return true;
    }
	
    if (validar()){
		include("conexion.php");
		include("menu.php");
		
		echo'</br></br></br></br></br><div class="divTipo" style="width:400px;">';
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$inicio=$_POST['inicio'];
		$fin=$_POST['fin'];



	
				
		
		//Si el mismo usuario lo quiere Registrar 2 veces el mismo COUCH:::::::::::::
		
		$sql_mismoUsuario = "Select * from solicitud where estado!= 'rechazado' and idusuario='".$_SESSION['usuario']."'  AND idcouch='".$_POST['id']."' and fin>Curdate()";
		$resultado=$conn->query($sql_mismoUsuario);
		
		if($resultado->num_rows!=0){
			 echo '<h4 align="center"> Usted ya tiene una solicitud a este Couch! </h4>';
		}else{

        //SI EL USUARIO TIENE un aceptado de OTRO couch en el rango de fechas que quiere solicitar este.
		$sql_AceptadoOtro = "Select * from solicitud where estado= 'aceptado' and idusuario='".$_SESSION['usuario']."'  and ((fin BETWEEN '".$inicio."' AND '".$fin."') OR inicio BETWEEN  '".$inicio."'AND '".$fin."'  OR(('".$fin."' BETWEEN inicio AND fin) OR '".$inicio."' BETWEEN  inicio AND fin)) AND (inicio <> '".$fin."') AND (fin <> '".$inicio."') ";
		$resultado2=$conn->query($sql_AceptadoOtro);
		
		if($resultado2->num_rows!=0){
			
			     echo '<h4 align="center"> Usted Tiene un Aceptado de otro Couch en ESA FECHA<br> Búsquelo en mis solicitudes </h4>';
			}else{
		  
		
		
$sql = "Select * from solicitud where estado= 'aceptado' AND idcouch='".$_POST['id']."' and ((fin BETWEEN '".$inicio."' AND '".$fin."') OR inicio BETWEEN  '".$inicio."'AND '".$fin."'  OR(('".$fin."' BETWEEN inicio AND fin) OR '".$inicio."' BETWEEN  inicio AND fin)) AND (inicio <> '".$fin."') AND (fin <> '".$inicio."') ";






		$result=$conn->query($sql);
		if($result->num_rows==0){
           
		   //En caso que todo esté correcto pueden haber 2 casos:  que se modifique el rechazado  o que se
		   //agregue como uno nuevo
		   
		           
        if($_POST['modi']!=0){
			$modi=$_POST['modi'];
		    $resultado=$conn->query("Update solicitud set estado='pendiente', inicio='".$_POST['inicio']."', fin='".$_POST['fin']."', personas='".$_POST['personas']."',descripcion='".$_POST['descripcion']."'
		  where id=$modi");
			
			}	else{
		   
		$sql = "INSERT INTO `solicitud`(`inicio`, `fin`, `personas`, `descripcion`, `estado`, `idcouch`, `idusuario`) VALUES ('".$_POST['inicio']."','".$_POST['fin']."','".$_POST['personas']."','".$_POST['descripcion']."', 'pendiente', '".$_POST['id']."', '".$_SESSION['usuario']."' ) ";
		$conn->query($sql);
		
			}
			
			
		echo '<h4 align="center"> Ha solicitado el Couch exitosamente! </h4>';

		
		} else{
		echo '<h4 align="center"> El Couch se encuentra ocupado en la fecha solicitada! </h4>';
		}


		
		
    if($result->num_rows!=0){
        $solicitudes=$conn->query("select * from solicitud where idcouch='".$_POST['id']."' and estado='aceptado'");  
        echo '<br><br><br>';
       
          echo "No puede solicitar entre las siguientes fechas";
          echo '<div style="background:#FAA;">';
		   while($filas=$solicitudes->fetch_array()){
		  
          echo '|'.$filas['inicio'].'---------------';
		  echo $filas['fin'].'|<br>';
		  
		  } 
         }   
		}
		}
   }else {
   		echo 'Los datos ingresados son inválidos, reintentar...';
   }
   
	
	
	   echo '<a href="index.php">Volver al inicio</a>';
	   echo '</div>';
   
   
   
   echo'</div>';

   




?>


 
</body>
</html>