<?php 

/**
* 
*/
class CEMS_Author
{
	
	function __construct($data)
	{
		foreach ($data as $key => $value) $this->{$key} = $value;
	}

	public $id;
	public $name;
	public $bio;
	public $image;
	public $created_at;

}

?>