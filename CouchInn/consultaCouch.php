<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/bootstrap.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Couch</title>
<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estiloConsultaCouch.css';> 
</style>
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/bootstrap.js"></script>
</head>

<body >

	<?php
    include("conexion.php");
    include("menu.php");
    if ($conn->connect_error) { 
      die("Connection failed: " . $conn->connect_error);
    } 
    $id_couch= isset($_GET['id'])?$_GET['id']: header('Location: index.php');
  
    //Consulta la BD:::
    $sql_couch = "select * from couchs INNER JOIN usuarios ON usuarios.nombredeusuario=couchs.usuario INNER JOIN ciudad ON ciudad.id = couchs.ciudad INNER JOIN provincia ON provincia.id= ciudad.provincia_id where couchs.id=".$id_couch."";
    $sql = "select * from fotos where idcouch=".$id_couch."";
  
  
    $fotos=$conn->query($sql);
    $couch=$conn->query($sql_couch);

    $datos=$couch->fetch_array();
    $cantFotos= mysqli_num_rows($fotos);
    ?>
   <!-- ARMO UN DIV Y DENTRO UNA TABLA CON ALGUNAS CARACTERÍSTICAS -->
  <div class="recuadro_consulta_couch" style="background:#F1F1F1; box-shadow: 4px 4px 2px #888888; widht:700px" >
  <table width="800" border="0" style="padding-left:20px;">
 

    <!--1: La primer fila EL título del COUCH quién publicó el anuncio: -->
    <tr>
      <td colspan="4">
        <p> <span class="titulo"> <?php  echo utf8_encode($datos['titulo']);  ?>  </span></p>
        <p style="margin-left:20px"><b>Publicado por:</b> <?php  echo utf8_encode($datos['nombredeusuario']); ?></p> </p>
      </td>
    </tr>

    <tr>
      <td colspan="5"><hr /></td>
    </tr> 



  </table >

    <div style="margin: auto" class="container" width="500" height="300">
    <div style="margin: auto" class="row" width="500" height="300">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" width="500" height="300">
        <div id="carousel1" class="carousel slide" style="width:700px" height="300">
          <ol class="carousel-indicators" width="500" height="300">
            <?php
              for($i=0; $i<$cantFotos;$i++){
                if($i==0)
                  echo'<li data-target="#carousel1" data-slide-to="'.($i).'" class="active"> </li>';
                else
                  echo'<li data-target="#carousel1" data-slide-to="'.($i).'" class=""> </li>';
              }
          echo'</ol>

          <div class="carousel-inner">';
          $i=0;
          while($row=$fotos->fetch_array()){
            if($i==0){
              echo'<div class="item active" width="500" height="300"> <img class="img-responsive" width="700" height="300" src="images/couch/'.$row["link"].'" alt="thumb">
              </div>';
            }
            else{
              echo'<div class="item" width="500" height="300"> <img class="img-responsive" width="700" height="300" src="images/couch/'.$row["link"].'" alt="thumb">
              </div>';
            }
            $i++;
          }


            ?>
          </div>
          <a class="left carousel-control" href="#carousel1" data-slide="prev" height="500" heigh="300"><span class="icon-prev"></span></a> <a class="right carousel-control" href="#carousel1" data-slide="next"><span class="icon-next"></span></a></div>
      </div>
    </div>
    </div>


    
  <table>
    <tr>
      <td colspan="5" align="center"><hr /></td>
    </tr>
    <tr>
    <td height="48" ><b><p style="margin-left:20px">Dirección:</b></td>
    <td width="287">&nbsp;<?php  echo utf8_encode($datos['direccion']);  ?></p></td>
    <td width="208" align="center"><b><p style="margin-left:20px">Ciudad:</b> <?php  echo utf8_encode($datos['ciudad_nombre']);  ?></p> </td>
    <td colspan="2" align="center"><b><p style="margin-left:20px">Provincia:</b> <?php  echo utf8_encode($datos['provincia_nombre']);  ?></p> </td>
    </tr>
    <tr>
      <td height="32"><b><p style="margin-left:20px">Fecha Inicio:</b></td>
      <td colspan="4">&nbsp;<?php  echo date('d/m/y', strtotime(utf8_encode($datos['fechainicio']))); ?></td></p>
    </tr>
    <tr>
      <td height="38"><b><p style="margin-left:20px">Fecha Fin:</b></td>
      <td colspan="4">&nbsp;<?php  echo date('d/m/y', strtotime(utf8_encode($datos['fechafin']))); ?></td> </p>
    </tr>
    <tr>
      <td><b><p style="margin-left:20px">Descripción:</b></td>
      <td colspan="4">&nbsp;<?php  echo utf8_encode($datos['descripcion']);  ?></td> </p>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
    </div>
  
 
  
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