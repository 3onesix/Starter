<?php

class File_Variable extends Starter_Variable {
	
	function file_link()
	{
		$file_variable = null;
		if ($this->index === null)
		{
			$file_variable = $this->CI->page_variable_model->first(array('page_id' => $this->page_id, 'name' => $this->variable->name, 'page_variable_id' => null));
			return $file_variable && $file_variable->file_file_name ? $file_variable->file->url() : null;
		}
		elseif ($this->parent)
		{
			$page_var = $this->CI->page_model->variable($this->parent->name, null, $this->page_id);
			
			if ($page_var && isset($page_var[$this->index][$this->variable->name]))
			{
				$file_variable = $page_var[$this->index][$this->variable->name];
				return $file_variable->url();
			}
			$file_variable = null;
		}
		return $file_variable;
	}
	
	function render()
	{
		$value = $this->value();
		$id = url_title($this->fieldname, 'underscore', true).'_field';
		
		$file_variable = $this->file_link();
		
		return '<div class="field"><label for="'.$id.'">'.$this->variable->label.':</label><input type="hidden" name="'.$this->fieldname.'" value="1"/><input type="file" name="'.$this->fieldname.'" id="'.$id.'" />'.($file_variable !== null && $file_variable ? '<a href="'.$file_variable.'" class="view_file">View File</a>' : '').'</div>';
	}
	
	function file_info()
	{
		$file_variables = value_for_key('variables', $_FILES, array());
		
		if ($this->parent)
		{
			$filename = value_for_key("name.{$this->parent->name}.{$this->index}.{$this->variable->name}", $file_variables);
			$type = value_for_key("type.{$this->parent->name}.{$this->index}.{$this->variable->name}", $file_variables);
			$tmp_name = value_for_key("tmp_name.{$this->parent->name}.{$this->index}.{$this->variable->name}", $file_variables);
			$size = value_for_key("size.{$this->parent->name}.{$this->index}.{$this->variable->name}", $file_variables);
			$error = value_for_key("error.{$this->parent->name}.{$this->index}.{$this->variable->name}", $file_variables);
		}
		else
		{
			$filename = value_for_key("name.{$this->variable->name}", $file_variables);
			$type = value_for_key("type.{$this->variable->name}", $file_variables);
			$tmp_name = value_for_key("tmp_name.{$this->variable->name}", $file_variables);
			$size = value_for_key("size.{$this->variable->name}", $file_variables);
			$error = value_for_key("error.{$this->variable->name}", $file_variables);
		}
		return (object) array(
			'filename' => $filename,
			'type' => $type,
			'tmp_name' => $tmp_name,
			'size' => $size,
			'error' => $error
		);
	}
	
	function load()
	{
		//get page variable
		$page_variable = $this->page_variable();
		if ($page_variable)
		{
			return $page_variable->file;
		}
		return null;
	}
	
	function save()
	{
		//get page variable and template
		$v  = $this->page_variable();
		$tv = $this->variable;
		
		$variable = value_for_key($this->variable->name, $this->CI->input->post('variables'));
		
		if ($v) //variable exists for page, so let's update it
		{
			$hasChanged = false;
			
			$file = $this->file_info();
			
			if ($file->filename)
			{
				$hasChanged = true;
				
				$info   = pathinfo($file->filename);
				$ext 	= value_for_key('extension', $info);
																		
				# Create file cache instance;
				$v->set_file_attachment('file', $ext, $file->type, $file->tmp_name, $file->error, $file->size);
			}
			
			if ($v->value != $variable) //variable has been updated
			{
				$v->value = $variable;
				
				$hasChanged = true;
			}
			if ($tv->label != $v->label || $tv->type != $v->type) //template has been updated
			{
				$v->label = $tv->label;
				$v->type  = $tv->type;
				
				$hasChanged = true;
			}
			if ($hasChanged)
			{
				$v->save();
			}
		}
		else //variable needs to be created
		{
			$v = $this->CI->page_variable_model->create(array(
			    'page_id' => $this->page_id,
			    'name'    => $tv->name,
			    'value'   => $variable,
			    'label'   => $tv->label,
			    'type'    => $tv->type,
			    'array_index' => $this->index,
			    'page_variable_id' 	=> $this->parent ? $this->parent->id : null
			));
			
			$file = $this->file_info();
			
			if ($file->filename)
			{								
				$info   = pathinfo($file->filename);
				$ext 	= value_for_key('extension', $info);
																		
				# Create file cache instance;
				$v->set_file_attachment('file', $ext, $file->type, $file->tmp_name, $file->error, $file->size);
				$v->save();
			}
		}
	}
	
}