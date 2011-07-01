<?php

class My_Router extends CI_Router
{	
	function validate_controller($segments, $options = array())
	{
		$all_segments = $segments;
		$segment = array_shift($segments);

		if ( is_dir($options['path'].$segment.'/') )
		{
			$options['path'] .= $segment.'/';

			if ( count($segments) )
			{
				$options['sub_folders'][] = $segment;

				return $this->validate_controller($segments, $options);
			}
			else
			{
				return $options;
			}
		}
		else if ( file_exists($options['path'].$segment.EXT) )
		{

			$options['path'] .= $segment.EXT;
			$options['segments'] = $all_segments;

			return $options;
		}


		return $options;
	}
	
	function controller_paths()
	{
		$paths = array(APPPATH);
		
		foreach(config_item('packages') as $package)
		{
			$paths[] = rtrim($package, '/').'/';
		}
		
		return $paths;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Validates the supplied segments.  Attempts to determine the path to
	 * the controller.
	 *
	 * @access	private
	 * @param	array
	 * @return	array
	 */
	function _validate_request($segments)
	{
		if (count($segments) == 0)
		{
			return $segments;
		}

		// Is first segment a controller?
		$paths = $this->controller_paths();
		
		// Default Relative Path
		$relative_path  = '';
		
		foreach($paths as $path)
		{
			if ( APPPATH != $path)
			{
				$name = array_pop(explode('/', rtrim($path, '/')));				
				$relative_path = "../../modules/{$name}/controllers/";
			}
			
			$options = array(
				'path' => $path.'controllers/',
				'segments' => array(),
				'sub_folders' => array(),
			);

			$options = $this->validate_controller($segments, $options);
			
			$path = $options['path'];

			$new_segments = $options['segments'];

			if ( file_exists($path) && ! is_dir($path) )
			{
				$this->directory = $relative_path.implode('/', $options['sub_folders']).'/';
						
				return $new_segments;
			}
		}

		// If we've gotten this far it means that the URI does not correlate to a valid
		// controller class.  We will now see if there is an override
		if ( ! empty($this->routes['404_override']))
		{
			$x = explode('/', $this->routes['404_override']);

			$this->set_class($x[0]);
			$this->set_method(isset($x[1]) ? $x[1] : 'index');

			return $x;
		}
		

		// Nothing else to do at this point but show a 404
		show_404($segments[0]);
	}
}