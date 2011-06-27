<?php

/* BLAHHHHHH!!!! I hate it, but it works. */
function page_hierarchial_list($pages, $even)
{		
	$CI =& get_instance();

	echo '<ul>';		
				
	foreach($pages as $page)
	{
		$even = !$even;
		
		echo '
		<li class="'.($even == FALSE ? 'odd' : NULL).'">
			<div class="what">'.$page->name.' <span class="slug">('.$page->full_slug.')</span></div>
			<div class="actions">
				<a href="'.site_url($page->full_slug).'" class="view" title="View Page">view</a> 
				<a href="'.site_url('admin/pages/edit/'.$page->id).'" class="edit" title="Edit Page">edit</a> 
				<a href="'.site_url('admin/pages/destroy/'.$page->id).'" class="delete" title="Delete Page">delete</a>
			</div>
		</li>';
		
		if ( $pages = $page->pages->all()  )
		{			
			$CI->db->order_by('name');
			$even = page_hierarchial_list($pages, $even);
		}
	}
	
	echo '</ul>';
	
	return $even;
}

function page_hierarchal_spaces($pages)
{		
	$options = array();
	
	$space = '&nbsp;&nbsp;&nbsp;&nbsp;';
	$first = false;
	
	foreach($pages as $page)
	{
		if ($page->page_id == -1 && $first == false)
		{
		 	$options[-1] = '';
			$first = TRUE;
		}
		
		$options[$page->id] = $page->name;
		
		if ( $pages = $page->pages->all()  )
		{
			$sub_options = page_hierarchal_spaces($page->pages->all());
			
			foreach($sub_options as $key => $value)
			{
				$options[$key] = $space.$value;
			}
		}
	}
	
	return $options;
}