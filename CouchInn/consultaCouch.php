<!DOCTYPE html>
<head>
<link rel="stylesheet" href="css/bootstrap.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Couch</title>
<style type="text/css" media="screen">
  @import '../CouchInn/estilo/estiloConsultaCouch.css';> 
</style>
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/bootstrap.js"></script>
    <link rel="icon" href="images/logo.jpg">

<script type="text/javascript" >
  function solicitar(id){
    window.location.replace("solicitarCouch.php?id="+id);
  }

</script>

</head>

<body >

	<?php
    session_start();
    include("conexion.php");
    include("menu.php");
    if ($conn->connect_error) { 
      die("Connection failed: " . $conn->connect_error);
    } 
    $id_couch= isset($_GET['id'])?$_GET['id']: header('Location: index.php');
  
    //Consulta la BD:::
    $sql_couch = "select couchs.*, usuarios.*, ciudad.*, provincia.*, tipos_couch.* from couchs INNER JOIN usuarios ON usuarios.nombredeusuario=couchs.usuario INNER JOIN ciudad ON ciudad.id = couchs.ciudad INNER JOIN provincia ON provincia.id= ciudad.provincia_id INNER JOIN tipos_couch ON couchs.idtipo = tipos_couch.id where couchs.id=".$id_couch."";
    $sql = "select * from fotos where idcouch=".$id_couch."";
  
    $fotos=$conn->query($sql);
    $couch=$conn->query($sql_couch);

    $datos=$couch->fetch_array();
    $nombredeusuario=$datos["nombredeusuario"];
    $cantFotos= mysqli_num_rows($fotos);
    ?>
   <!-- ARMO UN DIV Y DENTRO UNA TABLA CON ALGUNAS CARACTERÍSTICAS -->
  <div class="recuadro_consulta_couch" style="background:#F1F1F1; box-shadow: 0 2px 4px 0; width:900px" >
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

    <div style="margin: auto; border:2px; width:600px" class="container"  height="300">
    <div style="margin: auto" class="row" width="500" height="300">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" width="500" height="300">
        <div id="carousel1" class="carousel slide" height="300">
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
    <td height="48" ><b><p style="margin-left:20px" align="right">Dirección:</b></td>
    <td height="48" width="287">&nbsp;<?php  echo utf8_encode($datos['direccion']);  ?></p></td>
    <td width="208" align="center"><b><p >Ciudad:</b> <?php  echo utf8_encode($datos['ciudad_nombre']);  ?></p> </td>
    <td colspan="2" align="center"><b><p >Provincia:</b> <?php  echo utf8_encode($datos['provincia_nombre']);  ?></p> </td>
    </tr>
    <tr>
      <td height="48"><b><p style="margin-left:20px" align="right">Fecha Inicio:</b></td>
      <td height="48">&nbsp;<input type="text" style="width:100px" readonly value= <?php  echo date('d/m/y', strtotime(utf8_encode($datos['fechainicio']))); ?> ></td></p>
      <td width="100" colspan="4"><b>Categoría:</b> <?php  echo utf8_encode($datos['tipo']);  ?> </td> </p>
    </tr>
    <tr>
      <td height="48"><b><p style="margin-left:20px; " align="right">Fecha Fin:</b></td>
      <td height="48">&nbsp;<input style="width:100px" type="text" readonly value=<?php  echo date('d/m/y', strtotime(utf8_encode($datos['fechafin']))); ?> ></td> 
    </tr>
    <tr>
      <td><b><p style="margin-left:20px; " align="right">Descripción:</b></td>
      <td colspan="4">&nbsp; <textarea readonly name="descripcion" id="descripcion" cols="35" rows="6" ><?php  echo utf8_encode($datos['2']);  ?> </textarea></td>
      <?php
        if(isset($_SESSION['logueado']) && $_SESSION['usuario']!=$nombredeusuario){
          echo'<td> <input type="button" value="Solicitar" onClick="solicitar('.$datos["0"].')">  </td>';
        }
      ?> 
      </p>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
    </div>
  
 
  
  <p>

  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <hr />
</div>
</body>
</html>