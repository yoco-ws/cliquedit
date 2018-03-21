<?php
namespace CE;

class audio{
	//Imprime las estructuras de los elementos de clic edita
	public static function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-audio='$id' ";
		\CE\audio::$id = $id;

		//PENDIENTE CONTROLAR PARAMETROS
		if($params != false){
			if(isset($params['src'])){
				if($params['src'] != false){
					\CE\audio::src($params['src']);
				}	
			}else{
				\CE\audio::src();
			}
		}else{
			//Se imprimen todos los valores por defecto
			\CE\audio::src();
		}
		
	}

	public static function id($id = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if (!$id){
			echo "data-ce-audio='$id' ";
		}else{
			echo "data-ce-audio='$id' ";
			\CE\audio::$id = $id;
		}
		
	}

	public static function getId(){
		return \CE\audio::$id;
	}

	public static function src($placeholder = false){
		$audio;
		if(!\CE\article::isAssigned()){
			$audio = \CE\Loader::getAudio(\CE\audio::getId());
		}else{
			$audio = \CE\Loader::getAudio(\CE\audio::getId(), \CE\article::getId());
		}

		if($audio != null){
			echo 'src="'.$audio['src'].'"';
		}elseif($placeholder != false){
			echo 'src="'.$placeholder.'"';
		}else{
			//No se tiene un audio default
		}
	}

	private static $id;
}

?>