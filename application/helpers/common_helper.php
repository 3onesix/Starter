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
	
	function pagination($pages, $page = 1)
	{
		echo '<ul id="pagination">';
		if ($page > 1)
		{
			echo '<li class="previous"><a href="?page='.($page - 1).'">'.($page - 1).'</a></li>';
		}
		for ($i=1; $i<=$page; $i++)
		{
			echo '<li class="page'.($i == $page ? ' current' : '').'"><a href="?page='.$i.'">'.$i.'</a></li>';
		}
		if ($page < $pages)
		{
			echo '<li class="next"><a href="?page='.($page + 1).'">'.($page + 1).'</a></li>';
		}
		echo '</ul>';
	}
	
}