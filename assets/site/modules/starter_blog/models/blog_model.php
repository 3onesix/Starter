<?php

class Blog extends My_Model {
	
	function init()
	{
		$this->tablename('starter_blogs');
		$this->has_many('articles');
	}
	
}