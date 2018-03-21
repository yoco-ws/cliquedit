<!DOCTYPE html>
<html>
	<head>
		<title>Iniciar sesión</title>

		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<meta http-equiv="x-ua-compatible" content="ie-edge">

    	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

   </head>

	
	<body>

		<div class="contenedor" id="portada">
			<div class="capa-opaca"></div>

			<div class="contenedor-formulario">
				<div class="fila">
					<form action="validate_login.php" method="POST" class="formulario">
						<div class="contenedor-inputs">
							<div class="elemento-formulario">
								<label for="username" class="texto-login ">Usuario</label>
								<input type="text" name="username"></input>
							</div>
							<div class="elemento-formulario">
								<label for="password" class="texto-login ">Contraseña</label>
								<input type="password" name="password"></input>
							</div>
						</div>
							
						<div class="elemento-formulario">
							<input type="submit" value="Iniciar Sesión"></input>
						</div>
					</form>
				</div>
				<div class="fila">
					<p class="texto-login">
						Clic-edita para <a class="texto-login" href="Heuristic Mérida 2018">#</a>
					</p>
				</div>
			</div>
			
		</div>
		
	</body>

</html>

<link rel="stylesheet" href="login.min.css">