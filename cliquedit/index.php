<?php session_start(); ?>
<?php $config = parse_ini_file('config.ini'); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Iniciar Sesión</title>

    <!-- Custom styles for this template -->
    <link href="css/login.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

  <body>

  	<nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0">
	  	<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><img class="col-12" src="http://cliqued.it/img/cliqued.png" /></a></a>
	</nav>
    
    <div class="container login-form">
      <div class="row mt-5 justify-content-center">
        
        <?php if(!isset($_SESSION['editmode'])): ?>
			
			<div class="col-12 col-md-6">
				<h1 class="text-center title">Login</h1>

				<form action="validate_login.php" method="POST">
					<div class="form-group">
						<label for="nombre">User:</label>
						<input type="nombre" class="form-control" id="nombre" name="username"></input>
					</div>

					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password" name="password"></input>
					</div>

					<div class="form-group d-flex justify-content-center contenedor-boton">
						<button type="submit" class="btn btn-primary">OK</button>
					</div>

					<?php if(isset($_GET['error'])): ?>
						<div class="fila">
							<p class="texto-login text-center">
								Ocurrió un problema al acceder a Clic Edita: <?php echo $_GET['msg'] ?>
							</p>
						</div>
					<?php endif; ?>
				</form>
				
				<p class="text-center espaciado">
	        		<b>cliqued.it</b> para <?php echo $config['organization'] ?>
	      		</p>
	        	<p class="text-center">
	        		Need help? <a href="mailto:support@cliqued.it"> support@cliqued.it </a>
	      		</p>
	  		</div>

        <?php else: ?>
			
			<div class="col-12 col-md-6">
				
				<p class="text-center">
	        		Ya tienes una sesión de cliqued.it abierta, ¿deseas cerrar tu sesión?
	      		</p>

	      		<div class="d-flex justify-content-center mt-5">
	      			
	      			<a class="btn btn-primary col-md-8" href="logout.php">
		      			Sí, cerrar sesión
		      		</a>

	      		</div>
      			
				<div class="d-flex justify-content-center mt-4">
					<a class="btn btn-primary col-md-8" href="<?php echo $config['home'] ?>">
		      			No, seguir editando
		      		</a>
				</div>
	      		
	      		

	      		

	      		<p class="text-center mt-5">
	        		<b>cliqued.it</b> para <?php echo $config['organization'] ?>
	      		</p>
	      		<p class="text-center">
	        		Need help? <a href="mailto:support@cliqued.it"> support@cliqued.it </a>
	      		</p>


			
			</div>

        <?php endif; ?>
        
        
      </div>
    </div>

  </body>
</html>
