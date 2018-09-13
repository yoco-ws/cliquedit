<?php 
	@session_start();
	unset($_SESSION['editmode']);

	$config = parse_ini_file("config.ini");

	header("Location: ".$config['home']);
	die();
?>