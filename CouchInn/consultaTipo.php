<!DOCTYPE HTML>
<html>
<head>
  
  	<meta charset="UTF-8">
  	<title>CouchInn</title>

  	<link rel="stylesheet" href="css/c.css">
  	<link rel="icon" href="Imagenes/icono.ico">
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
	include("verificarUsuario.php");
   	include("conexion.php");
	if($_SESSION["admin"]==1){
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql = "select * from tipos_couch";
	$result=$conn->query($sql);
	?>
	<h1 align="center">Listado de Categorías de Couch</h1>
	<a href="agregarTipoCouch.html" class='btnAgregar'>Nueva Categoría</a>
	<table class="tablaTipos">
		<tr>
			<th>Nº</th>
			<th>Categoría</th>
			<th>Editar</th>
			<th>Borrar</th>
		</tr>
		<?php
			while($row=$result->fetch_array()){
				echo '<tr>';
				echo '<td>'.$row["id"].' </td> ';
				echo '<td>'.$row["tipo"]. '</td>';
				echo '<td align="center"><a href="modificarTipo.php?id='
			.$row["id"].'"><img src="images/editar.png" width="20" height="20"></a> </td>';
				echo '<td align="center"><img class="btnEliminar" onmouseover="" style="cursor: pointer;"width="20" height="20" onClick="confirmar('.$row["id"].')" src="images/eliminar.png"></td>';    
				echo '</tr>';   
			}
				?>
	</table>
		
		
   
 
 
<footer class="footer">
  <p>Atienza Tomas - Ruiz Matias
</p>
</footer>
<?php
}
else{
	header("Location: index.html");
}
?>
</body>
</html>
