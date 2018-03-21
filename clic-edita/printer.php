<?php
namespace CE;

class Printer{
	//Imprime las estructuras de los elementos de clic edita

	public static function printPlainText($textId, $placeholder=false, $article=false){
		$text;
		if(!$article){
			$text = \CE\Loader::getText($textId);
		}else{
			$text = \CE\Loader::getText($textId, $article);
			
		}

		if($text != null){
			echo $text['contenido'];
		}else{
			echo $placeholder;
		}
		
	}

	public static function printImageDetails($imageId, $ph_src=false, $article=false){
		$image;
		if(!$article){
			$image = \CE\Loader::getImage($imageId);
		}else{
			$image = \CE\Loader::getImage($imageId, $article);
		}

		if($image != null){
			echo 'src="'.$image['src'].'" alt="'.$image['alt'].'"';
		}else{
			echo 'src="'.$ph_src.'"';
		}
	}

	public static function printAnchorDetails($anchorId, $ph_href=false, $article=false){
		
		$anchor;
		if(!$article){
			$anchor = \CE\Loader::getAnchor($anchorId);
		}else{
			$anchor = \CE\Loader::getAnchor($anchorId, $article);
		}

		if($anchor != null){
			echo 'href="'.$anchor['href'].'"';
		}else{
			echo 'href="'.$ph_href.'"';
		}
		
	}

	//El catalogo se compone de varios articulos pertenecientes a una categoria representados en una estructura
	//definida por el maquetador
	public static function printCatalog($templatePath, $categoryId, $numberOfArticles=10, $allowAddition = false, $detailPath = false){

		//Formatear la estructura
		$i = 0;
		$articles[] = \CE\Loader::getArticles($categoryId, $numberOfArticles);
		//Si existen articulos ya sea que esten publicados o no
		if(isset($articles[0])){
			
			if ($allowAddition && \CE\Session::isEditMode()){
				$nextId = \CE\Loader::nextArticle($categoryId);
				$thisArticle = array($categoryId, $nextId);
				echo '<span class="first-ce-article delimiter"></span>';
				include $templatePath;
			}

			do{
				
				if(\CE\Loader::isPublished($categoryId, $articles[0][$i])){
					$thisArticle = array($categoryId, $articles[0][$i]);
					include $templatePath;
				}
				
				$i++;
			}while($i < $numberOfArticles && $i < count($articles[0]));

			//Permitir agregar uno mas

			//Eliminar la cantidad de articulos del arreglo
			\CE\Loader::removeArticles($categoryId, $numberOfArticles);
			
		}else{
			//Si no hay articulos, imprimir la estructura por default... TODO: Que id deberia insertar
			if ($allowAddition && \CE\Session::isEditMode()){
				$nextId = \CE\Loader::nextArticle($categoryId);
				$thisArticle = array($categoryId, $nextId);
				echo '<span class="first-ce-article delimiter"></span>';
				include $templatePath;
			}else{
				//No existen articulos...
			}
		}
	}

	public static function printArticleMetas($category, $article_number){
		
		$articleMetas = \CE\Loader::getArticleMetas($category, $article_number);

		if(isset($articleMetas)){
			if (isset($articleMetas['keywords'])) echo '<meta name="keywords" content="'.$articleMetas['keywords'].'"/>';
			if (isset($articleMetas['titulo'])) echo '<meta property="og:title" content="'.$articleMetas['titulo'].'"/>';
			if (isset($articleMetas['descripcion'])) echo '<meta property="og:description" content="'.$articleMetas['descripcion'].'"/>';
			if (isset($articleMetas['imagen'])) echo '<meta property="og:image" content="'.$articleMetas['imagen'].'"/>';
		}

		
		
			
	}



}

?>