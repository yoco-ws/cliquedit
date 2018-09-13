<?php 
/**
* 
*/
require_once dirname(__FILE__).'/Requests.php';
require_once dirname(__FILE__).'/Post.php';

class Posts
{
	
	function __construct($domain, $api_key)
	{
		$this->domain = $domain;
		$this->api_key = $api_key;
	}

	//Obtiene una coleccion de Posts. Opcionalmente se pueden pasar filtros
	public function all( $getData = null ){

		$posts = array();
		$jsonData = json_decode(Requests::get('posts', $this->api_key, $this->domain, $getData ), true);
		
		foreach ( $jsonData as $data ) {
			array_push($posts, new CEMS_Post($data) );
		}

		return $posts;
	
	}

	//Obtiene un Post. 
	public function get( $id ){
		
		$jsonData = json_decode(Requests::get( 'posts/'.$id, $this->api_key, $this->domain ), true );
		
		$post = null;
		if(!is_null($jsonData)) $post = new CEMS_Post( $jsonData );

		return $post;

	}

	//Obtiene una coleccion de hasta dos Posts, el anterior y el siguiente
	public function adjacents( $id, $getData = null ){

		$jsonData = json_decode( Requests::get( 'posts/adjacents/'.$id, $this->api_key, $this->domain, $getData ) );
		$adjacents = array();
		foreach ( $jsonData as $key => $data ) {
			$adjacents[$key] = new CEMS_Post($data);
		}

		return $adjacents;
	}

	//Obtiene una coleccion de posts basados en las categorias del objeto post
	public function related( $id, $getData = null ){
		
		$posts = array();
		$jsonData = json_decode(Requests::get('posts/related/'.$id, $this->api_key, $this->domain, $getData), true);
		
		foreach ( $jsonData as $data ) {
			array_push($posts, new CEMS_Post($data) );
		}

		return $posts;
	}

	//Obtiene la paginacion de un conjunto de posts, ya sea con o sin filtros
	public function links( $getData = null ){
		
		$jsonData = json_decode(Requests::get('pagination', $this->api_key, $this->domain, $getData), true);
		
		return $jsonData;
	}

	private $domain;
	private $api_key;
}

?>