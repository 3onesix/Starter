<?php

class Article_Model extends My_Model {
	
	function init()
	{
		$this->tablename('starter_articles');
		
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
		return character_limiter(strip_tags($this->body), $length);
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
	
}