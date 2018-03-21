<?php
namespace CE;

class txt{
	//Imprime las estructuras de los elementos de clic edita

	public static function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		\CE\txt::$id = $id;
		echo "<span data-ce-text='$id'>";
		\CE\txt::text();
		echo "</span>";
		
	}

	public static function id($id = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if (!$id){
			echo "data-ce-text='$id'";	
		}else{
			\CE\txt::$id = $id;
			echo "data-ce-text='$id'";
		}
		
		
	}

	public static function getId(){
		return \CE\txt::$id;
	}

	public static function text($placeholder = false){
		$text;
		if(!\CE\article::isAssigned()){
			$text = \CE\Loader::getText(\CE\txt::getId());
		}else{
			$text = \CE\Loader::getText(\CE\txt::getId(), \CE\article::getId());
			
		}

		if($text != null){
			echo $text['contenido'];
		}elseif($placeholder != false){
			echo $placeholder;
		}else{
			echo 'Escribe tu texto aquí.';
		}
	}

	private static $id;

}

?>