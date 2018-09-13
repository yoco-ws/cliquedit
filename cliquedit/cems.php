<?php 

/**
* 
*/
require('CEMS/PostRepository.php');
require('CEMS/CategoriesRepository.php');
require('CEMS/AuthorsRepository.php');

class CEMS
{
	
	function __construct($domain = null, $api_key = null){
		
		try{
			
			if(!is_null($api_key)){
				$this->api_key = $api_key;
			}else{
				$config = parse_ini_file("config.ini");
				if (!isset($config['api_key'])) 
					throw new \Exception("No se ha definido la API Key en el config.ini ni se ha pasado como parametro cems::construct");
				else
				 	$this->api_key = $config['api_key'];
			}

			if(!is_null( $domain ) )
				$this->domain = $domain;
			else
				$this->domain = $this->removeSubdomainUrl($_SERVER['HTTP_HOST']);
			

		}catch(\Exception $e){
			echo '<strong>Clic Edita Error: '.$data['msg'].'</strong>';
		}

	}

	public function posts(){
		
		return new Posts( $this->domain, $this->api_key );

	}

	public function authors(){
		
		return new Authors( $this->domain, $this->api_key );
	
	}

	public function categories(){
		
		return new Categories( $this->domain, $this->api_key );
	
	}

	private function removeSubdomainUrl($url) {
	    //Fuente: https://stackoverflow.com/questions/2679618/get-domain-name-not-subdomain-in-php
		$url_new = parse_url($url);
		if(isset($url_new['path'])){
			if (strcmp($url_new['path'], 'localhost') == 0 ) {
		   		return $url_new['path'];
		   	}
		}

		if(isset($url_new['host'])){
			if (filter_var($url_new['host'], FILTER_VALIDATE_IP) || strcmp($url_new['host'], 'localhost') == 0 ) {
		   		return $url_new['host'].':'.$url_new['port'];
			}	
		}else{
			$array = explode(".", $url);
			return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
		
		}	
	}

	private $api_key;
	private $domain;

}

?>