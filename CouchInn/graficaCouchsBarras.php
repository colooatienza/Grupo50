<?php
require_once("lib/jpgraph/jpgraph.php");
require_once("lib/jpgraph/jpgraph_bar.php");

  include("conexion.php");
  include("verificarUsuario.php");
  
   if($_SESSION["admin"]==false)
      header("Location: index.php");

  
 $i=0;
 
  $fecha_inicio = isset($_GET['fechaI']) ? $_GET['fechaI']:''; 
  $fecha_fin = isset($_GET['fechaF']) ? $_GET['fechaF']:''; 
   $CadenaInicio='';
    $CadenaFin='';
 
  if($fecha_inicio!=''){
	  $CadenaInicio=' and solicitud.aceptado>="'.$fecha_inicio.'"';
	  }
    if($fecha_fin!=''){
	  $CadenaFin=' and solicitud.aceptado<="'.$fecha_fin.'"';
	  }
	 
  $Cadena_total=' '.$CadenaInicio.' '.$CadenaFin.' ';
 
  $consultaCouch=$conn->query( "Select count(*),tipo from Solicitud inner join couchs on couchs.id=solicitud.idcouch inner join tipos_couch on tipos_couch.id=idtipo where estado='aceptado' ".$Cadena_total." group by tipo");

 
 $valor= ($consultaCouch->num_rows)*110;
 

//Instancia del objeto del tipo Graph en donde como parametro
// se le pasan los valore de ancho y altura
$grafica = new Graph($valor,440);
$grafica->SetScale("textlin");



//Posición de los puntos del eje de las Y
$mayor = array(0,0,0,0,0,0);
$menor = array(0,0,0,0,0,0);


$grafica->yaxis->SetTickPositions($mayor,$menor); 
$grafica->SetBox(false);
//Nombre de las columnas

 $i=0;
 while( $filas=$consultaCouch->fetch_array()){
    $datos[$i]=$filas["0"];
	$cantidad[$i]=$filas["0"];
	$columnas[$i]=$filas["0"]."\n\n".$filas["1"];
	$i++;
	
  
	}








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


