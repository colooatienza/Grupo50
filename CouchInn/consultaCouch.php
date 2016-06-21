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

<script>

function validarPregunta(){
	if((document.getElementById('pregunta').value).length<=3){
	  document.getElementById('boton').disabled;
	  return false;
	 }
	else{ 
		 document.getElementById('boton').enabled;
		 }
		return true;
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
    $sql_couch = "select couchs.*, usuarios.*, ciudad.*, provincia.*, tipos_couch.* from couchs INNER JOIN usuarios ON usuarios.nombredeusuario=couchs.usuario INNER JOIN ciudad ON ciudad.id = couchs.ciudad INNER JOIN provincia ON provincia.id= ciudad.provincia_id INNER JOIN tipos_couch ON couchs.idtipo = tipos_couch.id where couchs.id='".$id_couch."'";
    $sql = "select * from fotos where idcouch='".$id_couch."'";
  
    $fotos=$conn->query($sql);
    $couch=$conn->query($sql_couch);

    $datos=$couch->fetch_array();
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
   <span style="height:100px;">
    <div style="margin: auto; position:relative; height:450px; border:2px; width:600px" class="container"  height="300">
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
				
              echo'<div class="item active"> <img class="img-responsive"  src="images/couch/'.$row["link"].'" alt="thumb">
              </div>';
            }
            else{
              echo'<div class="item"> <img class="img-responsive" src="images/couch/'.$row["link"].'" alt="thumb">
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

 </span>
    
  <table >
    <tr>
      <td colspan="5" align="center"><hr /></td>
    </tr>
    <tr>
    <td height="48" ><b><p style="margin-left:20px" align="right">Dirección:</b></td>
    <td height="48" width="287">&nbsp;<?php  echo utf8_encode($datos['direccion']);  ?></p></td>
    <td width="208" align="center"><b><p >Ciudad:</p></b> <?php  echo utf8_encode($datos['ciudad_nombre']);  ?> </td>
    <td colspan="2" align="center"><b><p >Provincia:</p></b> <?php  echo utf8_encode($datos['provincia_nombre']);  ?> </td>
    </tr>
    <tr>
      <td height="48"><b><p style="margin-left:20px" align="right">Fecha Inicio:</b></td>
      <td height="48">&nbsp;<input type="text" style="width:100px" readonly value= <?php  echo date('d/m/y', strtotime(utf8_encode($datos['fechainicio']))); ?> ></td></p>
      <td align="center"><b>Categoría:</b> <?php  echo utf8_encode($datos['tipo']);  ?> </td><td></td> </p>
    </tr>
    <tr>
      <td height="48"><b><p style="margin-left:20px; " align="right">Fecha Fin:</b></td>
      <td height="48">&nbsp;<input style="width:100px" type="text" readonly value=<?php  echo date('d/m/y', strtotime(utf8_encode($datos['fechafin']))); ?> ></td> 
    </tr>
    <tr>
      <td><b><p style="margin-left:20px; " align="right">Descripción:</b></td>
      <td colspan="4">&nbsp; <textarea readonly name="descripcion" id="descripcion" cols="35" rows="6"  style="resize:none;"><?php  echo utf8_encode($datos['2']);  ?> </textarea></td> </p>
      <?php
        $nombredeusuario=$datos["nombredeusuario"];
        if(isset($_SESSION['logueado']) && $_SESSION['usuario']!=$nombredeusuario){
          echo'<td> <input type="button" value="Solicitar" onClick="solicitar('.$datos["0"].')">  </td>';
        }
      ?> 
    </tr>
  <tr>
    <td colspan="5"><br><br><span style="negro"><hr style="border-color:#888; border:1px solid;"><br><br></td></tr>

    
     <tr><td></td><td colspan="4">
        <?php
     if(isset($_SESSION['usuario'])){
		 ?>
          &nbsp;&nbsp;<br>
		 <form method="post" onSubmit=" return validarPregunta()" action="preguntar.php"  name="pregg" id="pregg"  ENCTYPE="multipart/form-data" >
          <textarea name="texto" id="texto" cols="40" rows="3"  style="resize:none;"></textarea>
          <input type="hidden" name="couch" id="couch" value="<?php echo $id_couch; ?>"  >
          <input type="submit" name="boton" id="boton" value="preguntar" onClick="validarPregunta()">
          <form>
         <?php
		 }else{
		?>
           &nbsp;&nbsp;Debes Iniciar Sesión para preguntar:<br>
		   <textarea name="pregunta" disabled id="pregunta" cols="40" rows="3"  style="resize:none;"></textarea>
         <?php  }  ?>
           <br><br><hr style="border-color:#999;">
      <br><br>
      <b>&nbsp;&nbsp;Preguntas anteriores:</b>      
      <br><br>
        
		
		<!-- Preg ANTERIORES  -->
		<?php
		$preguntas=$conn->query("select * from comentarios where idcouch=".$id_couch." and idcomentario IS NULL ");
         while($fila=$preguntas->fetch_array()){
			 echo '<b>'.($fila['usuario']).' </b>:<br>';
			 echo '<textarea readonly cols="40" rows="2"  style="resize:none;">'.utf8_encode($fila['texto']).'</textarea><br>';
			 
			 $respuesta=$conn->query("select * from comentarios where idcouch=".$id_couch." and idcomentario =".$fila[0]." ");
			 if($filaRTA=$respuesta->fetch_array())
			 echo '<b>respuesta:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea readonly  cols="40" rows="2"  style="resize:none;">'.utf8_encode($filaRTA['texto']).'</textarea>';
			 
			 
			 }
		      		
		?>
      
      <br> <br><hr style="border-color:#666;"><br><br>
       </td></tr>
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