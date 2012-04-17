<?php

require('assets/app/variables/markdown.php');

class Markdown_Variable extends Starter_Variable {
	
	function render()
	{
		$value = $this->value();
		
		return '<div class="field"><label for="'.url_title($this->fieldname, 'underscore', true).'_field">'.$this->variable->label.':</label><textarea name="'.$this->fieldname.'" id="'.url_title($this->fieldname, 'underscore', true).'_field">'.$value.'</textarea></div>';
	}
	
	function load()
	{
		//get page variable
		$page_variable = $this->page_variable();
		if ($page_variable)
		{
			return Markdown($page_variable->value);
		}
		return null;
	}
	
	protected function value()
	{
		$page_variable = $this->page_variable();
		return value_for_key('value', $page_variable);
	}
	
}