<?php
require_once("lib/jpgraph/jpgraph.php");
require_once("lib/jpgraph/jpgraph_bar.php");

  include("conexion.php");
     




/*
$anio= date('Y-m-d', strtotime('-'.$i.' month'));

$consultaAnio=$conn->query( "Select count(fecha_registro), month(fecha_registro) as mes FROM usuarios  where fecha_registro Between '$anio' AND Curdate() group by month(fecha_registro)");

 $resultado=$consultaAnio->fech_array();
*/
 
 $datos=array();
 
 
 $i=0;
while($i<12){
	  
		$mes= date('Y-m-d', strtotime('-'.(12-$i).' month'));
		$mesAntes= date('Y-m-d', strtotime('-'.(12-$i+1).' month'));
	 	$consultaMes=$conn->query( "Select fecha_registro, month(fecha_registro) as mes FROM usuarios  where fecha_registro Between '$mesAntes' AND '$mes'");
	    $columnas=$consultaMes->num_rows;
	 $datos[$i]=($columnas)*20;
  $i++;
  }

	
	/* 
while($resultado=$consultaAnio->fech_array()){
	$datos[$resultado[2]]=$resultado[1];
	
	}
*/


//Instancia del objeto del tipo Graph en donde como parametro
// se le pasan los valore de ancho y altura
$grafica = new Graph(900,440);
$grafica->SetScale("textlin");




//Posición de los puntos del eje de las Y
$mayor = array(0,30,60,90,120,150);
$menor = array(15,45,75,105,135);



$grafica->yaxis->SetTickPositions($mayor,$menor); 
$grafica->SetBox(false);
//Nombre de las columnas





   $i=0;

function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 



for($i=0; $i<12; $i++){
	$meses[$i]=nombremes(date('m', strtotime('-'.(12-$i).' month')));
	}

$columnas = array($meses[0],$meses[1],$meses[2],$meses[3],$meses[4],$meses[5],$meses[6]
,$meses[7],$meses[8],$meses[9],$meses[10],$meses[11]);

$grafica->xaxis->SetTickLabels($columnas);

//Objeto del tipo BarPlot que se le enviara a la gráfica y el cual
//recibe como parametros los datos a graficar
$barras = new BarPlot($datos);

$grafica->Add($barras);
//Color de los bordes 

//Color de borde de las barras
$barras->SetColor("white");
//Color de relleno de las barras
$barras->SetFillColor("#4B0082");
//Ancho de las barras
$barras->SetWidth(45);

$grafica->title->Set("Gráfica de Barras");
$grafica->title->SetFont(FF_TIMES,FS_ITALIC,18);
$grafica->Stroke();


