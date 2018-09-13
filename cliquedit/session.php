<?php
namespace CE;
/*La clase sesion controla los modos de edicion de CE e importa los archivos necesarios para su funcionalidad
en caso de tener una sesion abierta. Tambien identifica al cliente por medio de la api key*/

class session{
	public static function apiKey($API_key = false){
		try{
			if($API_key === false){
				$config = parse_ini_file("config.ini");
				if (!isset($config['api_key'])) throw new \Exception("No se ha definido la API Key en el config.ini ni se ha pasado como parametro en session::apiKey");
				else $API_key = $config['api_key'];
			}
			\CE\session::$API_key = $API_key;
			
			if (session_status() == PHP_SESSION_NONE) {
			    session_start();
			}	
		}catch(\Exception $e){
			echo '<strong>Clic Edita Error: '.$data['msg'].'</strong>';
		}
	}

	public static function loadEditor($debug=false){
		

		if(\CE\session::isEditMode()){
			\CE\session::initEditResources($debug);
		}
	}

	private static function initEditResources($debug){
		$config = parse_ini_file('config.ini');


		if(!$debug){
			echo '<script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>';
			echo '<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">';
			echo '<link rel="stylesheet" href="'.$config["install_dir"].'css/ce.css">';
			echo '<script type="text/javascript" src="'.$config["install_dir"].'js/clic-edita.js"></script>';

			echo '
				<script>
	    			var clicEdita = new ClicEdita(
						'.\CE\session::getKey().',
						"'.$_SERVER['HTTP_HOST'].'",
						"'.$config["install_dir"].'local_storage.php"
					);
					clicEdita.init();
	    		</script>
			';
		}else{
			//Development mode
			echo '
			<script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>
			<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
			<script type="text/javascript" src="/clic-edita/src/client/js/components/page_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/composed_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/audio_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/video_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/text_component.js"></script>
    		<script type="text/javascript" src="/clic-edita/src/client/js/components/anchor_component.js"></script>
    		<script type="text/javascript" src="/clic-edita/src/client/js/components/image_component.js"></script>
    		<script type="text/javascript" src="/clic-edita/src/client/js/components/embed_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/sender_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/local_storage_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/article_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/subjects.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/notifications.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/mediator.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/clicEdita.js"></script>
			';
			echo '<link rel="stylesheet" href="/clic-edita/src/client/css/ce.css">';

			echo '
				<script>
	    			var clicEdita = new ClicEdita(
						'.\CE\session::getKey().',
						"'.$_SERVER['HTTP_HOST'].'",
						"/clic-edita/src/client/php/local_storage.php"
					);
					clicEdita.init();
	    		</script>
			';
		}
		
		
	}

	public static function isEditMode(){
		//TODO: Verificar si la sesion esta iniciada
		//Verificar el tiempo de expiracion
		\CE\session::verifyLastSession();
		if (isset($_SESSION['editmode'])){
			return true;
		}else{
			return false;
		}
	}

	private static function verifyLastSession(){
		$expireAfter = 30;

		if(isset($_SESSION['last_action'])){
    
		    //Figure out how many seconds have passed
		    //since the user was last active.
		    $secondsInactive = time() - $_SESSION['last_action'];
		    
		    //Convert our minutes into seconds.
		    $expireAfterSeconds = $expireAfter * 60;
		    
		    //Check to see if they have been inactive for too long.
		    if($secondsInactive >= $expireAfterSeconds){
		        //User has been inactive for too long.
		        //Kill their session.
		        unset($_SESSION['editmode']);
		        unset($_SESSION['last_action']);
		    }
		    
		}

		$_SESSION['last_action'] = time();
	}

	public static function getKey(){
		return \CE\session::$API_key;
	}

	private static $API_key;
}

?>