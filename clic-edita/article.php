<?php
namespace CE;

class article{
	//Imprime las estructuras de los elementos de clic edita

	public static function id($id = false){
		if(!$id){
			echo 'data-ce-article="'.\CE\article::$id[1].'"';	
		}else{
			\CE\article::$id = $id;
			echo 'data-ce-article="'.\CE\article::$id[1].'"';
		}
	}

	public static function getId(){
		return \CE\article::$id;
	}
	public static function clear(){
		\CE\article::$id = null;
	}

	public static function isAssigned(){
		return isset(\CE\article::$id);
	}

	public static function render_fullview_path($params){

		//Imprimir la url formateada si el artículo tiene
		if(\CE\article::hasFriendlyUrl(\CE\article::$id)){
			echo 'href="'.\CE\article::$detailView.'/'.\CE\article::$id[0].'/'.\CE\article::$id[1].'/'.\CE\article::getFriendlyUrl($article).'"';
		}else{
			$categoryAlias = 'article';
			$articleAlias = 'category';
			if(isset($params['category-alias'])){
				$categoryAlias = $params['category-alias'];
			}
			if(isset($params['article-alias'])){
				$articleAlias = $params['article-alias'];
			}

			echo 'href="'.\CE\article::$detailView.'?'.$params["category-alias"].'='.\CE\article::$id[0].'&'.$params["article-alias"].'='.\CE\article::$id[1].'"';
			echo ' data-ce-read-full';
		}
	}

	public static function render_landing($params){
		
		//Formatear la estructura
		$i = 0;
		$categoryId = \CE\category::getId();

		$numberOfArticles = $params['count'];
		$templatePath = $params['view'];
		$allowAddition = isset($params['allowAddition']);

		//Establecer la ruta al archivo completo, si existe
		if (isset($params['detailView'])){
			\CE\article::$detailView = $params['detailView'];	
		}
		  
		

		$articles[] = \CE\Loader::getArticles($categoryId, $numberOfArticles);
		//Si existen articulos ya sea que esten publicados o no
		if(isset($articles[0])){
			
			if ($allowAddition && \CE\Session::isEditMode()){
				$nextId = \CE\Loader::nextArticle($categoryId);
				$thisArticle = array($categoryId, $nextId);
				\CE\article::$id = $thisArticle;
				echo '<span class="first-ce-article delimiter"></span>';
				include $templatePath;
			}

			do{
				
				if(\CE\Loader::isPublished($categoryId, $articles[0][$i])){
					$thisArticle = array($categoryId, $articles[0][$i]);
					\CE\article::$id = $thisArticle;
					include $templatePath;
				}
				
				$i++;
			}while($i < $numberOfArticles && $i < count($articles[0]));

			//Permitir agregar uno mas

			//Eliminar la cantidad de articulos del arreglo
			\CE\Loader::removeArticles($categoryId, $numberOfArticles);
			\CE\article::clear();
			
		}else{
			//Si no hay articulos, imprimir la estructura por default... TODO: Que id deberia insertar
			if ($allowAddition && \CE\Session::isEditMode()){
				$nextId = \CE\Loader::nextArticle($categoryId);
				$thisArticle = array($categoryId, $nextId);
				\CE\article::$id = $thisArticle;
				echo '<span class="first-ce-article delimiter"></span>';
				include $templatePath;
				\CE\article::clear();
			}else{
				//No existen articulos...
			}
		}
		
	}

	

	public static function metas($article){
		
		$articleMetas = \CE\Loader::getArticleMetas($article[0], $article[1]);

		if(isset($articleMetas)){
			if (isset($articleMetas['keywords'])) echo '<meta name="keywords" content="'.strip_tags($articleMetas['keywords']).'"/>';
			if (isset($articleMetas['titulo'])) echo '<meta property="og:title" content="'.strip_tags($articleMetas['titulo']).'"/>';
			if (isset($articleMetas['descripcion'])) echo '<meta property="og:description" content="'.strip_tags($articleMetas['descripcion']).'"/>';
			if (isset($articleMetas['imagen'])) echo '<meta property="og:image" content="'.$articleMetas['imagen'].'"/>';
		}

		$articleFriendlyUrl = \CE\Loader::articleGetFriendlyUrl($article[0], $article[1]);

		if(isset($articleFriendlyUrl) && $articleFriendlyUrl != ""){
			echo '<meta data-ce-url content="'.strip_tags($articleFriendlyUrl).'"/>';
		}

	}

	public static function href($path, $mainParamsNames, $article, $extraParams = null){
		
		//Imprimir la url formateada si el artículo tiene
		if(\CE\article::hasFriendlyUrl($article)){
			echo 'href="'.$path.'/'.$article[0].'/'.$article[1].'/'.\CE\article::getFriendlyUrl($article).'"';
		}else{
			echo 'href="'.$path.'?'.$mainParamsNames["category"].'='.$article[0].'&'.$mainParamsNames["article"].'='.$article[1].'"';
		}
	}

	public static function prev_href($path, $mainParamsNames, $article, $extraParams = null){
		
		//Imprimir la url formateada si el artículo tiene
		if(\CE\article::prevHasFriendlyUrl($article)){
			echo 'href="'.$path.'/'.$article[0].'/'.\CE\article::getPrev_ret($article).'/'.\CE\article::getPrevFriendlyUrl($article).'"';
		}else{
			echo 'href="'.$path.'?'.$mainParamsNames["category"].'='.$article[0].'&'.$mainParamsNames["article"].'='.\CE\article::getPrev_ret($article).'"';
		}
	}

	public static function next_href($path, $mainParamsNames, $article, $extraParams = null){
		
		//Imprimir la url formateada si el artículo tiene
		if(\CE\article::nextHasFriendlyUrl($article)){
			echo 'href="'.$path.'/'.$article[0].'/'.\CE\article::getNext_ret($article).'/'.\CE\article::getNextFriendlyUrl($article).'"';
		}else{
			echo 'href="'.$path.'?'.$mainParamsNames["category"].'='.$article[0].'&'.$mainParamsNames["article"].'='.\CE\article::getNext_ret($article).'"';
		}
	}

	public static function hasPrev($article){
		return \CE\Loader::articleHasPrev($article[0], $article[1]);
	}

	public static function getPrev($article){
		echo \CE\Loader::articleGetPrev($article[0], $article[1]);
	}

	public static function getPrev_ret($article){
		return \CE\Loader::articleGetPrev($article[0], $article[1]);
	}

	public static function hasNext($article){
		return \CE\Loader::articleHasNext($article[0], $article[1]);
	}

	public static function getNext($article){
		echo \CE\Loader::articleGetNext($article[0], $article[1]);
	}

	public static function getNext_ret($article){
		return \CE\Loader::articleGetNext($article[0], $article[1]);
	}

	public static function hasFriendlyUrl($article){
		return \CE\Loader::articleHasFriendlyUrl($article[0], $article[1]);
	}

	public static function nextHasFriendlyUrl($article){
		return \CE\Loader::articleNextHasFriendlyUrl($article[0], $article[1]);
	}

	public static function prevHasFriendlyUrl($article){
		return \CE\Loader::articlePrevHasFriendlyUrl($article[0], $article[1]);
	}

	public static function getFriendlyUrl($article){
		return \CE\Loader::articleGetFriendlyUrl($article[0], $article[1]);
	}

	public static function getNextFriendlyUrl($article){
		return \CE\Loader::articleGetNextFriendlyUrl($article[0], $article[1]);
	}

	public static function getPrevFriendlyUrl($article){
		return \CE\Loader::articleGetPrevFriendlyUrl($article[0], $article[1]);
	}

	public static function redirect($article){
		\CE\Loader::forceFriendlyUrlRedirect($article[0], $article[1]);
	}

	private static $id;
	private static $detailView;

}

?>