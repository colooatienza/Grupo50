<?php
require_once("lib/jpgraph/jpgraph.php");
require_once("lib/jpgraph/jpgraph_bar.php");

  include("conexion.php");
     
 
  include("verificarUsuario.php");
   if($_SESSION["admin"]==false)
      header("Location: index.php");
	  

 
 $datos=array();
 
 
 $i=0;
while($i<4){
	    $mes= date('Y-m-d', strtotime('-'.(3-$i).' week'));
		$mesAntes= date('Y-m-d', strtotime('-'.(3-$i+1).' week'));
	 	$consultaMes=$conn->query( "Select * FROM usuarios  where fecha_registro > '$mesAntes' AND fecha_registro<= '$mes'");
		$cantidad[$i]=$consultaMes->num_rows;
	    $columnas=$consultaMes->num_rows;
	 $datos[$i]=($columnas);
  $i++;
  }
  
  

	




//Instancia del objeto del tipo Graph en donde como parametro
// se le pasan los valore de ancho y altura
$grafica = new Graph(850,440);
$grafica->SetScale("textlin");




//Posición de los puntos del eje de las Y
$mayor = array(0,0,0,0,0,0);
$menor = array(0,0,0,0,0,0);


$grafica->yaxis->SetTickPositions($mayor,$menor); 
$grafica->SetBox(false);
//Nombre de las columnas

for($i=0; $i<4; $i++){
	$mes=(4-$i). ' Semanas atrás';
	
    
	
$cantidad[$i]=" ".$cantidad[$i]."\n Usuarios\n\n ".$mes;
	
	
	}

 $cantidad[0]= $cantidad[0]."\n ".date('Y-m-d', strtotime('-'.(3).' week'));;


$columnas = array($cantidad[0],$cantidad[1],$cantidad[2],$cantidad[3]);




$grafica->xaxis->SetTickLabels($columnas);
//Objeto del tipo BarPlot que se le enviara a la gráfica y el cual
//recibe como parametros los datos a graficar
$barras = new BarPlot($datos);

$grafica->Add($barras);
//Color de los bordes 

//Color de borde de las barras
$barras->SetColor("white");
//Color de relleno de las barras
$barras->SetFillColor("#4B0072");
//Ancho de las barras
$barras->SetWidth(40);

$grafica->Stroke();


