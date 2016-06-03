<!DOCTYPE HTML>
<html>
<head>
  
  	<meta charset="UTF-8">
  	<title>CouchInn</title>

<script src="js/jquery-1.11.3.min.js"></script> 
	<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
  	<link rel="stylesheet" href="css/c.css">
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
	<h1 align="center">Categorías de Couch</h1> </br> </br>
	<a href="agregarTipoCouch.php" class='btnAgregar'>Nueva Categoría</a>
	<table class="tablaTipos">
		<tr>
			<th>Categoría</th>
			<th>Editar</th>
			<th>Borrar</th>
			<th>Despublicar/Publicar</th>
		</tr>
		<?php
			while($row=$result->fetch_array()){
				echo '<tr>';
				echo '<td>'.utf8_encode($row["tipo"]). '</td>';
				echo '<td align="center"><a href="modificarTipo.php?id='
			.$row["id"].'"><img src="images/editar.png" width="20" height="20"></a> </td>';
				echo '<td align="center"><img class="btnEliminar" onmouseover="" style="cursor: pointer;"width="20" height="20" onClick="confirmar('.$row["id"].')" src="images/eliminar.png"></td>';    
				if($row["despublicado"]){
        			echo '<td align="center"><a href="publicarTipo.php?id='.$row["id"].'" class="btn btn-default">Publicar</a></td>';
				}
				else{
        			echo '<td align="center"><a href="despublicarTipo.php?id='.$row["id"].'" class="btn btn-default">Despublicar</a></td>';
				}
				echo '</tr>';   
			}
				?>
	</table>
		
<?php
}
else{
	header("Location: index.php");
}
?>
</body>
</html>
