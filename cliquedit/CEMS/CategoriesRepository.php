<?php 
/**
* 
*/

require_once dirname(__FILE__).'/Requests.php';
require_once dirname(__FILE__).'/Category.php';

class Categories
{
	
	function __construct($domain, $api_key)
	{
		$this->domain = $domain;
		$this->api_key = $api_key;
	}

	public function all( $getData = null ){

		$categories = array();
		$jsonData = json_decode(Requests::get('categories', $this->api_key, $this->domain, $getData ), true);
		
		foreach ( $jsonData as $data ) {
			array_push($categories, new CEMS_Category($data) );
		}

		return $categories;
	
	}

	//Obtiene una categoria. 
	public function get( $id ){
		
		$jsonData = json_decode(Requests::get( 'categories/'.$id, $this->api_key, $this->domain ), true );
		$category = new CEMS_Category( $jsonData );

		return $category;

	}

	//Obtiene los posts recientes de una categoria
	public function posts( $id ){

		$categories = array();
		$jsonData = json_decode(Requests::get('categories/posts/'.$id, $this->api_key, $this->domain ), true);
		
		foreach ( $jsonData as $data ) {
			array_push($categories, new CEMS_Category($data) );
		}

		return $categories;
	
	}

	private $domain;
	private $api_key;
}

?>