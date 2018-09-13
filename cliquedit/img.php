<?php
namespace CE;
/*Representa una imagen de HTML5. Soporta los atributos src y alt*/

class img{
	
	public function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-image='$id' ";
		self::$id = $id;

		if($params != false){
			if(isset($params['src'])){
				if($params['src'] != false){
					self::$instance->src($params['src']);
				}	
			}else{
				self::$instance->src();
			}

			if(isset($params['alt'])){
				if($params['alt'] != false){
					self::$instance->alt($params['alt']);
				}	
			}else{
				self::$instance->alt();
			}
		}else{
			//Se imprimen todos los valores por defecto
			self::$instance->src();
			self::$instance->alt();
		}
		
	}

	public function id($id = false, $subdir='predeterminado'){
		//Imprime la etiqueta correspondiente para la edicion por JS
		if(!$id){
			echo "data-ce-image='$id' ";
			echo "data-subdirectory = $subdir";	
		}else{
			self::$id = $id;
			echo "data-ce-image='$id' ";
			echo "data-subdirectory = $subdir";	
		}
		
		
	}

	public function getId(){
		return self::$id;
	}

	public function src($placeholder = false){
		$image;
		if(!\CE\article::isAssigned()){
			$image = \CE\Loader::getImage(self::$instance->getId());
		}else{
			$image = \CE\Loader::getImage(self::$instance->getId(), \CE\article::getId());
		}

		if($image != null){
			echo 'src="'.$image['src'].'" ';
		}elseif($placeholder != false){
			echo 'src="'.$placeholder.'" ';
		}else{
			echo 'src="https://yoco.ws/clic-edita/img/add_img_normal.jpg"';
		}
	}

	public function alt($placeholder = false){
		$image;
		if(!\CE\article::isAssigned()){
			$image = \CE\Loader::getImage(self::$instance->getId());
		}else{
			$image = \CE\Loader::getImage(self::$instance->getId(), \CE\article::getId());
		}

		if($image != null){
			echo 'alt="'.$image['alt'].'"';
		}elseif($placeholder != false){
			echo 'alt="'.$placeholder.'"';
		}else{
			echo 'alt="Escribe la descripción de esta imágen"';
		}
	}

	//Instancia de Singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new img();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;

}

?>