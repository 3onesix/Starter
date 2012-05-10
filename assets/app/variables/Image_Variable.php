<?php

class Image_Variable extends Starter_Variable {
	
	function render()
	{
		$value = $this->value();
		$id = url_title($this->fieldname, 'underscore', true).'_field';
		
		$this->variable->options = is_array($this->variable->options) ? $this->variable->options : unserialize($this->variable->options);
		
		$html = '<div class="field"><label for="'.$id.'">'.$this->variable->label.':</label><input type="file" name="'.$this->fieldname.'" id="'.$id.'" class="image-manager" data-width="'.$this->variable->options['width'].'" data-height="'.$this->variable->options['height'].'" /></div>';
		$html .= '<script type="text/javascript">'."\n";
		$html .= 'if ($("head script[src*=\'image_manager.js\']").size() == 0) {'."\n";
		$html .= '$.getScript("/assets/app/js/image_manager.js")'."\n";
		$html .= '}'."\n";
		$html .= '</script>'."\n";
		return $html;
	}
	
}