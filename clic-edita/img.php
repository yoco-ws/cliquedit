<?php
namespace CE;

class img{
	//Imprime las estructuras de los elementos de clic edita

	public static function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-image='$id' ";
		\CE\img::$id = $id;

		//PENDIENTE CONTROLAR PARAMETROS
		if($params != false){
			if(isset($params['src'])){
				if($params['src'] != false){
					\CE\img::src($params['src']);
				}	
			}else{
				\CE\img::src();
			}

			if(isset($params['alt'])){
				if($params['alt'] != false){
					\CE\img::alt($params['alt']);
				}	
			}else{
				\CE\img::alt();
			}
		}else{
			//Se imprimen todos los valores por defecto
			\CE\img::src();
			\CE\img::alt();
		}
		
	}

	public static function id($id = false, $subdir='predeterminado'){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if(!$id){
			echo "data-ce-image='$id' ";
			echo "data-subdirectory = $subdir";	
		}else{
			\CE\img::$id = $id;
			echo "data-ce-image='$id' ";
			echo "data-subdirectory = $subdir";	
		}
		
		
	}

	public static function getId(){
		return \CE\img::$id;
	}

	public static function src($placeholder = false){
		$image;
		if(!\CE\article::isAssigned()){
			$image = \CE\Loader::getImage(\CE\img::getId());
		}else{
			$image = \CE\Loader::getImage(\CE\img::getId(), \CE\article::getId());
		}

		if($image != null){
			echo 'src="'.$image['src'].'" ';
		}elseif($placeholder != false){
			echo 'src="'.$placeholder.'" ';
		}else{
			echo 'src="https://yoco.ws/clic-edita/img/add_img_normal.jpg"';
		}
	}

	public static function alt($placeholder = false){
		$image;
		if(!\CE\article::isAssigned()){
			$image = \CE\Loader::getImage(\CE\img::getId());
		}else{
			$image = \CE\Loader::getImage(\CE\img::getId(), \CE\article::getId());
		}

		if($image != null){
			echo 'alt="'.$image['alt'].'"';
		}elseif($placeholder != false){
			echo 'alt="'.$placeholder.'"';
		}else{
			echo 'alt="Escribe la descripción de esta imágen"';
		}
	}

	private static $id;

}

?>