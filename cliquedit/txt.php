<?php
namespace CE;
/*La clase texto representa uno de los muchos elementos de texto posibles de HTML5
 tales como p, h1,h2...,h7, strong, bold. Incluye un atributo richText para determinar si 
 este texto esta compuesto por varias etiquetas*/
class txt{
	//Imprime las estructuras de los elementos de clic edita

	public function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		$richText = '';
		if (isset($params['richtext'])){
			if ($params['richtext'] != false){
				$richText = 'data-ce-richtext';	
			}
		}else{
			
		}

		self::$id = $id;
		echo "<span data-ce-text='$id' $richText>";
		//PENDIENTE CONTROLAR PARAMETROS
		if($params != false){
			if(isset($params['text'])){
				if($params['text'] != false){
					self::$instance->text($params['text']);
				}	
			}else{
				self::$instance->text();
			}
		}else{
			//Se imprimen todos los valores por defecto
			self::$instance->text();
		}
		echo "</span>";
		
	}

	public function id($id = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if (!$id){
			echo "data-ce-text='$id'";	
		}else{
			self::$id = $id;
			echo "data-ce-text='$id'";
		}
		
		
	}

	public function getId(){
		return self::$id;
	}

	public function text($placeholder = false){
		$text;
		if(!\CE\article::isAssigned()){
			$text = \CE\Loader::getText(self::$instance->getId());
		}else{
			$text = \CE\Loader::getText(self::$instance->getId(), \CE\article::getId());
			
		}

		if($text != null){
			echo $text['contenido'];
		}elseif($placeholder != false){
			echo $placeholder;
		}else{
			echo 'Escribe tu texto aquí.';
		}
	}

	//Instancia de Singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new txt();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;

}

?>