<?php

class Template_Variable_Model extends My_Model
{
	public function init()
	{
		$this->belongs_to('template');
	}
}