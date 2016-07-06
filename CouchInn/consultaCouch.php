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
	if((document.getElementById('texto').value).length<=5)		
	  document.getElementById('boton').disabled; 
	else {
      document.getElementById('boton').enabled;
	  document.pregg.submit();
		 }

}
function solicitar(id){
  window.location= 'solicitarCouch.php?id='+id;
}


</script>
<style>
  .contPregunta{
	 
	  width:500px;
	 
	  background:#FFF;
	  border:1px solid;
	  border-color:#AAA;
	  padding:10px;
	  }
  
</style>

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
    $sql_couch = "select couchs.*, usuarios.*, ciudad.*, provincia.*, tipos_couch.* from couchs INNER JOIN usuarios ON usuarios.nombredeusuario=couchs.usuario INNER JOIN ciudad ON ciudad.id = couchs.ciudad INNER JOIN provincia ON provincia.id= ciudad.provincia_id INNER JOIN tipos_couch ON couchs.idtipo = tipos_couch.id where couchs.id='".$id_couch."' and couchs.disponible=1";
    $sql = "select * from fotos where idcouch='".$id_couch."'";
    
	
    $fotos=$conn->query($sql);
    $couch=$conn->query($sql_couch);
	if($couch->num_rows == 0){
		header("Location: index.php");}

    $datos=$couch->fetch_array();
	$esteCouch= $datos['nombredeusuario'];
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
				
              echo'<div class="item active">'; ?>
			   <img src="images/couch/<?php echo $row["link"];?>?<?php echo time();?>"  class="img-responsive"  alt="thumb" style="min-height:300px;" >
			 
            <?php  echo '</div>';
            }
            else{
              echo'<div class="item">'; ?>
              <img src="images/couch/<?php echo $row["link"];?>?<?php echo time();?>"  class="img-responsive"  alt="thumb" style="min-height:300px;" >
			
             <?php echo '</div>';
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
    
  <table style="width:100%;">
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
      <td height="48">&nbsp;<input type="text" style="width:100px" readonly value= <?php  echo date('d/m/y', strtotime(utf8_encode($datos['fechainicio']))); ?> ></p></td>
       
      
      <td colspan="2" align="center"><b>Categoría:</b> <?php  echo utf8_encode($datos['tipo']);  ?> </td><td>
       <b>Capacidad máxima: </b><?php echo utf8_encode($datos['cantidad']); ?> 
      
      </td></p>
    </tr>
    <tr>
      <td height="48"><b><p style="margin-left:20px; " align="right">Fecha Fin:</b></td>
      <td height="48">&nbsp;<input style="width:100px" type="text" readonly value=<?php  
	  if($datos['fechafin']=='0000-00-00')
	  echo 'Inf.';
	  else
	  echo date('d/m/y', strtotime(utf8_encode($datos['fechafin']))); 
	  ?> ></td> 
    
    </tr>
    <tr>
      <td><b><p style="margin-left:20px; " align="right">Descripción:</b></td>
      <td colspan="3">&nbsp;<textarea readonly name="descripcion" id="descripcion" cols="35" rows="6"  style="resize:none;"><?php  echo utf8_encode($datos['2']);  ?> </textarea></td> </p>
      <?php
        $nombredeusuario=$datos["nombredeusuario"];
        if(isset($_SESSION['logueado']) && $_SESSION['usuario']!=$nombredeusuario){
          echo'<td align="center"> <input type="button" class="botonLlamativo" value="Solicitar" onClick="solicitar('.$datos["0"].')">  </td>';
        }
		$elUsuario=(isset($_SESSION['usuario']))?$_SESSION['usuario']:'';
	  ?> 
    </tr></table>
   
    <br><br><br><br><br>
   <table style="width:100%;"> 
     
     
      <tr><td><hr style="width:95%; border-color:#22A; "></td></tr>
      <tr>
        <td style="position:relative; left:130px; font-size:20px; color:#338;"><img src="images/pregs.jpg" width="45" height="30" alt="df"> 
        
		<?php if($elUsuario != $esteCouch)
               echo 'Haz una pregunta al dueño:';
			   else  echo 'Preguntas para mi:';  ?>
      
        </td></tr>
      <tr><td><hr style="width:95%; border-color:#22A;"><br></td></tr>
     <tr><td style="position:relative; left:130px;">
       
    
    
   
   
      
       <?php 
	   
	    if($elUsuario!=$esteCouch){
     if(isset($_SESSION['usuario'])){
		 ?>
         
	 <form method="post" action="preguntar.php"  name="pregg" id="pregg"  ENCTYPE="multipart/form-data" >
          <input type="hidden" name="couch" id="couch" value="<?php echo $id_couch; ?>"  >
          <textarea name="texto" id="texto" cols="59" rows="3"  style="resize:none;"></textarea><br>
          <span style="position:relative; top:0px;">
          <input type="button" name="boton" id="boton" onClick="validarPregunta()" value="Preguntar" >
          </span>
          <form>
         <?php
		 }else{
		?>
           Debes <a href="login.php">Iniciar Sesión</a> para preguntar:<br>
		   <textarea name="pregunta" disabled id="pregunta" cols="59" rows="3"  style="resize:none;"></textarea>  <br><br>
         <?php  } }
		  
		  ?>
          
           
         
           <?php   
		   if ($elUsuario!=$esteCouch){ 
           echo '</tr><tr><td style="position:relative; left:130px;">';
           
           echo '<hr style="position:absolute; width:500px; border-color:#66A;"></td></tr><tr><td><tr><td style="position:relative; left:130px;">';
      echo '<br><br><b><span style="color:#338">';
      echo 'Anteriores:';

		   }
	   ?>  </span></b><br>
      
      
      
      
        
		
		<!-- Preg ANTERIORES  -->
		<?php
		$preguntas=$conn->query("select * from comentarios inner join usuarios on usuarios.nombredeusuario=comentarios.usuario where idcouch=".$id_couch." and idcomentario IS NULL order by id desc ");
         while($fila=$preguntas->fetch_array()){
			 echo '<div class="contPregunta">';
			 echo '<span style="font-size:13px;"><img src="images/usuario/'.($fila['foto']).'" width=60px; " onerror="this.src=\'images/sin_imagen.png\'">&nbsp;&nbsp;'.($fila['usuario']).'</span><br>';
			 echo '<br>'.utf8_encode($fila['texto']).'';
			 
			 $respuesta=$conn->query("select * from comentarios where idcouch=".$id_couch." and idcomentario =".$fila[0]." ");
			
			 if($filaRTA=$respuesta->fetch_array()){
			 echo '<hr style="border-color:#555;">';
			 echo '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Respuesta:</b><br>';
			 echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.utf8_encode($filaRTA['texto']).'';}
			 
			 echo '<br><br></div><br><br>';
			 }
			
		      		
		?>
      
      <br>
      
       </tr><tr><td><hr style="width:95%; border-color:#22A; "><br></td></tr>
      

      </table>
     <BR><BR>
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