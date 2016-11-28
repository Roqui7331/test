<?php
	session_start();

	require_once 'includes/db.php';
	require_once 'includes/functions.php';

	if(isset($_SESSION['auth'])){
		header('Location: account.php');
		exit();
	}

	if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
		$req = $pdo->prepare('SELECT * FROM `users` WHERE `username` = :username');
		$req->execute(array(':username' => $_POST['username']));
		$user = $req->fetch();
		
		if($user && $user->active){
			if($user && sha1($_POST['password']) == $user->password){
				$_SESSION['auth'] = $user;
				$_SESSION['flash']['success'] = "Vous êtes connecté.";
				header('Location: account.php');
				exit();
			}
			else{
				$_SESSION['flash']['danger'] = "Identifiants incorrects.";
			}		
		}
		else{
			$_SESSION['flash']['danger'] = "Votre compte n'est pas activé.";
			header('Location: login2.php');
			exit();
		}
		
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_POST['username']) || empty($_POST['password']))){
		$_SESSION['flash']['danger'] = "Identifiants incorrects";
	}
?>

<?php require 'includes/header.php'; ?>

<h1>Se connecter</h1>

<form action="" method="POST">
	<div class="form-group">
		<label for="">Login: </label>
		<input type="text" class="form-control" name="username">
	</div>
	<div class="form-group">
		<label for="">Mot de passe: </label>
		<input type="password" class="form-control" name="password">
	</div>
	<button class="btn btn-primary">Se connecter</button>
</form>

<?php require 'includes/footer.php'; ?>