<?php
/*Gestiona el almacenamiento de la informacion multimedia en el servidor de cliente*/

if(isset($_FILES["ce-image"]["type"])){
	
	$validextensions = array("jpeg", "jpg", "png", "svg", "gif");
	$temporary = explode(".", $_FILES["ce-image"]["name"]);
	$file_extension = end($temporary);

	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	$config = parse_ini_file('config.ini');

	$path = $_SERVER["DOCUMENT_ROOT"].$config['media_dir'].'img/';
	$path_url= $root.$config['media_dir'].'img/';
	
	if($_GET['subdir'] != ''){
		$path.= $_GET['subdir'].'/';
		$path_url.= $_GET['subdir'].'/';
	}

	if (!is_dir($path)) {
    	mkdir($path, 0777, true);
	}
	
	if (
			(
				($_FILES["ce-image"]["type"] == "image/png") || ($_FILES["ce-image"]["type"] == "image/jpg") || ($_FILES["ce-image"]["type"] == "image/jpeg")  || ($_FILES["ce-image"]["type"] == "image/svg+xml")  || ($_FILES["ce-image"]["type"] == "image/gif")
			) 
		&& 	($_FILES["ce-image"]["size"] < 4000000)//Approx. 100Mb files can be uploaded.
		&& in_array($file_extension, $validextensions)
	) {
		if ($_FILES["ce-image"]["error"] > 0) {
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			
			header('HTTP/1.1 400 Internal Server Error');
			header('Content-Type: application/json; charset=UTF-8');
			die(json_encode(array("msg"=>$_FILES["ce-image"]["error"])));

		}
		else{
			//Garantizar que la imagen sea unica
			$fileInfo = pathinfo($_FILES["ce-image"]["name"]);
			$uniqueName = uniqid().'.'.$fileInfo["extension"];

			if (file_exists($path . $uniqueName)) {
				
				header('HTTP/1.1 400 Internal Server Error');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode(array("msg"=>$uniqueName . " ya existe. ")));

			}else{
				$sourcePath = $_FILES['ce-image']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $path.$uniqueName; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				
				$statusMessage = "Imagen almacenada exitosamente.\n";
				$statusMessage.= "Nombre de archivo: " . $uniqueName . "\n";
				$statusMessage.= "Tamaño:" . ($_FILES["ce-image"]["size"] / 1024) . " kB\n";

				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode(array("msg"=>$statusMessage, "path"=>$path_url.$uniqueName));
			}
		}
	}else{
		header('HTTP/1.1 400 Internal Server Error');
		header('Content-Type: application/json; charset=UTF-8');
		die(json_encode(array("msg"=>"Tipo o tamaño de imagen inválido")));
	}
}elseif(isset($_FILES["ce-audio"]["type"])){
	
	//Cambiar audio
	$validextensions = array("mp3", "ogg", "wav");
	$temporary = explode(".", $_FILES["ce-audio"]["name"]);
	$file_extension = end($temporary);

	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	
	$config = parse_ini_file('config.ini');

	$path = $_SERVER["DOCUMENT_ROOT"].$config['media_dir'].'audio/';
	$path_url= $root.$config['media_dir'].'audio/';
	
	if($_GET['subdir'] != ''){
		$path.= $_GET['subdir'].'/';
		$path_url.= $_GET['subdir'].'/';
	}

	if (!is_dir($path)) {
    	mkdir($path, 0777, true);
	}
	
	if (
			(
				($_FILES["ce-audio"]["type"] == "audio/mp3") || ($_FILES["ce-audio"]["type"] == "audio/ogg") || ($_FILES["ce-audio"]["type"] == "audio/wav")
			) 
		&& 	($_FILES["ce-audio"]["size"] < 40000000)//Approx. 100Mb files can be uploaded.
		&& in_array($file_extension, $validextensions)
	) {
		if ($_FILES["ce-audio"]["error"] > 0) {
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			
			header('HTTP/1.1 400 Internal Server Error');
			header('Content-Type: application/json; charset=UTF-8');
			die(json_encode(array("msg"=>$_FILES["ce-audio"]["error"])));

		}
		else{
			//Garantizar que la imagen sea unica
			$fileInfo = pathinfo($_FILES["ce-audio"]["name"]);
			$uniqueName = uniqid().'.'.$fileInfo["extension"];

			if (file_exists($path . $uniqueName)) {
				
				header('HTTP/1.1 400 Internal Server Error');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode(array("msg"=>$uniqueName . " ya existe. ")));

			}else{
				$sourcePath = $_FILES['ce-audio']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $path.$uniqueName; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				
				$statusMessage = "Audio almacenado exitosamente.\n";
				$statusMessage.= "Nombre de archivo: " . $uniqueName . "\n";
				$statusMessage.= "Tamaño:" . ($_FILES["ce-audio"]["size"] / 1024) . " kB\n";

				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode(array("msg"=>$statusMessage, "path"=>$path_url.$uniqueName));
			}
		}
	}else{
		header('HTTP/1.1 400 Internal Server Error');
		header('Content-Type: application/json; charset=UTF-8');
		die(json_encode(array("msg"=>"Tipo o tamaño de audio inválido")));
	}

}elseif(isset($_FILES["ce-video"]["type"])){
	
	//Cambiar audio
	$validextensions = array("mp4", "ogg", "wav");
	$temporary = explode(".", $_FILES["ce-video"]["name"]);
	$file_extension = end($temporary);

	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	
	$config = parse_ini_file('config.ini');

	$path = $_SERVER["DOCUMENT_ROOT"].$config['media_dir'].'img/video';
	$path_url= $root.$config['media_dir'].'img/video';
	
	if($_GET['subdir'] != ''){
		$path.= $_GET['subdir'].'/';
		$path_url.= $_GET['subdir'].'/';
	}

	if (!is_dir($path)) {
    	mkdir($path, 0777, true);
	}
	
	if (
			(
				($_FILES["ce-video"]["type"] == "video/mp4") || ($_FILES["ce-video"]["type"] == "video/ogg") || ($_FILES["ce-video"]["type"] == "video/wav")
			) 
		&& 	($_FILES["ce-video"]["size"] < 40000000)//Approx. 100Mb files can be uploaded.
		&& in_array($file_extension, $validextensions)
	) {
		if ($_FILES["ce-video"]["error"] > 0) {
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			
			header('HTTP/1.1 400 Internal Server Error');
			header('Content-Type: application/json; charset=UTF-8');
			die(json_encode(array("msg"=>$_FILES["ce-video"]["error"])));

		}
		else{
			//Garantizar que la imagen sea unica
			$fileInfo = pathinfo($_FILES["ce-video"]["name"]);
			$uniqueName = uniqid().'.'.$fileInfo["extension"];

			if (file_exists($path . $uniqueName)) {
				
				header('HTTP/1.1 400 Internal Server Error');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode(array("msg"=>$uniqueName . " ya existe. ")));

			}else{
				$sourcePath = $_FILES['ce-video']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $path.$uniqueName; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				
				$statusMessage = "Audio almacenado exitosamente.\n";
				$statusMessage.= "Nombre de archivo: " . $uniqueName . "\n";
				$statusMessage.= "Tamaño:" . ($_FILES["ce-video"]["size"] / 1024) . " kB\n";

				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode(array("msg"=>$statusMessage, "path"=>$path_url.$uniqueName));
			}
		}
	}else{
		header('HTTP/1.1 400 Internal Server Error');
		header('Content-Type: application/json; charset=UTF-8');
		die(json_encode(array("msg"=>"Tipo o tamaño de video inválido")));
	}

}

else{
	header('HTTP/1.1 400 Internal Server Error');
	header('Content-Type: application/json; charset=UTF-8');
	die(json_encode(array("msg"=>"No se reconoció el archivo")));
}

?>