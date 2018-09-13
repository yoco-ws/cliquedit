<?php
namespace CE;
/*Una categoria es una coleccion de articulos relacionados*/
class category{
	
	/*
	El metodo id de category puede recibir un parametro opcional 'fullarticle' que indica
	que dentro de esa categoria solo se mostrará un articulo con todos los elementos individuales
	como los metas
	*/
	public function start($id = false, $params = false){
		if(!$id){
			echo "data-ce-category=$id";	
		}else{
			self::$id = $id;

			echo "data-ce-category=$id";
			if(isset($params['itemAsPage'])) echo " data-ce-single-article";	
		}
		
		
	}

	public function getId(){
		return self::$id;
	}

	/*
	Imprime la paginacion de una categoria
	parametros:
	count: la cantidad de articulos por pagina
	adjacents: la cantidad de paginas maximas a mostrar 
	pageAlias: el nombre del parametro GET de la paginacion Ej: ?numeroPagina=3 debe coincidir con el alias
	pasado en page::load
	*/
	public function paginate($params){
		$articleCount = self::$instance->countArticles();
		try{
			if(!isset($params['count']) || !isset($params['adjacents']) || !isset($params['pageAlias'])){
				throw new \Exception("category::pagination requiere los parametros [count, adjacents, pageAlias]");
				
			}
			$perPage = $params['count'];
			$currentPage = 1;
			if(isset($_GET[$params['pageAlias']])){
				$currentPage = $_GET[$params['pageAlias']];
			}
			
			$adjacents = $params['adjacents'];
			$pages = self::$instance->getPagination($articleCount, $perPage, $currentPage, $adjacents);
			
			//Si se requiere mas de una pagina, si no, no es necesaria la paginacion
			if(count($pages) > 1){
				$pageList = '';
				foreach ($pages as $page) {
					if($page == $currentPage) $pageList.= '<li class="page-item active"><a class="page-link" href="'.self::$instance->pagehref($page, $params).'">'.$page.'</a></li>';
					else $pageList.= '<li class="page-item"><a class="page-link" href="'.self::$instance->pagehref($page, $params).'">'.$page.'</a></li>';
				}
				
				$previous = $currentPage - 1;
				if($previous <= $pages[0])
					$previous = $pages[0];

				$next = $currentPage + 1;
				if($next >= end($pages))
					$next = end($pages);


				$structure_top = '
				<nav aria-label="Page navigation example">
				  <ul class="pagination">
				    <li class="page-item"><a class="page-link" href="'.self::$instance->pagehref($previous, $params).'">Previous</a></li>
				';
				$structure_bottom = '
					<li class="page-item"><a class="page-link" href="'.self::$instance->pagehref($next, $params).'">Next</a></li>
					  </ul>
					</nav>
				';

				echo $structure_top.$pageList.$structure_bottom;
			}
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}
		
		

	}

	public function fullPagePath( $params = false ){
		\CE\article::fullPagePath( $params );
	}

	public function item( $id = false ){
		\CE\article::id($id);
	}

	public function render( $params ){
		\CE\article::renderLanding($params);
	}

	public function metas( $CollectionItem ){
		
		if( isset( \CE\Loader::getArticleMetas($CollectionItem[0], $CollectionItem[1])['titulo'] ) ){
			echo "<title>".\CE\Loader::getArticleMetas($CollectionItem[0], $CollectionItem[1])['titulo']."</title>";
		}else{
			echo '<title> New Item </title>';
		}

		\CE\article::metas($CollectionItem);
	}

	/*Metodo auxiliar para obtener un arreglo con las paginas a mostrar*/
	private function getPagination($data, $limit, $current, $adjacents){
		$result = array();

	    if (isset($data, $limit) === true)
	    {
	        $result = range(1, ceil($data / $limit));

	        if (isset($current, $adjacents) === true)
	        {
	            if (($adjacents = floor($adjacents / 2) * 2 + 1) >= 1)
	            {
	                $result = array_slice($result, max(0, min(count($result) - $adjacents, intval($current) - ceil($adjacents / 2))), $adjacents);
	            }
	        }
	    }

	    return $result;
	}

	

	private function pageHref($pageNumber, $params){
		if(isset($params['friendlyUrl'])){
			//imprimir como url amigable
			if(isset($params['pageAlias'])) return $params['pageAlias'].'/'.$pageNumber;
			else return 'page/'.$pageNumber;
		}else{
			if(isset($params['pageAlias'])) return '?'.$params['pageAlias'].'='.$pageNumber;
			else return '?page='.$pageNumber;
		}
	}

	//Cuenta los articulos obtenidos en el query inicial
	private function countArticles(){
		try{
			return \CE\loader::getCategoryTotal(self::$id);	
		}catch(\Exception $e){
			echo '<p>Error: ', $e->getMessage(), '</p>';
		}
		
	}



	//Instancia de Singleton 
    public static function getInstance(){

        if (is_null(self::$instance)) {
            self::$instance = new category();
        }

        return self::$instance;
    }

	private static $id;
	private static $articleCount;
	private static $instance = NULL;

}

?>