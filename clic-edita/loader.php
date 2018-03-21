<?php
namespace CE;

class Loader{
	//Genera el arreglo con todos los elementos editables sacados desde la BD

	public static function setElements($elements){
		\CE\Loader::$elements = $elements;
	}

	public static function getText($textId, $article=false){
		
		if(!$article){
			if(isset(\CE\Loader::$elements['texto'][$textId])){
				return \CE\Loader::$elements['texto'][$textId];
			}else{
				return null;
			}
		}else{
			$articleId= $article[1];
			$categoryId= $article[0];

			if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['texto'][$textId])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['texto'][$textId];
			}else{
				return null;
			}
		}

		
	}

	public static function getImage($imageId, $article=false){
		if(!$article){
			if(isset(\CE\Loader::$elements['imagen'][$imageId])){
				return \CE\Loader::$elements['imagen'][$imageId];
			}else{
				return null;
			}
		}else{
			$articleId= $article[1];
			$categoryId= $article[0];

			if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['imagen'][$imageId])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['imagen'][$imageId];
			}else{
				return null;
			}
		}
		
	}

	public static function getAudio($audioId, $article=false){
		if(!$article){
			if(isset(\CE\Loader::$elements['audio'][$audioId])){
				return \CE\Loader::$elements['audio'][$audioId];
			}else{
				return null;
			}
		}else{
			$articleId= $article[1];
			$categoryId= $article[0];

			if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['audio'][$audioId])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['audio'][$audioId];
			}else{
				return null;
			}
		}
		
	}

	public static function getVideo($videoId, $article=false){
		if(!$article){
			if(isset(\CE\Loader::$elements['video'][$videoId])){
				return \CE\Loader::$elements['video'][$videoId];
			}else{
				return null;
			}
		}else{
			$articleId= $article[1];
			$categoryId= $article[0];

			if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['video'][$videoId])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['video'][$videoId];
			}else{
				return null;
			}
		}
		
	}

	public static function getAnchor($anchorId, $article=false){
		if(!$article){
			if(isset(\CE\Loader::$elements['enlace'][$anchorId])){
				return \CE\Loader::$elements['enlace'][$anchorId];
			}else{
				return null;
			}	
		}else{
			$articleId= $article[1];
			$categoryId= $article[0];

			if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['enlace'][$anchorId])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['enlace'][$anchorId];
			}else{
				return null;
			}	
		}
		
	}

	public static function isPublished($category, $article){
		if (\CE\Loader::$elements['categoria'][$category]['articulos'][$article]['publico'] == 1){
			return true;
		}else{
			return false;
		}
	}



	public static function getArticles($categoryId, $numberOfArticles= false){
		//Verificar que existan articulos para esta categoria
		if(count(\CE\Loader::$elements['categoria'][$categoryId]['articulos'])>0){
			
			//Obtener los articulos requeridos. Si no se especifica obtener todos.
			$articles;
			if ($numberOfArticles != false){
				$articles = \CE\Loader::$elements['categoria'][$categoryId]['articulos'];
				$articles = array_slice($articles, 0, $numberOfArticles, true);
				

			}

			return array_keys($articles);
		}else{
			return null;
		}
	}

	public static function getArticleMetas($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta'])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta'];
		}else{
			return null;
		}
	}

	public static function articleHasFriendlyUrl($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta']['url_amigable']) && \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta']['url_amigable'] != ""){
				return true;
		}else{
			return false;
		}
	}

	public static function articleNextHasFriendlyUrl($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['next_url_amigable']) && \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['next_url_amigable'] != ""){
				return true;
		}else{
			return false;
		}
	}

	public static function articlePrevHasFriendlyUrl($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['prev_url_amigable']) && \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['prev_url_amigable'] != ""){
				return true;
		}else{
			return false;
		}
	}

	public static function articleGetFriendlyUrl($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta']['url_amigable'])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta']['url_amigable'];
		}else{
			return false;
		}
	}

	public static function articleGetNextFriendlyUrl($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['next_url_amigable'])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['next_url_amigable'];
		}else{
			return false;
		}
	}

	public static function articleGetPrevFriendlyUrl($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['prev_url_amigable'])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['prev_url_amigable'];
		}else{
			return false;
		}
	}

	//Requires HTACCESS
	public static function forceFriendlyUrlRedirect($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta']['url_amigable'])){
			header("LOCATION: http://www.something.com");
		}
	}

	public static function articleHasPrev($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['prev'])){
				return true;
		}else{
			return false;
		}
	}

	public static function articleGetPrev($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['prev'])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['prev'];
		}else{
			return null;
		}
	}	

	public static function articleHasNext($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['next'])){
				return true;
		}else{
			return false;
		}
	}

	public static function articleGetNext($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['next'])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['siblings']['next'];
		}else{
			return null;
		}
	}

	public static function removeArticles($categoryId, $numberOfArticles){
		
		\CE\Loader::$elements['categoria'][$categoryId]['articulos'] = array_slice(
			\CE\Loader::$elements['categoria'][$categoryId]['articulos'],
			$numberOfArticles,
			count(\CE\Loader::$elements['categoria'][$categoryId]['articulos']),
			true
		);
	}

	public static function nextArticle($categoryId){
		if(isset(\CE\Loader::$elements['categoria'][$categoryId]['siguienteArticulo'])){
			return \CE\Loader::$elements['categoria'][$categoryId]['siguienteArticulo'];
		}else{
			return null;
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
		if (filter_var($url_new['host'], FILTER_VALIDATE_IP)) {
		   	return $url_new['host'].':'.$url_new['port'];
		}else {
		    $array = explode(".", $url);
			return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
		}
	}

	private static $elements;
}

?>