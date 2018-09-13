<?php
namespace CE;

/*Un ancla. Al igual que el elemento HTML5, tiene el atributo href*/
class a{
	
	//Imprime los atributos del ancla en base al id y a los parametros recibidos.
	public function render($id, $params = false){
		//Imprime la etiqueta correspondiente para la edicion por JS
		echo "data-ce-anchor='$id' ";
		self::$id = $id;

		if($params != false){
			if(isset($params['href'])){
				if($params['href'] != false){
					self::$instance->href($params['href']);
				}	
			}else{
				self::$instance->href();
			}
		}else{
			//Se imprimen todos los valores por defecto
			self::$instance->href();
		}
		
	}

	public function getId(){
		return self::$id;
	}

	private function href($placeholder = false){
		$anchor;
		if(!\CE\article::isAssigned()){
			$anchor = \CE\Loader::getAnchor(self::$instance->getId());
		}else{
			$anchor = \CE\Loader::getAnchor(self::$instance->getId(), \CE\article::getId());
		}

		if($anchor != null){
			echo 'href="'.$anchor['href'].'"';
		}elseif($placeholder != false){
			echo 'href="'.$placeholder.'"';
		}else{
			//El href por defecto si no existe el elemento y no se reciben parametros
			echo 'href ="#"';
		}
	}

	//Instancia de Singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new a();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;
}

?>