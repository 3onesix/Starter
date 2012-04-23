<?php

if ( ! function_exists('flash_jot') )
{
	function flash_jot($key, $conditions = NULL) {	
		$modelName = strtolower($key).'_model';
		
		if ( $flash = flash($key) )
		{
			return $flash;
		}
		elseif ($conditions)
		{
			$CI =& get_instance();
			
			return $CI->$modelName->first($conditions);
		}
		else
		{				
			return new $modelName;
		}
	}
}

if ( ! function_exists('flash'))
{
	function flash() {
		$args = func_get_args();
		$CI =& get_instance();
		$CI->load->library('session');
			
		if ( count($args) >= 2 )
		{
			list($key, $value) = $args;
			$force = FALSE;
			
			if ( count($args) == 3)
			{
				list($key, $value, $force) = $args;
			}
			else
			{
				list($key, $value) = $args;
			}
			
			if ( $force == TRUE)
			{
				return $CI->session->set_userdata('flash:old:'.$key, $value);
			}
			else
			{
				return $CI->session->set_flashdata($key, $value);
			}
		}
		else
		{
			$key = $args[0];
			
 			return $CI->session->flashdata($key);
		}		
	}
}

if ( ! function_exists('message'))
{
	function message() {
		if ( $flash = flash('notice') )
		{
			$flash = is_array($flash) ? $flash : array($flash);
			return array('type' => 'notice', 'content' => $flash);
		}
		else if ( $flash = flash('error') )
		{
			$flash = is_array($flash) ? $flash : array($flash);
			return array('type' => 'error', 'content'=>$flash);
		}
		
		return NULL;
	}
}
