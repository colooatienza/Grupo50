

<nav  style=" background: #F5F5F5;"">
  <div class="container"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <p><a class="navbar-brand" href="index.php">Inicio</a>    </p>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">

        <?php
        if(isset($_SESSION['logueado']) && $_SESSION['logueado']==true){
        echo '<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">Couchs <span class="caret"></span></a>';
         echo' <ul class="dropdown-menu">
		     <li><a href="misCouchs.php">Ver mis Couchs</a> </li>
            <li><a href="agregarCouch.php">Agregar nuevo Couch</a> </li>
            <li><a href="solicitudes.php">Solicitudes de mis Couchs</a> </li>
            <li><a href="preguntas.php">Preguntas</a> </li>
            <li><a href="calificaciones.php">Calificar</a> </li>';
         echo '</ul>
        </li>';
        }
        ?>

        <li>
        <?php
        if(isset($_SESSION['admin']) && $_SESSION['admin']==true){				//Pone logout o registrarse
        	echo '<a href="consultaTipo.php" class="active">Categorías de Couchs</a>';
        }
        ?>
        </li>
        
      </ul>
      <form class="navbar-form navbar-right" role="search">

        <?php
        if(isset($_SESSION['logueado']) && $_SESSION['logueado']==true){				//Pone logout o registrarse
        	echo '<a href="logout.php" class="btn btn-default">Log Out</a>';
        }
        else{
	        echo '<a href="registrarUsuario1.php" class="btn btn-default">Registrarse</a>';
	        echo '<a href="login.php" class="btn btn-default" >Entrar</a>';
    	}
    	?>
      </form>
      <ul class="nav navbar-nav navbar-right hidden-sm">
        <?php
        if(isset($_SESSION['logueado']) && $_SESSION['logueado']==true){
        echo '<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">Perfil <span class="caret"></span></a>';
         echo' <ul class="dropdown-menu">
            <li><a href="modificarUsuario1.php">Modificar Datos Personales</a> </li>';
             if(isset($_SESSION['premium']) && $_SESSION['premium']==0){		
              echo'<li><a href="Premium.php">Mejorar a Premium</a> </li>';
        	}
         echo '</ul>
        </li>';
    	}
    	?>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>

