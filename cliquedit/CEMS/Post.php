<?php 

/**
* 
*/
class CEMS_Post
{
	
	function __construct($data)
	{
		foreach ($data as $key => $value) $this->{$key} = $value;
	}

	public $id;
	public $title;
	public $author;
	public $categories;
	public $body;
	public $introduction;
	public $image;
	public $thumbnail;
	public $metas;
	public $created_at;

}

?>