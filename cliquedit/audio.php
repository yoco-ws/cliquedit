<?php
namespace CE;
/*Un audio de HTML5. Incluye el atributo src*/
class audio{
	//Imprime las estructuras de los elementos de clic edita
	public function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-audio='$id' ";
		self::$id = $id;

		if($params != false){
			if(isset($params['src'])){
				if($params['src'] != false){
					self::$instance->src($params['src']);
				}	
			}else{
				self::$instance->src();
			}
		}else{
			//Se imprimen todos los valores por defecto
			self::$instance->src();
		}
		
	}

	public function id($id = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if (!$id){
			echo "data-ce-audio='$id' ";
		}else{
			echo "data-ce-audio='$id' ";
			self::$id = $id;
		}
		
	}

	public function getId(){
		return self::$id;
	}

	private function src($placeholder = false){
		$audio;
		if(!\CE\article::isAssigned()){
			$audio = \CE\Loader::getAudio(self::$instance->getId());
		}else{
			$audio = \CE\Loader::getAudio(self::$instance->getId(), \CE\article::getId());
		}

		if($audio != null){
			echo 'src="'.$audio['src'].'"';
		}elseif($placeholder != false){
			echo 'src="'.$placeholder.'"';
		}else{
			//No se tiene un audio default
		}
	}

	//Instancia de Singleton 
    public static function getInstance(){

        if (is_null(self::$instance)) {
            self::$instance = new audio();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;
}

?>