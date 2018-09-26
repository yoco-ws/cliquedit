<?php
namespace CE;
/*La clase Page representa una pagina del sitio web, identificada por un id numerico.
La pagina solicita todos los elementos a mostrar, en base al arreglo especificado en el metodo load
*/

class page{
	//Imprime las estructuras de los elementos de clic edita

	public function start(){
		echo 'data-ce-page="'.self::$id.'"';
	}

	/*
	Realiza la consulta directa a la BD a partir de un webservice CURL.
	Parametros requeridos:
	page - El numero de la pagina actual
	category - Una cadena con las categorias a obtener, asi como el numero de articulos por cada una y 
	el alias de del parametro GET para la paginacion.
	
	*/
	public function load($pageSpec){
		
		//Verificar el tipo de elemento a agregar
		if(!isset($pageSpec['page'])) $pageSpec['page'] = 1;
		
		self::$id = $pageSpec['page'];
		$parsedUrl = \CE\page::removeSubdomainUrlAlternative($_SERVER['HTTP_HOST']);
		$requesturl = "https://yoco.ws/clic-edita/src/server/recovery_handler.php?api_key=".\CE\session::getKey()."&domain=".$parsedUrl;
		if(isset($pageSpec['page'])) $requesturl.= "&page=".$pageSpec['page'];
		if(isset($pageSpec['collections'])){
			$parsedCategory = self::$instance->parseCategoryString($pageSpec['collections']);
			$requesturl.= "&category=".$parsedCategory;	
		} 
		if(isset($pageSpec['num_articles'])) $requesturl.= "&num_articles=".$pageSpec['num_articles'];
		if(isset($pageSpec['itemId'])){
			$articleId = 1;
			if(isset($_GET[$pageSpec['itemId']])) $articleId = $_GET[$pageSpec['itemId']];
			$requesturl.= "&single_article=".$articleId;
		} 

		$content = \CE\page::file_get_contents_curl($requesturl);
		if($content !== false){
			//file_put_contents('elementos_obtenidos.txt', var_export($content, true));
			\CE\Loader::setElements(json_decode($content, true));
		}else{
			\CE\Loader::setElements(null); //Se desconocen los elementos
		}
	}

	public function metas(){
		
		try{
			if(!isset(self::$id))
				throw new \Exception("No se ha definido la pagina.");

			$pageNumber = self::$id;
			$pageMetas = \CE\Loader::getPageMetas($pageNumber);

			if(isset($pageMetas)){
				if (isset($pageMetas['sharing_keywords'])) echo '<meta name="keywords" content="'.strip_tags($pageMetas['sharing_keywords']).'"/>';
				if (isset($pageMetas['sharing_titulo'])) echo '<meta property="og:title" content="'.strip_tags($pageMetas['sharing_titulo']).'"/>';
				if (isset($pageMetas['sharing_descripcion'])) echo '<meta property="og:description" content="'.strip_tags($pageMetas['sharing_descripcion']).'"/>';
				if (isset($pageMetas['sharing_imagen'])) echo '<meta property="og:image" content="'.$pageMetas['sharing_imagen'].'"/>';
			}
				
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}

		
		
	}

	public function title($placeholder=false){
		
		try{
			if(!isset(self::$id))
				throw new \Exception("No se ha definido la pagina.");
			
			$pageNumber = self::$id;
			$pageTitle = \CE\Loader::getPageTitle($pageNumber);

			if(isset($pageTitle)){
				echo '<title>'.strip_tags($pageTitle).'</title>';
				
			}else{
				if($placeholder != false){
					echo '<title>'.strip_tags($placeholder).'</title>';
				}
			}
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}

		
	}

	private function file_get_contents_curl($url) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //UNSAFE Solo para localhost
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //Solo localhost
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


	private function removeSubdomainUrl($url) {
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


	private function parseCategoryString($categoryString){
		//Verificar si en la string se tiene declarado el alias de la pagina
		$pageAlias = self::$instance->parsePre(self::$instance->parseAfter($categoryString));
		if (strcmp($pageAlias, '') != 0){
			//Verificar si el alias existe y está definido en el GET
			$pageNumber = 1;
			if(isset($_GET[$pageAlias])){
				$pageNumber = $_GET[$pageAlias];
			}
			$formattedString = str_replace("%".$pageAlias."%", $pageNumber, $categoryString);
			return $formattedString;
		}else{
			return $categoryString;	
		} 
		
	}

	private function parsePre($categoryString){
		return substr($categoryString, 0, strpos($categoryString, '%'));
	}

	private function parseafter($categoryString){
		if (!is_bool(strpos($categoryString, '%')))
        return substr($categoryString, strpos($categoryString,'%')+strlen('%'));
	}

	//Instancia de Singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new page();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;

}

?>