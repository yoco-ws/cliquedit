<?php
namespace CE;
/*
La clase loader se encarga de recuperar la informacion obtenida de la BD y darle un sentido
Es usada por todas las clases de CE.

*/

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

	public static function getEmbed($embedId, $article=false){
		if(!$article){
			if(isset(\CE\Loader::$elements['embebido'][$embedId])){
				return \CE\Loader::$elements['embebido'][$embedId];
			}else{
				return null;
			}
		}else{
			$articleId= $article[1];
			$categoryId= $article[0];

			if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['embebido'][$embedId])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['embebido'][$embedId];
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

	public static function getComposed($composedId, $article=false){
		if(!$article){
			if(isset(\CE\Loader::$elements['compuesto'][$composedId])){
				return \CE\Loader::$elements['compuesto'][$composedId];
			}else{
				return null;
			}	
		}else{
			$articleId= $article[1];
			$categoryId= $article[0];

			if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['compuesto'][$composedId])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['compuesto'][$composedId];
			}else{
				return null;
			}	
		}
		
	}

	//Si el articulo tiene estado 'publicado'
	public static function isPublished($category, $article){
		
		if(isset(\CE\Loader::$elements['categoria'][$category]['articulos'][$article]['publico'])){
			if (\CE\Loader::$elements['categoria'][$category]['articulos'][$article]['publico'] == 1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}



	public static function getArticles($categoryId, $numberOfArticles= false, $startPoint = 0){
		//Verificar que existan articulos para esta categoria
		if(isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'])){
			if(count(\CE\Loader::$elements['categoria'][$categoryId]['articulos'])>0){
			
				//Obtener los articulos requeridos. Si no se especifica obtener todos.
				$articles;
				if ($numberOfArticles != false){
					$articles = \CE\Loader::$elements['categoria'][$categoryId]['articulos'];
					
					$articles = array_slice($articles, $startPoint, $numberOfArticles, true);
					

				}

				return array_keys($articles);
			}else{
				return 0;
			}
		}else{
			throw new \Exception("No se obtuvieron datos de la categoria con id [".$categoryId."] al obtener la lista de artículos. Verifica que se haya solicitado la informacion al cargar la página con el metodo page::load");
			
			return null;
		}
		
	}

	//Obtiene el total de todos los elementos de la categoria
	public static function getCategoryTotal($categoryId){
		if(!isset(\CE\Loader::$elements['categoria'][$categoryId])){
			throw new \Exception("No se obtuvieron datos de la categoria con id [".$categoryId."] al obtener el total de la categoria. Verifica que se haya solicitado la informacion al cargar la página con el metodo page::load");
			return 0;
		}
		return \CE\Loader::$elements['categoria'][$categoryId]['total'];
	}

	//Obtiene el total de los elementos de la categoria presentes
	public static function getNumArticles($categoryId){
		if (isset(\CE\Loader::$elements['categoria'][$categoryId]['articulos'])){
			return count(\CE\Loader::$elements['categoria'][$categoryId]['articulos']);
		}else{
			return 0;
		}
	}

	public static function getArticleMetas($categoryId, $articleId){
		if(isset( \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta'])){
				return \CE\Loader::$elements['categoria'][$categoryId]['articulos'][$articleId]['meta'];
		}else{
			return null;
		}
	}

	public static function getPageMetas($pageId){
		if(isset( \CE\Loader::$elements['pagina'][$pageId])){
				return \CE\Loader::$elements['pagina'][$pageId];
		}else{
			return null;
		}
	}

	public static function getPageTitle($pageId){
		if(isset( \CE\Loader::$elements['pagina'][$pageId]['sharing_titulo'])){
				return \CE\Loader::$elements['pagina'][$pageId]['sharing_titulo'];
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

	//Unused
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