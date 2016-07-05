<html> 
<head> 

<style type="text/css" media="screen">
  @import '../CouchInn/estilo/graficaBarras.css';>
</style>

<script> 
function centrar() { 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
}

</script> 
 <?php
  include("verificarUsuario.php");

   
   if($_SESSION["admin"]==false)
      header("Location: index.php");
	  ?>
</head> 
<body bgcolor="#FFFFFF" text="#000000" onLoad="centrar()"> 
<div style="width: 100%; height: 50px; background: #8EE; font-family: Verdana; color: #F00; font-size: 14px;">
 <br>
  <table align="center"><tr><td class="ffg">Gr&aacute;fico de Barras Couchs Concretados: </td>
  

  </tr></table>
  <br> 

</div>
<?php
  $fechaI = isset($_GET['fechaI']) ? $_GET['fechaI']:''; 
  $fechaF = isset($_GET['fechaF']) ? $_GET['fechaF']:''; 
  echo '<br><br>';
echo '<img src="graficaCouchsBarras.php?fechaI='.$fechaI.'&fechaF='.$fechaF.'">';
echo '<br>&nbsp;&nbsp;&nbsp;desde: '.$fechaI.'  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo 'hasta: '.$fechaF.'  '; 
?>
<br><br><hr>
&nbsp;&nbsp;<span class="e">- Muestra la Cantidad Couchs que se concretaron ordenado por Categor&iacute;a -
</span>
</body> 
</html>  