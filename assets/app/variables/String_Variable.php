<?php

class String_Variable extends Starter_Variable {
	
	function render()
	{
		if (!$this->variable->options)
		{
			return parent::render();
		}
		else
		{
			$value = $this->value();
			$id = url_title($this->fieldname, 'underscore', true).'_field';
			
			$this->variable->options = is_array($this->variable->options) ? $this->variable->options : unserialize($this->variable->options);
			
			$html = '<div class="field"><label for="'.$id.'">'.$this->variable->label.':</label><select name="'.$this->fieldname.'" id="'.$id.'">';
			
			foreach ($this->variable->options as $option)
			{
				$html .= '<option value="'.$option.'"'.($value && $value == $option ? ' selected="selected"' : '').'>'.$option.'</option>';
			}
			
			$html .= '</select></div>';
			return $html;
		}
	}
	
}