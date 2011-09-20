<?php

class Blog_Model extends My_Model {
	
	function init()
	{
		$this->table_name('starter_blogs');
		
		$this->has_many('articles');
	}
	
}