<?php 
	@session_start();
	unset($_SESSION['editmode']);
	header("Location: .");
	die();
?>