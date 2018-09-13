<?php
namespace CE;
/*Un codigo embebido, acepta cualquier etiqueta html como los iframes de YouTube*/
class embed{
	//Imprime las estructuras de los elementos de clic edita

	//A diferencia de los demas elementos, el render no se debe llamar dentro de una etiqueta html.
	//Este render genera las etiquetas necesarias.
	public static function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		self::$id = $id;

		$structure = '
			<div data-ce-embed="%embedId%">
				%code%
			</div>
		';
		$structure = str_replace("%embedId%", self::$id, $structure);

		//Obtener el valor de code
		$code = "";
		if($params != false){
			if(isset($params['code'])){
				if($params['code'] != false){
					$code = self::$instance->code($params['code']);
				}	
			}else{
				$code = self::$instance->code();
			}

		}else{
			$code = self::$instance->code();
		}

		$code = htmlspecialchars_decode($code);
		$structure = str_replace("%code%", $code, $structure);
		echo $structure;
		
	}

	public static function getId(){
		return self::$id;
	}

	public static function code($placeholder = false){
		$embed;
		if(!\CE\article::isAssigned()){
			$embed = \CE\Loader::getEmbed( self::$instance->getId() );
		}else{
			$embed = \CE\Loader::getEmbed( self::$instance->getId(), \CE\article::getId());
		}

		if($embed != null){
			return $embed['codigo'];
		}elseif($placeholder != false){
			return $placeholder;
		}else{
			return "default";
		}
	}

	//Instancia de Singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new embed();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;
}

?>