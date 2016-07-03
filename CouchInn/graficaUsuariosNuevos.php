<?php
require_once("lib/jpgraph/jpgraph.php");
require_once("lib/jpgraph/jpgraph_bar.php");

  include("conexion.php");
     


 
 $datos=array();
 
 
 $i=0;
while($i<12){
	    $mes= date('Y-m-00', strtotime('-'.(10-$i).' month'));
		$mesAntes= date('Y-m-00', strtotime('-'.(10-$i+1).' month'));
	 	$consultaMes=$conn->query( "Select fecha_registro, month(fecha_registro) as mes FROM usuarios  where fecha_registro Between '$mesAntes' AND '$mes'");
		$cantidad[$i]=$consultaMes->num_rows;
	    $columnas=$consultaMes->num_rows;
	 $datos[$i]=($columnas);
  $i++;
  }



  function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
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


for($i=0; $i<12; $i++){
	$mes=nombremes(date('m', strtotime('-'.(11-$i).' month')));
    
	
$cantidad[$i]=$cantidad[$i]."\n".$mes;
	 if($mes=='enero')
	    $cantidad[$i]=$cantidad[$i]."\n\n".date("Y")." >>";
	
	}




$columnas = array($cantidad[0],$cantidad[1],$cantidad[2],$cantidad[3],$cantidad[4],$cantidad[5],$cantidad[6]
,$cantidad[7],$cantidad[8],$cantidad[9],$cantidad[10],$cantidad[11]);




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


