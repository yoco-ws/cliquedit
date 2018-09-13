<?php
namespace CE;

/*
Un articulo es una agrupacion de elementos basicos que en conjunto le dan un significado a algo.
Un articulo puede ser un post de un blog o un banner de un slider, por ejemplo. 
Un articulo pertenece necesariamente a una categoria, y sus ids son unicos dentro de esa categoria.
*/
class article{
	
	//Params: id = array[categoriaId, articuloId]. Regresa el id de articulo si no se reciben parametros.
	public static function id($id = false){
		if(!$id){
			echo 'data-ce-article="'.\CE\article::$id[1].'"';	
		}else{
			try{
				if(!is_array($id)){
					throw new \Exception("Parametro de article::id requiere ser un arreglo de [categoria, id]");
				}
				\CE\article::$id = $id;
				echo 'data-ce-article="'.\CE\article::$id[1].'"';
			}catch(\Exception $e){
				echo '<p>Error: ', $e->getMessage(), '</p>';
			}
		}
	}


	public static function getId(){
		return \CE\article::$id;
	}

	//Libera el id del articulo. Las otras funciones de CE dejaran de considerar
	//a los elementos como partes de un articulo hasta que se vuelva a llamar el metodo article::id .
	public static function clear(){
		\CE\article::$id = null;
	}

	//Verifica si hay un articulo declarado actualmente. Las otras funciones consideraran que el elemento
	//se trata de un articulo hasta que se llame el metodo article::clear
	public static function isAssigned(){
		return isset(\CE\article::$id);
	}

	/*
	Imprime la ruta href para acceder a la vista completa de un articulo
	El metodo necesita que anteriormente se haya llamado pasado el parametro detailView en article::renderLanding

	Parametros:
	[category-alias, article-alias]
	category-alias es el nombre personalizado que se usara para el parametro GET de las categorias.
	Ej: post.php?blog=category&id=article si category-alias es 'blog' y article-alias es 'id' 
	*/
	public static function fullPagePath($params = false){
		
		try{
			if(!isset($params['collectionAlias']) || !isset($params['itemAlias'])){
				throw new \Exception("collection::fullPagePath requiere el segundo argumento [collectionAlias,itemAlias]", 1);
			}

			if(!isset(\CE\article::$detailView)){
				throw new \Exception("collection::fullPagePath requiere que se haya declarado 'detailView' en la landing", 1);
			}

			//Imprimir la url formateada si el artículo tiene
			if(\CE\article::hasFriendlyUrl(\CE\article::$id)){
				echo 'href="'.\CE\article::$detailView.'/'.\CE\article::$id[0].'/'.\CE\article::$id[1].'/'.\CE\article::getFriendlyUrl().'"';
				echo ' data-ce-read-full';
			}else{
				$categoryAlias = 'article';
				$articleAlias = 'category';
				if(isset($params['collectionAlias'])){
					$categoryAlias = $params['collectionAlias'];
				}
				if(isset($params['itemAlias'])){
					$articleAlias = $params['itemAlias'];
				}

				echo 'href="'.\CE\article::$detailView.'?'.$params["collectionAlias"].'='.\CE\article::$id[0].'&'.$params["itemAlias"].'='.\CE\article::$id[1].'"';
				echo ' data-ce-read-full';
			}
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}
		
	}

	/*
	Imprime una landing de un conjunto de articulos pertenecientes a una categoria
	Las landings son una forma de mostrar uno o mas articulos de una categoria con algun formato especificado

	Parametros:
	count: (opcional) la cantidad de articulos a mostrar. Por defecto muestra todos.
	view: La vista maquetada de cada articulo en la landing. Es una ruta a un archivo.
	allowAddition: (opcional) De permitirse, de agregara un elemento adicional a la landing que se usara para agregar nuevos articulos
	page-alias: TODO	
	*/
	public static function renderLanding($params){
		
		//Formatear la estructura
		$i = 0;
		$categoryId = \CE\category::getInstance()->getId();

		$numberOfArticles;
		if(isset($params['count'])){
			$numberOfArticles = $params['count'];
		}else{
			$numberOfArticles = \CE\loader::getNumArticles($categoryId);
		}
		try{
			if(!isset($params['view'])){
				throw new \Exception("article::renderLanding requiere el parametro view");
			}
			if( !file_exists($params['view'])){
				throw new \Exception("No se encontró un archivo en la ruta ".$params['view']);
			}
			$templatePath = $params['view'];
		
			$allowAddition = isset($params['allowAddition']);

			//Establecer la ruta al archivo completo, si existe
			if (isset($params['fullPagePath'])){
				\CE\article::$detailView = $params['fullPagePath'];	
			}

			if(isset($params['pageAlias'])){
				if( isset( $_GET[ $params['pageAlias'] ] ) && $_GET[ $params['pageAlias'] ] != 1)  $allowAddition = false;
			}

			$articles[] = \CE\Loader::getArticles($categoryId, $numberOfArticles);
			//Si existen articulos ya sea que esten publicados o no
			if(isset($articles[0])){
				
				if ($allowAddition && \CE\session::isEditMode()){
					$nextId = \CE\Loader::nextArticle($categoryId);
					$thisArticle = array($categoryId, $nextId);
					\CE\article::$id = $thisArticle;
					echo '<span class="first-ce-article delimiter"></span>';
					include $templatePath;
				}

				$i = 0;
				while($i < $numberOfArticles && $i < count($articles[0])){
					
					if(\CE\Loader::isPublished($categoryId, $articles[0][$i])){
						$thisArticle = array($categoryId, $articles[0][$i]);
						\CE\article::$id = $thisArticle;
						include $templatePath;
					}
					
					$i++;
				}

				//Permitir agregar uno mas

				//Eliminar la cantidad de articulos del arreglo
				\CE\Loader::removeArticles($categoryId, $numberOfArticles);
				\CE\article::clear();
				
			}else{
				//Si no hay articulos, imprimir la estructura por default... TODO: Que id deberia insertar
				if ($allowAddition && \CE\session::isEditMode()){
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
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}
		
		
	}

	/*
	Imprime todas las etiquetas metas de un articulo
	Si no se pasa el ID del articulo se buscara si ya ha sido declarado antes. De lo contrario se requiere
	que se pase el id del articulo manualmente. El id se compone de categoria y articulo.
	*/
	public static function metas($article = null){
		if($article === null) $article = \CE\article::$id;

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

	/*Unused*/
	public static function href($path, $mainParamsNames=['collectionAlias' => 'categoria', 'itemAlias' => 'articulo'], $article=null, $extraParams = null){
		if($article === null) $article = \CE\article::$id;

		//Imprimir la url formateada si el artículo tiene
		if(\CE\article::hasFriendlyUrl($article)){
			echo 'href="'.$path.'/'.$article[0].'/'.$article[1].'/'.\CE\article::getFriendlyUrl($article).'"';
		}else{
			echo 'href="'.$path.'?'.$mainParamsNames["collectionAlias"].'='.$article[0].'&'.$mainParamsNames["itemAlias"].'='.$article[1].'"';
		}
	}

	/*
	Imprime la ruta del articulo anterior
	path es la ruta a la vista de detalle del articulo
	[collectionAlias y itemAlias] son los nombres de los parametros GET

	*/
	public static function prevHref($path, $mainParamsNames, $article=null, $extraParams = null){
		if($article === null) $article = \CE\article::$id;
		try{
			if(!isset($path)){
				throw new \Exception("article::prevHref requiere el parametro path");
			}
			if(!isset($mainParamsNames['collectionAlias']) || !isset($mainParamsNames['itemAlias'])){
				throw new \Exception("article::prevHref requiere los parametros [collectionAlias, itemAlias]");
			}
			//Imprimir la url formateada si el artículo tiene
			if(\CE\article::prevHasFriendlyUrl($article)){
				echo 'href="'.$path.'/'.$article[0].'/'.\CE\article::getPrev_ret($article).'/'.\CE\article::getPrevFriendlyUrl($article).'"';
			}else{
				echo 'href="'.$path.'?'.$mainParamsNames["collectionAlias"].'='.$article[0].'&'.$mainParamsNames["itemAlias"].'='.\CE\article::getPrev_ret($article).'"';
			}
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}
	}

	/*
	Imprime la ruta del articulo siguiente
	path es la ruta a la vista de detalle del articulo
	[collectionAlias y itemAlias] son los nombres de los parametros GET
	
	*/
	public static function nextHref($path, $mainParamsNames, $article=null, $extraParams = null){
		if($article === null) $article = \CE\article::$id;

		//Imprimir la url formateada si el artículo tiene
		try{
			if(!isset($path)){
				throw new \Exception("article::nextHref requiere el parametro path");
			}
			if(!isset($mainParamsNames['collectionAlias']) || !isset($mainParamsNames['itemAlias'])){
				throw new \Exception("article::nextHref requiere los parametros [collectionAlias, itemAlias]");
			}

			if(\CE\article::nextHasFriendlyUrl($article)){
				echo 'href="'.$path.'/'.$article[0].'/'.\CE\article::getNext_ret($article).'/'.\CE\article::getNextFriendlyUrl($article).'"';
			}else{
				echo 'href="'.$path.'?'.$mainParamsNames["collectionAlias"].'='.$article[0].'&'.$mainParamsNames["itemAlias"].'='.\CE\article::getNext_ret($article).'"';
			}
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}

	}

	public static function hasPrev($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleHasPrev($article[0], $article[1]);
	}

	public static function getPrev($article=null){
		if($article === null) $article = \CE\article::$id;
		echo \CE\Loader::articleGetPrev($article[0], $article[1]);
	}

	/*unused*/
	public static function getPrev_ret($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleGetPrev($article[0], $article[1]);
	}

	public static function hasNext($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleHasNext($article[0], $article[1]);
	}

	public static function getNext($article=null){
		if($article === null) $article = \CE\article::$id;
		echo \CE\Loader::articleGetNext($article[0], $article[1]);
	}

	/*Unused*/
	public static function getNext_ret($article){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleGetNext($article[0], $article[1]);
	}

	public static function hasFriendlyUrl($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleHasFriendlyUrl($article[0], $article[1]);
	}

	public static function nextHasFriendlyUrl($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleNextHasFriendlyUrl($article[0], $article[1]);
	}

	public static function prevHasFriendlyUrl($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articlePrevHasFriendlyUrl($article[0], $article[1]);
	}

	public static function getFriendlyUrl($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleGetFriendlyUrl($article[0], $article[1]);
	}

	public static function getNextFriendlyUrl($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleGetNextFriendlyUrl($article[0], $article[1]);
	}

	public static function getPrevFriendlyUrl($article=null){
		if($article === null) $article = \CE\article::$id;
		return \CE\Loader::articleGetPrevFriendlyUrl($article[0], $article[1]);
	}

	/*unused*/
	public static function redirect($article=null){
		if($article === null) $article = \CE\article::$id;
		\CE\Loader::forceFriendlyUrlRedirect($article[0], $article[1]);
	}

	private static $id;
	private static $detailView;

}

?>