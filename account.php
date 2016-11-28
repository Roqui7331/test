<?php
	session_start();

	require_once 'includes/db.php';
	require_once 'includes/functions.php';

	is_logged();

	if(!empty($_POST)){
		if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
			$_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas.";
		}
		else{
			$user_id = $_SESSION['auth']->id;
			$password = sha1($_POST['password']);
			$req = $pdo->prepare('UPDATE `users` SET `password` = :password WHERE `id` = :id');
			$req->execute(array(':password' => $password, ':id' => $user_id));
			$_SESSION['flash']['success'] = "Votre mot de passe a été mis à jour.";
		}
	}
?>

<?php require 'includes/header.php'; ?>

<h1>Bonjour <?php echo $_SESSION['auth']->username; ?></h1>

<form action="" method="POST">
	<div class="form-group">
		<input class="form-control" type="password" name="password" placeholder="Modifier votre mot de passe">
	</div>
	<div class="form-group">
		<input class="form-control" type="password" name="password_confirm" placeholder="Confirmer votre nouveau mot de passe">
	</div>
	<button class="btn btn-primary">Changer mot de passe</button>
</form>

<?php require 'includes/footer.php'; ?>