<?php 

/**
* 
*/
class CEMS_Category
{
	
	function __construct($data)
	{
		foreach ($data as $key => $value) $this->{$key} = $value;
	}

	public $id;
	public $title;
	public $description;
	public $image;
	public $created_at;

}

?>