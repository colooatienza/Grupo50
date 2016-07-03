<?php
require_once 'jpgraph/jpgraph.php';
require_once 'jpgraph/jpgraph_bar.php';

$grafica = new Graph(500, 400);
$grafica->img->SetMargin(50,40,20,0);

$grafica->SetScale("textlin", 5, 10);

//Asigna el titulo al grafico
$grafica->title->Set("Calificaciones");

//Asigna el titulo al eje x
$grafica->xaxis->SetTitle("Alumnos");

//Asigna el titulo y alineacion al eje y
$grafica->yaxis->SetTitle("Calificaciones","middle");

//Asigna las etiquetas para los valores del eje x
$grafica->xaxis->SetTickLabels(array("Ana","Sonia","Sebastian","Joel"));

//crea una serie para un grafico de barras
$fisica = new BarPlot(array(9,8,10,9));

//asigna la leyenda para la serie fisica
$fisica->SetLegend("Fisica");

//asigna el color de relleno de las barras en formato hexadecimal
$fisica->SetFillColor("#E234A9");

//crea una serie para el grafico de barras
$matematicas = new BarPlot(array(8,10,9,10));

//asigna la leyenda para la serie matematicas
$matematicas->SetLegend("Matematicas");

//asigna el color de relleno de las barras con el nombre del color
$matematicas->SetFillColor("blue");

//crea una serie para el grafico de barras
$quimica = new BarPlot(array(10,9,9,8));

//asigna la leyenda para la serie quimica
$quimica->SetLegend("Quimica");

/*asigna el color de relleno de las barras, en este caso un relleno
degradado vertical que va de naranja a rojo, los tipos de degradado
los encuentras en la documentación*/
$quimica->SetFillgradient('orange','red',GRAD_VER); 

// agrupa las series del grafico
$materias = new GroupBarPlot(array($fisica,$matematicas,$quimica));

//agrega al grafico el grupo de series
$grafica->Add($materias);

//muestra el grafico
$grafica->Stroke();
?>