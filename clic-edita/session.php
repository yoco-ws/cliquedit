<?php
namespace CE;

class Session{
	public static function init($API_key){
		\CE\Session::$API_key = $API_key;
		session_start();

	}

	public static function loadEditor($debug=false){
		if(\CE\Session::isEditMode()){
			\CE\Session::initEditResources($debug);
		}else{
			echo '
			<style>
				label[data-ce-image]{
				    line-height: 0;
				    display: block;
				}
			</style>';
		}
	}

	private static function initEditResources($debug){
		
		if(!$debug){
			echo '<script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>';
			echo '<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">';
			echo '<link rel="stylesheet" href="/css/ce.css">';
			echo '<script type="text/javascript" src="/js/clic-edita.js"></script>';

			echo '
				<script>
	    			var clicEdita = new ClicEdita(
						'.\CE\Session::getKey().',
						"'.$_SERVER['HTTP_HOST'].'",
						"/clic-edita/local_storage.php"
					);
					clicEdita.init();
	    		</script>
			';
		}else{
			echo '
			<script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>
			<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
			<script type="text/javascript" src="/clic-edita/src/client/js/components/audio_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/video_component.js"></script>
			<script type="text/javascript" src="/clic-edita/src/client/js/components/text_component.js"></script>
    		<script type="text/javascript" src="/clic-edita/src/client/js/components/anchor_component.js"></script>
    		<script type="text/javascript" src="/clic-edita/src/client/js/components/image_component.js"></script>
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
						'.\CE\Session::getKey().',
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
		if (isset($_SESSION['editmode'])){
			return true;
		}else{
			return false;
		}
	}

	public static function getKey(){
		return \CE\Session::$API_key;
	}

	private static $API_key;
}

?>