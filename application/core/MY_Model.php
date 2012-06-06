<?php

require_once APPPATH."third_party/jot/jot.php";

class MY_Model extends JotRecord 
{
	protected $enable_actions = true;
	
	public function __construct($attributes = array(), $options = array())
	{
		$record = parent::__construct($attributes, $options);
		
		$this->after_create('_action_create');
		$this->after_update('_action_update');
		$this->after_destroy('_action_destroy');
		
		return $record;
	}
	
	protected function _action_create()
	{
		$this->_send_action('create');
	}
	
	protected function _action_update()
	{
		$this->_send_action('update');
	}
	
	protected function _action_destroy()
	{
		$this->_send_action('destroy');
	}
	
	protected function _can_send_action()
	{
		return $this->enable_actions;
	}
	
	protected function _send_action($type)
	{
		if ( $this->table_name() != 'actions' && $this->_can_send_action() )
		{
			$this->load->model('action_model');
			
			$CI =& get_instance();	
			$CI->load->library('input');	
						
			$action = new Action_Model;
			$action->type = $type;
			$action->user_id = $CI->current_user->user_id;
			$action->ip_address = $this->input->ip_address();
			$action->user_agent = $this->input->user_agent();
			$action->actionable = $this;
			$action->save();
		}
	}
}