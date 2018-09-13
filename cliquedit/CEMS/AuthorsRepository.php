<?php 
/**
* 
*/
require_once dirname(__FILE__).'/Requests.php';
require_once dirname(__FILE__).'/Author.php';
require_once dirname(__FILE__).'/Post.php';

class Authors
{
	
	function __construct($domain, $api_key)
	{
		$this->domain = $domain;
		$this->api_key = $api_key;
	}

	public function all( $getData = null ){

		$authors = array();
		$jsonData = json_decode(Requests::get('authors', $this->api_key, $this->domain, $getData ), true);
		
		foreach ( $jsonData as $data ) {
			array_push($authors, new CEMS_Author($data) );
		}

		return $authors;
	
	}

	//Obtiene un Autor. 
	public function get( $id ){
		
		$jsonData = json_decode(Requests::get( 'authors/'.$id, $this->api_key, $this->domain ), true );
		$author = new CEMS_Author( $jsonData );

		return $author;

	}

	//Obtiene los posts recientes del autor
	public function posts( $id, $getData = null ){

		$posts = array();
		$jsonData = json_decode( Requests::get('authors/posts/'.$id, $this->api_key, $this->domain, $getData ), true);
		
		foreach ( $jsonData as $data ) {
			array_push($posts, new CEMS_Post($data) );
		}

		return $posts;
	
	}

	private $domain;
	private $api_key;
}

?>