<?php

class HTML_Variable extends Starter_Variable {
	
	function render()
	{
		$value = $this->value();
		
		return '<div class="field"><label for="'.url_title($this->fieldname, 'underscore', true).'_field">'.$this->variable->label.':</label><textarea name="'.$this->fieldname.'" id="'.url_title($this->fieldname, 'underscore', true).'_field" class="wysiwyg">'.$value.'</textarea></div>';
	}
	
}