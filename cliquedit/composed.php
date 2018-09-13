<?php
namespace CE;

#Falta: Imprimir las etiquetas validas para que JS detecte. Agregar un prefijo al id.

class composed{
	//Imprime las estructuras de los elementos de clic edita

	public function render($id, $params = false){
		
		//Parametros: [text, img, a, video, audio, embed]
		try{

			if($params === false || !is_array($params)) 
				throw new \Exception("Para usar el elemento composed requieres declarar un arreglo con los tipos de elementos aceptados");

			//Agregar prefijo a id
			$composedPrefix = "composed_";
			$id = $composedPrefix.$id;

			//Verificar si existe el elemento composed declarado
			self::$id = $id;

			if(self::$instance->exists()){
				$composedType = \CE\composed::getType();
				if(self::$instance->isValidType($composedType, $params)){
					self::$instance->printStructure($composedType, $params);
				}else{
					throw new \Exception("El tipo de elemento ".$composedType." no es valido");
				}
			}else{
				//No se ha guardado nunca el elemento composed. Mostrar el primer elemento del arreglo
				if(self::$instance->isValidType($params[0], $params)){
					self::$instance->printStructure($params[0], $params);
				}else{
					throw new \Exception("El tipo de elemento ". $params[0]." no es valido");
				}
			}
			
		}catch(\Exception $e){
			echo '<strong>Clic Edita Error: '.$e->getMessage().'</strong>';
		}
		
	}

	public function getId(){
		return self::$id;
	}

	private function exists(){

		if(!\CE\article::isAssigned()){
			$composed = \CE\Loader::getComposed(self::$instance->getId());
		}else{
			$composed = \CE\Loader::getComposed(self::$instance->getId(), \CE\article::getId());
		}

		if($composed === null){
			return false;
		}else{
			return true;
		}
	}

	private function getType(){

		if(!\CE\article::isAssigned()){
			$composed = \CE\Loader::getComposed(self::$instance->getId());
		}else{
			$composed = \CE\Loader::getComposed(self::$instance->getId(), \CE\article::getId());
		}

		if($composed === null){
			throw new Exception("No se ha guardado el elemento composed solicitado por composed::getType");
		}else{
			return $composed['tipo_dato'];
		}
	}

	private function isValidType($type, $validTypes){
		$generalTypes = ['txt', 'img', 'video', 'audio', 'a', 'embed', 'none'];

		if(in_array($type, $validTypes) && in_array($type, $generalTypes))
			return true;
		else
			return false;
	}

	private function printStructure($actualType, $possibleTypes){

		//Remover el tipo real a la lista de tipos posibles
		if(($key = array_search($actualType, $possibleTypes)) !== false){
			unset($possibleTypes[$key]);
		}

		//Convertir los valores posibles a un string separado por comas
		$typeString = implode(',', $possibleTypes);

		//Imprimir la estructura correspondiente dependiendo del tipo de elemento
		switch ($actualType) {
			case 'txt':
				self::$instance->printTxt($typeString);
				break;
			case 'img':
				self::$instance->printImg($typeString);
				break;
			case 'a':
				self::$instance->printAnchor($typeString);
				break;
			case 'video':
				self::$instance->printVideo($typeString);
				break;
			case 'audio':
				self::$instance->printAudio($typeString);
				break;
			case 'embed':
				self::$instance->printAudio($typeString);
				break;
			case 'none':
				if(\CE\session::isEditMode())
					self::$instance->printNone($typeString);
				break;
			default:
				throw new Exception("Se ha ingresado un tipo de dato invalido: ".$actualType);
		}
	}

	private function printTxt($types){
		$structure = "
			<span data-ce-composed = '%composedId%' data-ce-composedval= '%possibleTypes%' >
				%textData%
			</span>
		";
		$composedId = self::$id;

		$structure = str_replace("%composedId%", $composedId, $structure);
		$structure = str_replace("%possibleTypes%", $types, $structure);

		$cliqued = \CE\CliquedIt::getInstance();

		//Gets the text data
		ob_start();
		$cliqued->text()->render( $composedId );
		$textData = ob_get_contents();
		ob_end_clean();

		$structure = str_replace("%textData%", $textData, $structure);

		echo $structure;

	}

	private function printImg($types){
		$structure = "
			<span data-ce-composed = '%composedId%' data-ce-composedval= '%possibleTypes%'>
				<img %imageData% />
			</span>
		";
		$composedId = self::$id;

		$structure = str_replace("%composedId%", $composedId, $structure);
		$structure = str_replace("%possibleTypes%", $types, $structure);

		$cliqued = \CE\CliquedIt::getInstance();

		//Gets the text data
		ob_start();
		$cliqued->image()->render( $composedId );
		$imageData = ob_get_contents();
		ob_end_clean();

		$structure = str_replace("%imageData%", $imageData, $structure);

		echo $structure;

	}

	private function printVideo($types){
		$structure = "
			<span data-ce-composed = '%composedId%' data-ce-composedval= '%possibleTypes%'>
				<video controls %videoData% />
			</span>
		";
		$composedId = self::$id;

		$structure = str_replace("%composedId%", $composedId, $structure);
		$structure = str_replace("%possibleTypes%", $types, $structure);

		$cliqued = \CE\CliquedIt::getInstance();

		//Gets the text data
		ob_start();
		$cliqued->video()->render( $composedId );
		$videoData = ob_get_contents();
		ob_end_clean();

		$structure = str_replace("%videoData%", $videoData, $structure);

		echo $structure;

	}

	private function printAudio($types){
		$structure = "
			<span data-ce-composed = '%composedId%' data-ce-composedval= '%possibleTypes%'>
				%embedData%
			</span>
		";
		$composedId = self::$id;

		$structure = str_replace("%composedId%", $composedId, $structure);
		$structure = str_replace("%possibleTypes%", $types, $structure);

		$cliqued = \CE\CliquedIt::getInstance();

		//Gets the text data
		ob_start();
		$cliqued->embed()->render( $composedId );
		$embedData = ob_get_contents();
		ob_end_clean();

		$structure = str_replace("%embedData%", $embedData, $structure);

		echo $structure;

	}

	private function printEmbed($types){
		$structure = "
			<span data-ce-composed = '%composedId%' data-ce-composedval= '%possibleTypes%'>
				<div controls %audioData% />
			</span>
		";
		$composedId = self::$id;

		$structure = str_replace("%composedId%", $composedId, $structure);
		$structure = str_replace("%possibleTypes%", $types, $structure);

		$cliqued = \CE\CliquedIt::getInstance();

		//Gets the text data
		ob_start();
		$cliqued->audio()->render( $composedId );
		$audioData = ob_get_contents();
		ob_end_clean();

		$structure = str_replace("%audioData%", $audioData, $structure);

		echo $structure;

	}

	private function printNone($types){
		$structure = "
			<span data-ce-composed = '%composedId%' data-ce-composedval= '%possibleTypes%'>
				<strong data-ce-none> **Elemento Oculto. Solo visible por el editor** </strong>
			</span>
		";
		$composedId = self::$id;

		$structure = str_replace("%composedId%", $composedId, $structure);
		$structure = str_replace("%possibleTypes%", $types, $structure);

		echo $structure;
	}

	//Instancia de Singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new composed();
        }

        return self::$instance;
    }

	private static $id;
	private static $instance = NULL;

}

?>