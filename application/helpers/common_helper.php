<?php

if ( ! function_exists('time2str') )
{
	function time2str($ts)
	{
		if(!ctype_digit($ts))
			$ts = strtotime($ts);

		$diff = time() - $ts;
		if($diff == 0)
			return 'now';
		elseif($diff > 0)
		{
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 60) return 'just now';
				if($diff < 120) return '1 minute ago';
				if($diff < 3600) return floor($diff / 60) . ' minutes ago';
				if($diff < 7200) return '1 hour ago';
				if($diff < 86400) return floor($diff / 3600) . ' hours ago';
			}
			if($day_diff == 1) return 'Yesterday';
			if($day_diff < 7) return $day_diff . ' days ago';
			if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
			if($day_diff < 60) return 'last month';
			return date('F Y', $ts);
		}
		else
		{
			$diff = abs($diff);
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 120) return 'in a minute';
				if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
				if($diff < 7200) return 'in an hour';
				if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
			}
			if($day_diff == 1) return 'Tomorrow';
			if($day_diff < 4) return date('l', $ts);
			if($day_diff < 7 + (7 - date('w'))) return 'next week';
			if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
			if(date('n', $ts) == date('n') + 1) return 'next month';
			return date('F Y', $ts);
		}
	}
}

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
				
		if ( count($args) == 2 )
		{
			list($key, $value) = $args;
			
			return $CI->session->set_flashdata($key, $value);
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

if ( ! function_exists('pagination'))
{
	
	function pagination($pages)
	{
		$CI =& get_instance();
		$page = $CI->input->get('page');
	
		if ($pages == 1) return false;
		
		echo '<ul id="pagination">';
		if ($page > 1)
		{
			echo '<li class="previous"><a href="?page='.($page - 1).'">&laquo; previous page</a></li>';
		}
		for ($i=1; $i<=$pages; $i++)
		{
			echo '<li class="page'.($i == $page ? ' current' : '').'"><a href="?page='.$i.'">'.$i.'</a></li>';
		}
		if ($page < $pages)
		{
			echo '<li class="next"><a href="?page='.($page + 1).'">next page &raquo;</a></li>';
		}
		echo '</ul>';
	}
	
}

if ( ! function_exists('sidebar_filters') )
{
	
	function sidebar_filters($filters)
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$page_id = md5(current_url());
		$stored_filters = $CI->session->userdata('filters_'.$page_id);
		if (!$stored_filters) $stored_filters = array();
		
		$html = '<form method="post" action="" class="sidebar_filters"><h2>Filters</h2>';
		foreach ($filters as $label => $options)
		{
			$id = url_title('sidebar filters '.$label.' field', 'underscore', true);
			$name = 'sidebar_filters['.url_title($label, 'underscore', true).']';
			$html .= '<label for="'.$id.'">'.$label.'</label><br />';
			
			if ($options !== null)
			{
				$html .= '<select id="'.$id.'" name="'.$name.'">';
				foreach ($options as $value => $option)
				{
					$html .= '<option value="'.$value.'"'.(isset($stored_filters[url_title($label, 'underscore', true)]) && $stored_filters[url_title($label, 'underscore', true)] == $value ? ' selected="selected"' : '').'>'.$option.'</option>';
				}
				$html .= '</select><br />';
			}
			else
			{
				$html .= '<input type="text" id="'.$id.'" name="'.$name.'" value="'.(isset($stored_filters[url_title($label, 'underscore', true)]) ? $stored_filters[url_title($label, 'underscore', true)] : '').'" />';
			}
		}
		$html .= '<input type="submit" value="Submit" /> or <a href="?clear_filters=true">clear</a>';
		$html .= '</form>';
		
		echo $html;
	}
	
	function save_filters()
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$page_id = md5(current_url());
		
		if (isset($_GET['clear_filters']) == 'true')
		{
			$CI->session->unset_userdata('filters_'.$page_id);
			redirect(current_url());
		}
		if (isset($_POST['sidebar_filters']))
		{
			$filters = array();
			foreach ($_POST['sidebar_filters'] as $name => $filter)
			{
				$filters[$name] = $filter;
			}
			$CI->session->set_userdata(array(
				'filters_'.$page_id => $filters
			));
			redirect(current_url());
		}
	}
	
	function get_filter($name)
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$page_id = md5(current_url());
		$stored_filters = $CI->session->userdata('filters_'.$page_id);
		if (!$stored_filters) $stored_filters = array();
		
		if (isset($stored_filters[$name]))
		{
			return $stored_filters[$name];
		}
		return false;
	}
	
	save_filters();
	/*sidebar_filters(array(
		'Order by' => array(
			'created_at' => 'Created Date',
			'updated_at' => 'Updated Date',
			'subject'    => 'Article Title'
		),
		'Order direction' => array(
			'DESC' => 'Descending',
			'ASC'  => 'Ascending'
		),
		'Status' => array(
			'all' => 'All',
			'1'   => 'Published',
			'0'   => 'Unpublished'
		)
	));*/
	
}