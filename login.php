<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>login</title>
		<meta name="description" content="">
		<meta name="author" content="Manuel Rosario">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="favicon.png">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/st-login.css" rel="stylesheet">
	</head>

	<body>
		<div class="container" align="center">
	
	      <form id="signinForm" class="form-signin" role="form" method="post" action="functions/login.php">
	      	<div class="logo">
	      	</div>
	        <h2 class="form-signin-heading">Ingrese por favor</h2>
	        <input type="text" class="form-control" placeholder="Usuario" required="true" autofocus="" name="username">
	        <input type="password" class="form-control" placeholder="Contraseña" required="true" name="password">
	        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
	      </form>
	
	    </div>
	  	<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
	</body>
</html>
