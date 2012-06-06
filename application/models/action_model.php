<?php

class Action_Model extends MY_Model
{
	public function init()
	{
		$this->belongs_to('actionable', array(
			'polymorphic' => TRUE
		));
	}
}