<?php

class API extends MY_Controller {

	function permission_denied()
	{
		header('Content-type: application/json');
		echo json_encode(array('error' => 'Permission denied.'));
	}
	
	function process($model, $method = 'index')
	{
		$this->model_name = $model_name = $model.'_model';
		$this->load->model($model_name);
		
		if (!$this->$model_name->allow_api)
		{
			$this->permission_denied();
			return;
		}
		
		$permissions = array('index', 'show');
		if ($this->current_user) $permissions = array_merge($permissions, array('create', 'update', 'destroy'));
		$permissions = array_merge($permissions, $this->$model_name->api_permissions);
		
		if (!in_array($method, $permissions))
		{
			$this->permission_denied();
			return;
		}
		
		switch ($method)
		{
			case 'index':
				$this->index();
			break;
			case 'show':
				$this->show();
			break;
			case 'create':
				$this->create();
			break;
			case 'update':
				$this->update();
			break;
			case 'destroy':
				$this->destroy();
			break;
		}
	}
	
	function index()
	{
		$model_name = $this->model_name;
		
		$data = array();
		if ($this->input->get('conditions'))
		{
			$data['conditions'] = $this->input->get('conditions');
		}
		if ($this->input->get('page'))
		{
			$data['page'] = $this->input->get('page');
		}
		if ($this->input->get('limit'))
		{
			$data['limit'] = $this->input->get('limit');
		}
		$this->$model_name->api();
		
		header('Content-type: application/json');
		$results = $this->$model_name->find($data);
		echo $results->to_json();
	}
	
	function show()
	{
		$model_name = $this->model_name;
		
		$id = $this->input->get('id');
		if ($id)
		{
			header('Content-type: application/json');
			echo $this->$model_name->find($id)->to_json();
		}
	}
	
	function create()
	{
		$model_name = $this->model_name;
		
		/*$id = $this->input->get('id');
		if ($id)
		{
			header('Content-type: application/json');
			echo $this->$model_name->find($id)->to_json();
		}*/
	}
	
	function update()
	{
		$model_name = $this->model_name;
		
		/*$id = $this->input->get('id');
		if ($id)
		{
			header('Content-type: application/json');
			echo $this->$model_name->find($id)->to_json();
		}*/
	}
	
	function destroy()
	{
		$model_name = $this->model_name;
		
		$id = $this->input->get('id');
		if ($id)
		{
			$this->$model_name->destroy($id);
			
			header('Content-type: application/json');
			echo json_encode(array('message' => 'Item deleted.'));
		}
	}
	
}