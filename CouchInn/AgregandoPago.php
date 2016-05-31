<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="Css/c.css">
<script type="text/javascript" >
	function redireccionar(){
		setTimeout(redirect, 5000);
	}
	function redirect(){
		document.getElementById("form").submit()
	}
</script>
<title>CouchInn</title>
</head>
	
	<?php
	include("verificarUsuario.php");
	?>
<div class="divTipo">
    <form onSubmit="return valida()" method="post" id="form" action="PagoAgregado.php" >
		<input type="hidden" id="tarjeta" name="tarjeta" value= "<?php echo $_POST['tarjeta']?>" >
         <input type="hidden" id="monto" name="monto" value= "<?php echo substr($_POST['monto'],1)?>" >
    
	<p> Aguarde un momento a que se complete la verificacion de su tarjeta </p>
	<img src="images/loading.gif" alt="Esperando" height="100" width="100" margin="auto">
	</form>
</div>
<?php echo "<script type='text/javascript'> redireccionar(); </script> "?>
<body>
</body>
</html>