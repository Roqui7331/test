<?php
	session_start();

	require_once 'includes/functions.php';
	require_once 'includes/db.php';

	if(isset($_SESSION['auth'])){
		header('Location: account.php');
		exit();
	}

	if(!empty($_POST)){
		$errors = array();

		if(empty($_POST['username'])){
			$errors['username'] = "Votre login n'est pas valide.";
		}

		if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
			$errors['password'] = "Votre mot de passe n'est pas valide.";
		}
		else{
			$req = $pdo->prepare('SELECT * FROM `users` WHERE `username` = :username');
			$req->execute(array(':username' => $_POST['username']));
			$user = $req->fetch();
			
			if($user){
				$errors['username'] = "Ce login est déjà utilisé.";
			}
		}

		if(empty($errors)){
			$req = $pdo->prepare('INSERT INTO `users` (`username`, `password`, `confirmation_token`) VALUES (:username, :password, :confirmation_token)');
			$password = sha1($_POST['password']);
			$token = str_random(60);
			$req->execute(array(':username' => $_POST['username'], ':password' => $password, ':confirmation_token' => $token));
			$user_id = $pdo->lastInsertId();
			$_SESSION['flash']['success'] = "Utilisez ce <a href=\"127.0.0.1:8080/Login/confirm.php?id=$user_id&token=$token\">lien</a> pour valider votre compte.";
			header('Location: login2.php');
			exit();
		}
	}
?>

<?php require 'includes/header.php'; ?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
	<div class="alert alert-danger">
		<p>Vous n'avez pas rempli le formulaire correctement:</p>
		<ul>
			<?php foreach($errors as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<form action="" method="POST">
	<div class="form-group">
		<label for="">Login: </label>
		<input type="text" class="form-control" name="username">
	</div>
	<div class="form-group">
		<label for="">Mot de passe: </label>
		<input type="password" class="form-control" name="password">
	</div>
	<div class="form-group">
		<label for="">Confirmer mot de passe: </label>
		<input type="password" class="form-control" name="password_confirm">
	</div>
	<button class="btn btn-primary">S'inscrire</button>
</form>

<?php require 'includes/footer.php'; ?>