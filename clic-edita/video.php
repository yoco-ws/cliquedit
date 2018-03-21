<?php
namespace CE;

class video{
	//Imprime las estructuras de los elementos de clic edita

	public static function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-video='$id' ";
		\CE\video::$id = $id;

		//PENDIENTE CONTROLAR PARAMETROS
		if($params != false){
			if(isset($params['src'])){
				if($params['src'] != false){
					\CE\video::src($params['src']);
				}	
			}else{
				\CE\video::src();
			}

			if(isset($params['poster'])){
				if($params['poster'] != false){
					\CE\video::alt($params['poster']);
				}	
			}else{
				\CE\video::poster();
			}
		}else{
			//Se imprimen todos los valores por defecto
			\CE\video::src();
			\CE\video::poster();
		}
		
	}

	public static function id($id = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if (!$id){
			echo "data-ce-video='$id' ";
		}else{
			echo "data-ce-video='$id' ";
			\CE\video::$id = $id;
		}
		
	}

	public static function getId(){
		return \CE\video::$id;
	}

	public static function src($placeholder = false){
		$video;
		if(!\CE\article::isAssigned()){
			$video = \CE\Loader::getVideo(\CE\video::getId());
		}else{
			$video = \CE\Loader::getVideo(\CE\video::getId());
		}

		if($video != null){
			echo 'src="'.$video['src'].'"';
		}elseif($placeholder != false){
			echo 'src="'.$placeholder.'"';
		}else{
			echo 'src="..."';
		}
	}

	public static function poster($placeholder = false){
		$video;
		if(!\CE\article::isAssigned()){
			$video = \CE\Loader::getVideo(\CE\video::getId());
		}else{
			$video = \CE\Loader::getVideo(\CE\video::getId(), \CE\article::getId());
		}

		if($video != null){
			echo 'poster="'.$video['poster'].'"';
		}elseif($placeholder != false){
			echo 'poster="'.$placeholder.'"';
		}else{
			//Mostrar vista previ por defecto
		}	
	}

	private static $id;
}

?>