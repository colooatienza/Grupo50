<?php
  session_start();
    if( $_POST){
     	#Comprueba que las variables existan
    	if ( isset( $_POST['usuario'] ) and isset( $_POST['clave'] ) ){
            # archivo php necesario
   	    	require_once 'usuario.class.php';
            # instancia a clase usuario
            $usuario = new usuario();
       	    if( $usuario->validar_ingreso($_POST['usuario'] , $_POST['clave']) ){
                //crea instancia de sesion segura
                $_SESSION["usuario"]=$_POST['usuario'];
                $_SESSION["logueado"]=true;
				        $_SESSION["admin"]=$usuario->admin($_SESSION["usuario"]);
                $_SESSION["premium"]=$usuario->esPremium($_SESSION["usuario"]);
				header("Location: index.php");
       	    }else
              header("Location: login.php");    
   	}
  }        
?>
