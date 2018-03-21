<?php
namespace CE;

class category{
	//Imprime las estructuras de los elementos de clic edita

	public static function id($id = false){
		if(!$id){
			echo "data-ce-category=$id";	
		}else{
			\CE\category::$id = $id;
			echo "data-ce-category=$id";	
		}
		
	}

	public static function getId(){
		return \CE\category::$id;
	}

	//El catalogo se compone de varios articulos pertenecientes a una categoria representados en una estructura
	//definida por el maquetador
	public static function landing($templatePath, $categoryId, $numberOfArticles=10, $allowAddition = false, $detailPath = false){

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

	private static $id;

}

?>