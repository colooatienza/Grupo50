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
.separados{
  margin: 10px;
  padding: 10px;
  
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
  session_start();
  include("menu.php");
  include("conexion.php");
      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
    ?>

<hr>
<h2 class="text-center">COUCHS</h2>
<hr>
<div class="container">
  <div class="row text-center">




  <?php
  
      $TAMANIO_PAGINA = 3;
      $ULTIMO_ELEMENTO=$TAMANIO_PAGINA;
      $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1 ;
      $inicio = ($pagina-1) * $TAMANIO_PAGINA;   
	  
	  
	 
  
  
    //filtro por provincia si llega a existir
   $laProvincia = isset($_GET['provincia']) ? $_GET['provincia']:0;
   $laCiudad = isset($_GET['ciudad']) ? $_GET['ciudad']:0; 
   $elTipo = isset($_GET['tipoo']) ? $_GET['tipoo']:0; 
   $fecha_inicio = isset($_GET['fechaI']) ? $_GET['fechaI']:'dd/mm/aa'; 
   $fecha_fin = isset($_GET['fechaF']) ? $_GET['fechaF']:'dd/mm/aa'; 
   $busqueda=  isset($_GET['busqueda']) ? $_GET['busqueda']:'';
   
   $Cadena_provincia='';  
   $Cadena_ciudad='';
   $Cadena_tipo='';
   $Cadena_inicio='';
   $Cadena_fin='';
   if($laProvincia!=0){ 
     $Cadena_provincia=' AND couchs.provincia='.$laProvincia.' ';  
	 if($laCiudad!=0){
		  $Cadena_ciudad='AND couchs.ciudad='.$laCiudad.'';
		 }
	  }
     if($elTipo!=0) 
       $Cadena_tipo=' AND couchs.idtipo='.$elTipo.' ';  


   if($fecha_fin!='dd/mm/aa' && $fecha_fin!='') 
        $Cadena_fin=' AND couchs.fechafin>="'.$fecha_fin.'"';  
	
	
	 if($fecha_inicio!='dd/mm/aa' && $fecha_inicio!='')	
         $Cadena_inicio=' AND couchs.fechainicio<="'.$fecha_inicio.'"';
	 
   $cadenaTitulo= ' AND titulo like "%'.$busqueda.'%"';
	 
	
	
	$Cadena_total= ' '.$Cadena_provincia.' ' .$Cadena_ciudad.' '.$Cadena_tipo.' '.$Cadena_fin.' '.$Cadena_inicio.' '.$cadenaTitulo.' ';
 
 
 
 
  
    $couchsql = "Select * FROM couchs INNER JOIN fotos ON couchs.id = fotos.idcouch INNER JOIN ciudad ON ciudad.id = couchs.ciudad  WHERE disponible=1 ".$Cadena_total." AND fechafin> CURDATE() GROUP BY couchs.id order by couchs.fechafin desc";
       
   $sql_couchs="".$couchsql." limit ".$inicio.",".$ULTIMO_ELEMENTO."";
   $couchs=$conn->query($sql_couchs);
 
 
   $cant_todo= mysqli_num_rows($conn->query($couchsql));		
   $total_paginas = ceil($cant_todo/ $TAMANIO_PAGINA);
 

 
 $provincias=$conn->query("select * from provincia order by provincia_nombre");
 $tipos=$conn->query("select * from tipos_couch");

//La provincia !=0
  if($laProvincia!=0){
  $provSel=$conn->query("select * from provincia where id=".$laProvincia."");
  $row_prov=$provSel->fetch_array(MYSQLI_BOTH);
  $provinciaL=$row_prov['provincia_nombre'];


  $ciudades=$conn->query("select * from ciudad where provincia_id=".$laProvincia. " order by ciudad_nombre");
  
  if($laCiudad!=0){
   
    $ciuSel=$conn->query("select * from ciudad where id=".$laCiudad." and provincia_id=".$laProvincia."");
    $row_ciu=$ciuSel->fetch_array(MYSQLI_BOTH);
	 $ciudadL=$row_ciu['ciudad_nombre'];
	 if($ciudadL=="") $laCiudad=0;
   }
  }
 
 
 
 
 
 if($elTipo!=0){
	 $tipoSel=$conn->query("select * from tipos_couch where id=".$elTipo."");
     $row_tipo=$tipoSel->fetch_array(MYSQLI_BOTH);
     $tipoL=$row_tipo['tipo'];
 
 }
 
 
 
   $cadena_get= 'provincia='.$laProvincia.'&ciudad='.$laCiudad.'&tipoo='.$elTipo.'&fechaI='.$fecha_inicio.'&fechaF='.$fecha_fin.'';
 
   $inpu='inpu';
 
 //Los combobox:
   ?>
   
   
   
    
   
    <div class="filtros">
       
         <form method="get"  action="index.php"  name="filtro" id="filtro"  ENCTYPE="multipart/form-data" >
  
   <table border="0" style="position:relative; top:0px;" align="center" valign="top">
 
  <tr><td style="background:#fafafa; width:1px;"></td><td class="separados" valign="top">
    <strong>Filtrar por:</strong>  <td style="background:#CCC; width:1px;"></td>  
  <td class="separados" valign="top">
  Fecha desde&nbsp;&nbsp;
    
    <input type="date" class="<?php echo $inpu;?>" name="fechaI" value="<?php echo $fecha_inicio;?>"onBlur="enviar_filtro()"><br><br>
  Fecha hasta&nbsp;&nbsp;   <input type="date" class="<?php echo $inpu;?>" value="<?php echo $fecha_fin;?>"name="fechaF" onBlur="enviar_filtro()"> 
 






  </td><td style="background:#fafafa; width:1px;"></td><td class="separados" valign="top">                
          <!-- Selector de provincia -->
          <select name="provincia" class="<?php echo $inpu;?>" onChange="enviar_filtro()">
            <?php while($rows=$provincias->fetch_array()) { 
       $nombre_provincia=addslashes(utf8_encode($rows['provincia_nombre']));
	   $ide_provincia=$rows['id'];
           
		     if($rows['id']==$laProvincia){
		    echo "<option name=prov value=".$rows['id']." selected=\"selected\">"     
			.htmlentities($nombre_provincia)."</ option>"; }else{			
			    echo "<option name=prov value=".$rows['id'].">"     
			.htmlentities($nombre_provincia)."</ option>";
			   }
			}
			
			if($laProvincia==0){ ?>
            <option selected value="0">Todo Argentina</option>
            <?php }else{  ?>
            
            <option value="0">Todo Argentina</option>
            <?php }  ?>
            
          </select> 
          
          
          

          
  <!-- </td><td style="background:#CCC; width:1px;"></td><td class="separados">
          <!-- Selector de ciudad --> 
          <?php if($laProvincia!=0){  ?>
            <br><br>
          <select name="ciudad"  class="<?php echo $inpu;?>"  onChange="enviar_filtro()">
            <?php while($rowsc=$ciudades->fetch_array()) { 
       $nombre_ciudad=addslashes(utf8_encode($rowsc['ciudad_nombre']));
	   $ide_ciudad=$rowsc['id'];
            echo "<option name=prov value=".$rowsc['id']." selected=\"selected\">"
            
			.htmlentities($nombre_ciudad)."</ option>"; }
			
			if($laCiudad==0){ ?>
            <option selected value="0">Cualquier Ciudad</option>
            <?php }else{  ?>
            <option selected value="<?php  echo $laCiudad; ?>"><?php echo utf8_encode($row_ciu['ciudad_nombre']);?></option>
            <option value="0">Cualquier Ciudad</option>
            <?php } ?>
            
          </select> 
          
          <?php   }   ?>
          
          
  
          
   </td><td style="background:#fafafa; width:1px;"></td><td class="separados" valign="top">
           <!-- Selector de tipo -->   
           
            <select name="tipoo" class="<?php echo $inpu;?>" onChange="enviar_filtro()">
            
			<?php while($rowst=$tipos->fetch_array()) { 
       $nombre_tipo=addslashes(utf8_encode($rowst['tipo']));
	   $ide_tipo=$rowst['id'];
	         
			  if($rowst['id']==$elTipo){
                 echo "<option name=prov value=".$rowst['id']." selected=\"selected\">"   
			.htmlentities($nombre_tipo)."</ option>"; }
			  else{
				     echo "<option name=prov value=".$rowst['id'].">"   
			.htmlentities($nombre_tipo)."</ option>";
				  }
			}			
			if($elTipo==0){ ?>
            <option selected value="0">Cualquier Tipo</option>
            <?php }else{  ?>
            
            <option value="0">Cualquier Tipo</option>
            <?php } ?>
            
          </select> 
      </td><td style="background:#fafafa; width:1px;"></td>

       <td style="background:#CCC; width:1px;"></td>  
      </td><td style="width:20px;"></td>
       
       <td>
       <input type="text" id="busqueda" name="busqueda" value=<?php echo $busqueda ?>>
       <input type="submit" value="Buscar"></td>
   </tr>
</table>
    </form>
         </div> 
  <?php
 
 
 
 
 
    while($row=$couchs->fetch_array()) {
      echo'<div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">';
        echo'<div class="thumbnail"> <img src="images/couch/'.$row["link"].'"  class="img-responsive">';
		 echo'<div class="acomodado">';
          echo'<div class="caption">';
            echo'<h3>'.utf8_encode($row["titulo"]).'</h3>';
            echo'<p>Ciudad: '.utf8_encode($row['ciudad_nombre']).'</p>';
			
			
			
			
		//Con estas líneas pongo la fecha inicio como hoy si llegara a ser anterior a la actual	
			
			$fecha= date('d/m/y', strtotime(utf8_encode($row['fechainicio']))). '<br><br>';
			$dia_bd= intval(substr($fecha,0,2));
			$mes_bd= intval(substr($fecha,3,2));
			$anio_bd = intval(substr($fecha,6,2));
		    
			$fecha=date('d/m/y');  
			$dia_hoy=intval(substr($fecha,0,2));	
			$mes_hoy=intval(substr($fecha,3,2));	
			$anio_hoy=intval(substr($fecha,6,2));	
               $fecha_menor=false;
			  if($anio_bd <= $anio_hoy){
			          
					   if($anio_bd==$anio_hoy){
						   if($mes_bd<=$mes_hoy){
							   
							   if($mes_bd==$mes_hoy){
								    if($dia_bd<=$dia_hoy){
										$fecha_menor=true;}
								   }else{$fecha_menor=true;}
							}}else{ $fecha_menor=true; }
			   
				  }
				
			     if($fecha_menor==true){ $fecha=date('d/m/y');}else{ $fecha= date('d/m/y',strtotime(utf8_encode($row['fechainicio'])));}
				 
		  
   ////----------------------
   
             
			echo'<p>Desde: '.$fecha.'</p>';
            echo'<p>Hasta: '.date('d/m/y', strtotime(utf8_encode($row['fechafin']))).'</p>';
             echo'<p><a href="consultaCouch.php?id='.$row[0].'" class="btn btn-primary" role="button"></span>Ver Detalles</a></p>';
			 echo'</div>';
          echo'</div>';
        echo'</div>';
      echo'</div>';
    }
?>
  


  </div>
  <nav class="text-center">
    <!-- Add class .pagination-lg for larger blocks or .pagination-sm for smaller blocks-->
    <ul class="pagination">






 <?php  
 	  //Las flechitasss
	     if($pagina>1){
	    		echo '<li> <a href="index.php?'.$cadena_get.'&pagina=1" aria-label="Previous"> <span aria-hidden="true">&laquo;&laquo;</span> </a> </li>';
	   
	    echo '<li> <a href="index.php?'.$cadena_get.'&pagina='.($pagina-1).'" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a> </li>'; 
		} 
	    //Si pagina está en mayor a 6:::
            if($pagina>5){
				$diferencia=5; 
				}else{ $diferencia=($pagina-1);}
		 //Si la pagina está en un índice menor a 5 del último
		    if(($total_paginas - $pagina)>5){
				$diferencia2=5; 
				}else{ $diferencia2=($total_paginas-$pagina);}
		 
		  
		for($i=$pagina-($diferencia); $i<=$pagina+$diferencia2; $i++){ 
         
		 if($pagina==$i){
			 echo '<li><a><span style="color:#000"><b>'.$i.'</b></span></a></li>';
			 } else{    
      echo '<li><a href="index.php?'.$cadena_get.'&pagina='.$i.'">'.$i.'</a></li>';
			 }
	  } 
	  
	  
	   if($pagina< $total_paginas){
		   echo '<li> <a href="index.php?'.$cadena_get.'&pagina='.($pagina+1).'" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>';
		    echo '<li> <a href="index.php?'.$cadena_get.'&pagina='.($total_paginas).'" aria-label="Next"> <span aria-hidden="true">&raquo;&raquo;</span> </a> </li>';
		    } 
	   ?>

    </ul>
  </nav>
</div>
<hr>













<footer class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p> ______</p>
      </div>
    </div>
  </div>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
</body>
</html>