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
</head> 
<body bgcolor="#FFFFFF" text="#000000" onLoad="centrar()"> 
<div style="width: 100%; height: 50px; background: #8EE; font-family: Verdana; color: #F00; font-size: 14px;">
 <br>
  <table align="center"><tr><td class="ffg">Gr&aacute;fico de Barras Usuarios: </td>
  
  <td><a href="ventanaUsuariosMes.php"><span class="bot">&Uacute;ltimos doce meses</span></a></td>
 
  <td><span class="bot > selec">&Uacute;ltimos 5 a&ntilde;os</span></td>
  
  <td><a href="ventanaUsuariosSem.php"><span class="bot">&Uacute;ltimas semanas</span></a></td>
  </tr></table>
  <br>
</div>
<img src="graficaUsuariosAnoBarras.php">
<br><br><br><hr>
&nbsp;&nbsp;<span class="e">- Muestra la Cantidad Usuarios que se registraron los &uacute;ltimos cinco a&ntilde;os -
</span>


</body> 
</html>  