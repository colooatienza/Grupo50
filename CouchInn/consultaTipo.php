<!DOCTYPE HTML>
<html>
<head>
  
  	<meta charset="UTF-8">
  	<title>CouchInn</title>

<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  
  	<link rel="icon" href="images/logo.jpg">
	<script type="text/javascript">
	function confirmar(id) {
		if(confirm("Realmente desea eliminar?")){
			window.location.href = "borrarTipo.php?id="+id;
		}
	}
	</script>
</head>
<body>
	<?php
	session_start();
   	include("conexion.php");
  	include("menu.php");
	if($_SESSION["admin"]==true){
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql = "select * from tipos_couch";
	$result=$conn->query($sql);
	?>
	<h1 align="center">Categorías de Couch</h1>  <hr> </br> </br>
  
	<table width="700" align="center" bordercolor="#CCCCCC" border="1px solid" >
	   
        <tr>
			<td align="center"><b>Categoría</b></td>
			<td align="center"><b>Editar</b></td>
			<td align="center"><b>Borrar</b></td>
			<td align="center"><b>Despublicar/Publicar</b></td>
		</tr>
		<?php
			while($row=$result->fetch_array()){
				echo '<tr>';
				echo '<td align="center">'.utf8_encode($row["tipo"]). '</td>';
				echo '<td align="center"><a href="modificarTipo.php?id='
			.$row["id"].'"><img src="images/editar.png" width="20" height="20"></a> </td>';
				echo '<td align="center"><img class="btnEliminar" onmouseover="" style="cursor: pointer;"width="20" height="20" onClick="confirmar('.$row["id"].')" src="images/eliminar.png"></td>';    
				if($row["despublicado"]){
        			echo '<td align="center" style="background:#EEF"><a href="publicarTipo.php?id='.$row["id"].'" class="btn btn-default">Publicar</a></td>';
				}
				else{
        			echo '<td align="center"  style="background:#EEF"><a href="despublicarTipo.php?id='.$row["id"].'" class="btn btn-default">Despublicar</a></td>';
				}
				echo '</tr>';   
			}
				?>
	</table>
	    <br><br>
       <a href="agregarTipoCouch.php"><div style="border:1px solid; position:relative; left:45%; background:#eef; border-radius:5px; width:10%; text-align:center;">Nueva Categoría</div></a>
    <br>
<?php
}
else{
	header("Location: index.php");
}
?>
</body>
</html>
