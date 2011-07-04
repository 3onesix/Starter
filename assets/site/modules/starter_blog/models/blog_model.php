<?php

class Blog_Model extends My_Model {
	
	function init()
	{
		$this->tablename('starter_blogs');
		
		$this->has_many('articles');
	}
	
}