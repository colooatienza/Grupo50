<?php
require_once("lib/jpgraph/jpgraph.php");
require_once("lib/jpgraph/jpgraph_bar.php");

$datos = array(62,105,85,50,45,70,100,145);

//Instancia del objeto del tipo Graph en donde como parametro
// se le pasan los valore de ancho y altura
$grafica = new Graph(700,440);
$grafica->SetScale("textlin");

//Posición de los puntos del eje de las Y
$mayor = array(0,30,60,90,120,150);
$menor = array(15,45,75,105,135);

$grafica->yaxis->SetTickPositions($mayor,$menor); 
$grafica->SetBox(false);
//Nombre de las columnas
$columnas = array('A','B','C','D','E','F','G','H');
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


