<?php

class Page_Module_Model extends My_Model
{
	public function init()
	{
		$this->belongs_to('page');
	}
}