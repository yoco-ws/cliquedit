<?php
error_reporting(E_ERROR | E_PARSE);
@session_start();
//Verificar el tipo de elemento a agregar

$api_key = '53841023';
$requesturl = "https://yoco.ws/clic-edita/src/server/login_handler.php?api_key=".$api_key."&domain=".$_SERVER['HTTP_HOST']."&username=".$_POST['username']."&password=".$_POST['password'];

$content = file_get_contents($requesturl);

$response = json_decode($content, true);
echo $response['msg'];
//Login exitoso
if(isset($response['valid_login'])){
	$_SESSION['editmode'] = true;
	header("Location: ..");
	die();
}else{
	header("Location: .");
	die();
}
?>