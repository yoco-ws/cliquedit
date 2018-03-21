<?php
namespace CE;

class page{
	//Imprime las estructuras de los elementos de clic edita

	public static function id(){
		echo 'data-ce-page="'.\CE\page::$id.'"';
	}

	public static function render($pageSpec){
		
		//Verificar el tipo de elemento a agregar
		\CE\page::$id = $pageSpec['page'];
		$parsedUrl = \CE\page::removeSubdomainUrl($_SERVER['HTTP_HOST']);
		$requesturl = "https://yoco.ws/clic-edita/src/server/recovery_handler.php?api_key=".\CE\Session::getKey()."&domain=".$parsedUrl;
		if(isset($pageSpec['page'])) $requesturl.= "&page=".$pageSpec['page'];
		if(isset($pageSpec['category'])) $requesturl.= "&category=".$pageSpec['category'];
		if(isset($pageSpec['num_articles'])) $requesturl.= "&num_articles=".$pageSpec['num_articles'];
		
		if(isset($pageSpec['single_article'])) $requesturl.= "&single_article=".$pageSpec['single_article'];

		$content = \CE\page::file_get_contents_curl($requesturl);
		if($content !== false){
			\CE\Loader::setElements(json_decode($content, true));
			//var_dump(\CE\Loader::$elements);
		}else{
			\CE\Loader::setElements(null); //Se desconocen los elementos
		}
	}

	private static function file_get_contents_curl($url) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    $data = curl_exec($ch);
	    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);
	    if ($retcode == 200) {
	        return $data;
	    } else {
	        return null;
	    }
	}


	private static function removeSubdomainUrl($url) {
	    //Fuente: https://stackoverflow.com/questions/2679618/get-domain-name-not-subdomain-in-php
		$url_new = parse_url($url);
		if (filter_var($url_new['host'], FILTER_VALIDATE_IP) || strcmp($url_new['host'], 'localhost') == 0) {
		   	return $url_new['host'].':'.$url_new['port'];
		}else {
		    $array = explode(".", $url);
			return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
		}
	}

	private static $id;

}

?>