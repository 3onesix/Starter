<?php

class Image_Variable extends Starter_Variable {
	
	function render()
	{
		$value = $this->value();
		$id = url_title($this->fieldname, 'underscore', true).'_field';

		$this->variable->options = is_array($this->variable->options) ? $this->variable->options : unserialize($this->variable->options);
		$image = $this->image();

		$destroy_url = $image ? site_url('admin/images/destroy/'.$image->id) : NULL;
		
		$html  = '<div class="field"><label for="'.$id.'">'.$this->variable->label.':</label>';
		
		
		$html .= '<input type="file" name="'.$this->fieldname.'" id="'.$id.'" class="image-manager" data-width="'.$this->variable->options['width'].'" data-height="'.$this->variable->options['height'].'" data-destroy-url="'.$destroy_url.'" />';
		
		if ($image) $html .= '<img src="'.$image->url.'" />';
		
		$html .= '</div>'."\n";
		
		return $html;
	}
	
	function load()
	{
		return $this->image();
	}
	
	function image()
	{	
		$page_variable = $this->page_variable();
		if ($page_variable)
		{
			$CI =& get_instance();
			$CI->load->model('image_model');
			return $CI->image_model->first($page_variable->value);
		} 
		
		return null;
	}	
}