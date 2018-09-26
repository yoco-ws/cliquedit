<?php
error_reporting(E_ERROR | E_PARSE);
@session_start();
//Verificar el tipo de elemento a agregar


$config = parse_ini_file("config.ini");
try{
	if(!isset($config['api_key'])) throw new Exception("No se definió la API Key en el config.ini");
	
	$api_key = $config['api_key'];
	$requesturl = "https://yoco.ws/clic-edita/src/server/login_handler.php?api_key=".$api_key."&domain=".removeSubdomainUrlAlternative($_SERVER['HTTP_HOST'])."&username=".$_POST['username']."&password=".$_POST['password'];

	$content = file_get_contents_curl($requesturl);

	$response = json_decode($content, true);
	//Login exitoso
	if(isset($response['valid_login'])){
		//Redireccionar a home
		$_SESSION['editmode'] = true;
		header("Location: ". $config['home']);
		die();
	}else{
		header("Location: .?error=1&msg=".$response['msg']);
		die();
	}
}catch(Exception $e){
	echo '<p>Error: ', $e->getMessage(), '</p>';
}

function removeSubdomainUrl($url) {
    //Fuente: https://stackoverflow.com/questions/2679618/get-domain-name-not-subdomain-in-php
    $url_new = parse_url($url);
    if(isset($url_new['path'])){
        if (strcmp($url_new['path'], 'localhost') == 0 ) {
            return $url_new['path'];
        }
    }

    if(isset($url_new['host'])){
        if (filter_var($url_new['host'], FILTER_VALIDATE_IP) || strcmp($url_new['host'], 'localhost') == 0 ) {
            return $url_new['host'].':'.$url_new['port'];
        }   
    }else{
        $array = explode(".", $url);
        return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
    
    }   
}

private function removeSubdomainUrlAlternative($url) {
        
    if (strpos($url, 'localhost') !== false) {
        return 'localhost';
    }else{
        return $url;
    }
}

function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //UNSAFE Solo para localhost
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //Solo localhost
    $data = curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($retcode == 200) {
        curl_close($ch);
    	return $data;
    }else{
        $data = json_decode($data, true);
        echo '<strong>Clic Edita Error: '.$data['msg'].curl_error($ch).'</strong>';
        curl_close($ch);
    	return null;
    }
}

?>