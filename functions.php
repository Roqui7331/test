<?php

	function debug($variable){
		echo '<pre>' . var_dump($variable) . '</pre>';
	}

	function str_random($length){
		$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";

		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}

	function is_logged(){
		if(session_id() == ''){
			session_start();
		}
		if(!isset($_SESSION['auth'])){
			$_SESSION['flash']['danger'] = "Vous dever vous connecter pour accéder à cette page.";
			header('Location: login2.php');
			exit();
		}
	}