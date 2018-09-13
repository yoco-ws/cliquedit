<?php
namespace CE;
/*Un video de HTML5. Incluye los atributos src y poster*/
class video{
	//Imprime las estructuras de los elementos de clic edita

	public function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-video='$id' ";
		self::$id = $id;

		//PENDIENTE CONTROLAR PARAMETROS
		if($params != false){
			if(isset($params['src'])){
				if($params['src'] != false){
					self::$instance->src($params['src']);
				}	
			}else{
				self::$instance->src();
			}

			if(isset($params['poster'])){
				if($params['poster'] != false){
					self::$instance->poster($params['poster']);
				}	
			}else{
				self::$instance->poster();
			}
		}else{
			//Se imprimen todos los valores por defecto
			self::$instance->src();
			self::$instance->poster();
		}
		
	}

	public function id($id = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if (!$id){
			echo "data-ce-video='$id' ";
		}else{
			echo "data-ce-video='$id' ";
			self::$id = $id;
		}
		
	}

	public function getId(){
		return self::$id;
	}

	public function src($placeholder = false){
		$video;
		if(!\CE\article::isAssigned()){
			$video = \CE\Loader::getVideo(self::$instance->getId());
		}else{
			$video = \CE\Loader::getVideo(self::$instance->getId(), \CE\article::getId());
		}

		if($video != null){
			echo 'src="'.$video['src'].'"';
		}elseif($placeholder != false){
			echo 'src="'.$placeholder.'"';
		}else{
			echo 'src="https://player.vimeo.com/external/261171668.sd.mp4?s=b9b655a7427dcbf4582e447f48d8b9c9e3e485c4&profile_id=165"';
		}
	}

	public function poster($placeholder = false){
		$video;
		if(!\CE\article::isAssigned()){
			$video = \CE\Loader::getVideo(self::$instance->getId());
		}else{
			$video = \CE\Loader::getVideo(self::$instance->getId(), \CE\article::getId());
		}

		if($video != null){
			echo 'poster="'.$video['poster'].'"';
		}elseif($placeholder != false){
			echo 'poster="'.$placeholder.'"';
		}else{
			//Mostrar vista previ por defecto
		}	
	}

	public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new video();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;
}

?>