<?php

class Template_Variable_Model extends My_Model
{
	public function init()
	{
		$this->enable_actions = false;

		$this->belongs_to('template');
		$this->has_many('template_variables');
	}
}