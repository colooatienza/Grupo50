<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Couch</title>
<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estiloConsultaCouch.css';> 



</style>



 <div id="apDiv2"><span class="logo"><img src="images/logo.png" width=160px; height=40px;></span> <span class="decorado"><img src="images/casas.png" width=200px; height=40px;> </span></div>
<div id="apDiv3"></div>

</head>


<body>

	<?php
    
//Pagina que la cuenta
	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : null ;
	
	
	
	//Me conecto a la BD
     include("conexion.php");
		
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error);} 



    $tamanio_pagina = 4;
    $ultimoElemento=$tamanio_pagina;
	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : null ;
    
  
  
   if ($pagina==0) {
     $inicio = 0;
     $pagina=1;
	
   }else {
    $inicio = ($pagina-1) * $tamanio_pagina;
	 $primerElemento=$inicio;
	  }

 $primerElemento= isset($_GET['primerElemento']) ? $_GET['primerElemento']:1 ;
 $id_couch= isset($_GET['id'])?$_GET['id']: header('Location: index.html');

  echo $primerElemento;
  
  //Consulta la BD:::
   $sql_couch = "select * from couchs INNER JOIN usuarios2 ON usuarios2.nombredeusuario=couchs.usuario INNER JOIN ciudad ON ciudad.id = couchs.ciudad INNER JOIN provincia ON provincia.id= ciudad.provincia_id where couchs.id=".$id_couch."";
  $sql = "select * from fotos where idcouch=".$id_couch."";
  $sql_pagina="".$sql." limit ".$inicio.",".$ultimoElemento."";
  
  $consulta_couch="select * from couchs where id=".$id_couch."";
  
   $cant=$conn->query($sql);
   $result=$conn->query($sql_pagina);
   $couch=$conn->query($sql_couch);

  $cantidad_fotos=mysqli_num_rows($cant);
  $elementosLogicos= mysqli_num_rows($result);
  $total_paginas = ceil($cantidad_fotos/ $tamanio_pagina);
  if($primerElemento>=$cantidad_fotos){ $primerElemento=$cantidad_fotos;}
      
	  $registro=$couch->fetch_array(MYSQLI_BOTH);

  /*
   $consulta_usuarios=$conn->query("select * from usuarios2 where idusuario=".$registro['usuario']."");
   $usuarios=$consulta_usuarios->fetch_array(MYSQLI_BOTH);
   
   $consulta_ciudad=$conn->query("select * from ciudad where id=".$registro['ciudad']."");
   $ciudad=$consulta_ciudad->fetch_array(MYSQLI_BOTH);  
   
  
   $consulta_provincia=$conn->query("select * from provincia where id=".$ciudad['provincia_id']."");
   $provincia= $consulta_provincia->fetch_array(MYSQLI_BOTH);
*/
   ?>
  
  
  
  
  
   <!-- ARMO UN DIV Y DENTRO UNA TABLA CON ALGUNAS CARACTERÍSTICAS -->
  <div class="recuadro_consulta_couch">
  <table width="800" border="0" style="padding-left:20px;">
 
 
    <!--1: La primer fila EL título del COUCH quién publicó el anuncio: -->
    <tr>
    <td colspan="4"><p>
     <span class="titulo"> <?php  echo utf8_encode($registro['titulo']);  ?>
          </span></p>
      <p><b> Publicado por:</b> <?php  echo utf8_encode($registro['nombredeusuario']);  ?></p></td>
    <td align="center"><p><b> <br></b>
   
      </p></td>
    </tr>
    <tr>
      <td colspan="5"><hr /></td>
    </tr> 
    
    


     <!--2: Segunda fila LA imagen en grande: <anterior y siguiente> -->
    <tr>
    
    <!--Primer columna ANTERIOR-->
    <td width="119"  align="right">
   <?php
    $url="";  
   $arreglo[1]=0; $i=1;
  while($row=$result->fetch_array(MYSQLI_BOTH)){
	$arreglo[$i]=$row['id'];	$i++; }
 
 //Paginar las Imágenes grandes:::  Columna 1:  Anterior <<
 if($primerElemento>1 || $pagina!=1)
   echo '<a href="'.$url.'?&pagina='.($pagina).'&primerElemento='.($primerElemento-1).'">  <img src="images/flecha.png" onmouseover="this.src=\'images/flecha2.png\'"  onmouseout="this.src=\'images/flecha.png\'" width="54" height="54" alt="flecha2" /></a>';
    ?>
   
   </td>
    
    

    
    <!--:   Segunda columna IMAGEN EN GRANDE-->
    <td colspan="3"  align="center">
    <?PHP
     echo '&nbsp;&nbsp;<img src="imagenCouch.php?id='.$arreglo[$primerElemento].' "style="max-width:500px;   max-height:500px;    min-height:110px;" " onerror="this.src=\'images/sin_imagen.png\'">';
     ?>
    </td>
    
    
    <!--Tercer columna SIGUIENTE -->
    <td width="135" align="left">
   <?php
    if($total_paginas > $pagina || $primerElemento < $elementosLogicos )
    echo '<a href="'.$url.'?&pagina='.($pagina).'&primerElemento='.(   $primerElemento+1).'"><img src="images/flecha3.png" onmouseover="this.src=\'images/flecha4.png\'"  onmouseout="this.src=\'images/flecha3.png\'" width="54" height="54" alt="flecha3" /></a>';
    ?>

    </td>
    
    </tr><tr>
    
    
    
    
    
    
    
    
    <!--Tercer FILA imágenes en chico:::-->
    <td colspan="5" align="center"> <br><br>
    <?php
    if($primerElemento==0){
	$primerElemento=$ultimoElemento;
	 header('Location:consultaCouch.php?pagina='.($pagina-1).' & primerElemento='.$primerElemento.'');
	}

if($primerElemento > $ultimoElemento){
	$primerElemento=1;
  header('Location:consultaCouch.php?pagina='.($pagina+1).' & primerElemento='.$primerElemento.'');}


 $i=1;
 while($i<=$elementosLogicos){
		
   echo '<a href="consultaCouch.php?pagina='.($pagina).'& primerElemento='.($i).'"><img src="imagenCouch.php?id='.$arreglo[$i].' "style="max-width:120px;   max-height:120px;    min-height:60px;" " onerror="this.src=\'images/sin_imagen.png\'"></a>';
echo '&nbsp;&nbsp;&nbsp';
$i++;
 
}
 echo'<br>';
 
 
  if ($total_paginas > 1) {       
   if ($pagina != 1)
       
      echo '<a href="? & pagina='.($pagina-1).'"><p1><-ant</p1></a>';
      echo '&nbsp;&nbsp;&nbsp;';
     for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
                echo '&nbsp;&nbsp;&nbsp;'.$pagina. '&nbsp;&nbsp;&nbsp;';
          else
           
            echo '&nbsp;&nbsp;&nbsp;<a href="'.$url.'?  & pagina='.$i.'">'.$i.'</a>&nbsp;&nbsp;&nbsp';
      }
	  echo '&nbsp;&nbsp;&nbsp;';
       if ($pagina != $total_paginas)
         echo '<a href="'.$url.'?  & pagina='.($pagina+1).'"><p1>sig->&nbsp;</p1></a>';
		 
} 
  echo '<br><br>';	
    ?>
    </td></tr>
    <tr>
      <td colspan="5" align="center"><hr /></td>
    </tr>
    <tr>
    
    
    
    
    <td height="48"><b>Dirección:</b></td>
    <td width="287">&nbsp;<?php  echo utf8_encode($registro['direccion']);  ?></td>
    <td width="208" align="center"><b>Ciudad:</b> <?php  echo utf8_encode($registro['ciudad_nombre']);  ?> </td>
    <td colspan="2" align="center"><b>Provincia:</b> <?php  echo utf8_encode($registro['provincia_nombre']);  ?> </td>
    </tr>
    <tr>
      <td height="32"><b>Fecha Inicio:</b></td>
      <td colspan="4">&nbsp;<?php  echo utf8_encode($registro['fechainicio']);  ?></td>
    </tr>
    <tr>
      <td height="38"><b>Fecha Fin:</b></td>
      <td colspan="4">&nbsp;<?php  echo utf8_encode($registro['fechafin']);  ?></td>
    </tr>
    <tr>
      <td><b>Descripción:</b></td>
      <td colspan="4">&nbsp;<?php  echo utf8_encode($registro['couchs']['descripcion']);  ?></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>

  
 
  
  <p>
    <?php

/* mysqli_free_result($cant);
  mysqli_free_result($result);
   mysqli_free_result($couch);
    mysqli_free_result($consulta_usuarios);
	    mysqli_free_result($consulta_ciudad);
		    mysqli_free_result($consulta_provincia);

*/
?>
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <hr />
</div>
</body>
</html>