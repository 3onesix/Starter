<?php

class Article extends My_Model {
	
	function init()
	{
		$this->tablename('starter_articles');
		$this->belongs_to('blog');
	}
	
	function date($format)
	{
		return date($format, $this->created_at);
	}
	
	function get_formatted_body()
	{
		$this->formatted_body = $this->mkdn->translate($this->body);
		return $this->formatted_body;
	}
	
	function get_url()
	{
		$this->url = $this->blog->url.'/'.$this->date('Y/m/').$this->slug;
		return $this->url;
	}
	
}