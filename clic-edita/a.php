<?php
namespace CE;

class a{
	//Imprime las estructuras de los elementos de clic edita

	public static function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-anchor='$id' ";
		\CE\a::$id = $id;

		//PENDIENTE CONTROLAR PARAMETROS
		if($params != false){
			if(isset($params['href'])){
				if($params['href'] != false){
					\CE\a::href($params['href']);
				}	
			}else{
				\CE\a::href();
			}
		}else{
			//Se imprimen todos los valores por defecto
			\CE\a::href();
		}
		
	}

	public static function id($id = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if (!$id){
			echo "data-ce-anchor='$id'";
		}else{
			echo "data-ce-anchor='$id'";
			\CE\a::$id = $id;
		}
		
	}

	public static function getId(){
		return \CE\a::$id;
	}

	public static function href($placeholder = false){
		$anchor;
		if(!\CE\article::isAssigned()){
			$anchor = \CE\Loader::getAnchor(\CE\a::getId());
		}else{
			$anchor = \CE\Loader::getAnchor(\CE\a::getId(), \CE\article::getId());
		}

		if($anchor != null){
			echo 'href="'.$anchor['href'].'"';
		}elseif($placeholder != false){
			echo 'href="'.$placeholder.'"';
		}else{
			echo 'href ="http://tudireccion.ce"';
		}
	}

	private static $id;
}

?>