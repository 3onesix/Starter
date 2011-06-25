<?php

class Setting_Model extends My_Model
{
	public function init()
	{
		$this->validates('key', 'required');
	}
}

if ( ! function_exists('setting') )
{
	function setting()
	{
		$args = func_get_args();
		$CI =& get_instance();
		
		if ( count($args) == 2 )
		{
			list($key, $value) = $args;

			if ( $setting = $CI->setting_model->first(array('key'=>$key)) )
			{
				$setting->update_attribute('value', $value);
			}
			else
			{
				$CI->setting_model->create(array('key'=>$key, 'value' => $value));
			}
		}
		else if ( count($args) == 1)
		{
			list($key) = $args;
			
			$setting = $CI->setting_model->first(array('key'=>$key));
			
			if ( $setting )
			{
				return $setting->value;
			}
			
			return NULL;
		}
		
		return NULL;
	}
}
