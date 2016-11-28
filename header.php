<?php
	if(session_id() == ''){
		session_start();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/app.css">
</head>
<body style="padding-top: 70px">
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Espace Membre</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<?php if(isset($_SESSION['auth'])): ?>
						<li><a href="logout.php">Se déconnecter</a></li>
						<li><a href="../romain/crud">Surveillances</a></li>
					<?php else: ?>
						<li class="active"><a href="register.php">S'inscrire</a></li>
						<li><a href="login2.php">Se connecter</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="starter-template">
			<?php if(isset($_SESSION['flash'])): ?>
				<?php foreach($_SESSION['flash'] as $type => $message): ?>
					<div class="alert alert-<?php echo $type; ?>">
						<?php echo $message; ?>
					</div>
				<?php endforeach; ?>
				<?php unset($_SESSION['flash']); ?>
			<?php endif; ?>