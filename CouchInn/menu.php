

<nav>
  <div class="container"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <p><a class="navbar-brand" href="index.php">Inicio</a>    </p>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a> </li>
        <li>
        <?php
        if(isset($_SESSION['admin']) && $_SESSION['admin']==true){				//Pone logout o registrarse
        	echo '<a href="consultaTipo.php" class="active">Categorías de Couchs</a>';
        }
        ?>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a> </li>
            <li><a href="#">Another action</a> </li>
            <li><a href="#">Something else here</a> </li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a> </li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a> </li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-right" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
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
        <li><a href="#">Link</a> </li>
        <?php
        if(isset($_SESSION['logueado']) && $_SESSION['logueado']==true){
        echo '<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">Perfil <span class="caret"></span></a>';
         echo' <ul class="dropdown-menu">
            <li><a href="modificarUsuario1.php">Modificar Datos Personales</a> </li>';
             if(isset($_SESSION['admin']) && $_SESSION['admin']==true){		
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

