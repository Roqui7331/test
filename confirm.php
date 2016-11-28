<?php

	var_dump(is_null($_GET['id']));
	die();

	if(!isset($_GET['id']) || !isset($_GET['token'])){
		header('Location: login2.php');
		exit();
	}

	session_start();
		
	require_once 'includes/db.php';
	require_once 'includes/functions.php';

	$user_id = $_GET['id'];
	$token = $_GET['token'];

	$req = $pdo->prepare('SELECT * FROM `users` WHERE id = :id');
	$req->execute(array(':id' => $user_id));
	$user = $req->fetch();
	
	if($user && $user->confirmation_token == $token){
		// mettre le token dans la db à NULL
		$req = $pdo->prepare('UPDATE `users` SET `confirmation_token` = :confirmation_token, `active` = :active WHERE `id` = :id');
		$req->execute(array('confirmation_token' => NULL, ':active' => true, ':id' => $user_id));
		$_SESSION['flash']['success'] = "Votre compte a bien été validé.";
		$_SESSION['auth'] = $user;
		header('Location: account.php');
	}
	else{
		$_SESSION['flash']['danger'] = "Ce token n'est plus valide.";
		header('Location: login2.php');
	}