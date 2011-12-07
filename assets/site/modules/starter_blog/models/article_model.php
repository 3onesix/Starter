<?php

class Article_Model extends My_Model {
	
	function init()
	{
		$this->table_name('starter_articles');
		
		$this->belongs_to('blog');
		$this->belongs_to('user');
		
		$this->validates('subject', 'required');
		$this->validates('slug', 'required');
		$this->validates('user_id', 'required');
		$this->validates('blog_id', 'required');
		
		$this->before_validation('generate_slug');
	}
	
	public function generate_slug()
	{
		if ( ! $this->read_attribute('slug') )
		{
			$this->set_slug('slug', $this->read_attribute('subject'));
		}
	}
	
	public function set_slug($key, $value)
	{
		$this->write_attribute($key, strtolower(url_title($value)));
	}
	
	function date($format)
	{
		return date($format, $this->created_at);
	}
	
	function get_formatted_body()
	{
		$this->load->library('mkdn');
		return $this->mkdn->translate($this->body);
	}
	
	function get_url()
	{
		return $this->blog->url.'/'.$this->date('Y').'/'.$this->date('m').'/'.$this->slug;
	}
	
	function get_snippet($length = 140)
	{
		$this->load->helper('text');
		return character_limiter(strip_tags($this->formatted_body), $length);
	}
	
	function find_with_url($blog, $year, $month, $slug)
	{
		if ($blog)
		{
			$article = $blog->articles->first(array('slug' => $slug));
			if ($article)
			{
				if ($article->date('Y') != $year || $article->date('m') != $month)
				{
					$article = null;
				}
			}
			
			if ($article)
			{
				return $article;
			}
			else
			{
				return null;
			}
		}
		else {
			return null;
		}
	}
	
	function order($by, $dir)
	{
		$this->db->order_by($by, $dir);
		
		return $this;
	}
	
	function get_relative_date()
	{
		$stamp = $this->created_at;
		$now   = time();
		$diff  = abs($now - $stamp);
		
		switch ($diff) {
			case ($diff < 60):
				return $diff.' seconds ago';
			break;
			case ($diff < 3600):
				return floor($diff / 60).' minute'.(floor($diff / 60) != 1 ? 's' : '').' ago';
			break;
			case ($diff < 86400):
				return floor($diff / 3600).' hour'.(floor($diff / 3600) != 1 ? 's' : '').' ago';
			break;
			case ($diff < 604800):
				return floor($diff / 86400).' day'.(floor($diff / 86400) != 1 ? 's' : '').' ago';
			break;
			case ($diff < 2592000):
				return floor($diff / 604800).' week'.(floor($diff / 604800) != 1 ? 's' : '').' ago';
			break;
			default:
				return date('F d, Y', $stamp);
			break;
		}
	}
	
}