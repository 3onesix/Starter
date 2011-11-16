<?php

class Array_Variable extends Starter_Variable {
	
	function render()
	{
		if ($page_var = $this->load())
		{
			$count = count($page_var);
		}
		else
		{
			$count = 1;
		}
		$page_variable = $this->CI->page_variable_model->first(array('name' => $this->variable->name, 'page_variable_id' => null, 'page_id' => $this->page_id));
		
		$html  = '<fieldset class="repeatable">';
		$html .= '<legend>'.$this->variable->label.'</legend>';
		
		for ($i=0; $i<$count; $i++)
		{
			$html .= '<div class="repeatable_block" data-name="'.$this->variable->name.'"  data-index="'.$i.'">';
			if ($page_var) $html .= '<input type="hidden" name="variables['.$this->variable->name.']['.$i.'][id]" value="'.($page_variable ? $page_variable->id.'_'.$i : $this->variable->id.'_'.$i).'" class="remove_on_clone" />';
			
			$sub_variables = $this->variable->template_variables->all();
			
			foreach ($sub_variables as $sub_var)
			{
				$name = $this->fieldname.'['.$i.']['.$sub_var->name.']';
				$variableInstance = getVariableObject($sub_var->type, $sub_var, $name, $this->page_id, $page_variable, $i);
				if ($variableInstance)
				{
					$html .= $variableInstance->render();
				}
			}
			$html .= '</div>';
		}
		
		$html .= '</fieldset>';
		
		return $html;
	}
	
	function load()
	{
		//get page variable
		$page_variable = $this->page_variable();
		if ($page_variable)
		{
				$variables = $page_variable->page_variables->all(array('order' => 'array_index'));
				$array = array();
				foreach ($variables as $variable)
				{
					if (!isset($array[$variable->array_index])) $array[$variable->array_index] = array();
					
					$variableInstance = getVariableObject($variable->type, $variable, '', $this->page_id, $this->page_variable(), $variable->array_index);
					
					$array[$variable->array_index][$variable->name] = $variableInstance->load();
				}
				return $array;
		}
		return null;
	}
	
	function save()
	{
		//get page variable and template
		$v  = $this->page_variable();
		$tv = $this->variable;
		
		$variable = $this->post_variable();
		
		if ($v) //variable exists for page, so let's update it
		{
			$hasChanged = false;
			if ($v->value != '') //variable has been updated
			{
				$v->value = '';
				
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
			    'page_id' 			=> $this->page_id,
			    'name'    			=> $tv->name,
			    'value'   			=> '',
			    'label'   			=> $tv->label,
			    'type'    			=> $tv->type
			));
		}
		
		//get all blocks
		$blocks = $this->post_variable();
		
		foreach ($blocks as $index => $block)
		{
			foreach ($block as $key => $variable)
			{
				if ($key != 'id')
				{
					if ($this->page_id != 0)
					{
						$page = $this->CI->page_model->first($this->page_id);
						$tv = $page->template->template_variables->first(array('name' => $key, 'template_variable_id' => $this->variable->id));
					}
					else
					{
						$tv = $this->CI->template_variable_model->first(array('name' => $key, 'template_id' => 0, 'template_variable_id' => $this->variable->id));
					}
					
					$variableInstance = getVariableObject($tv->type, $tv, 'variables['.$this->variable->name.']['.$index.']['.$tv->name.']', $this->page_id, $v, $index);
					if ($variableInstance)
					{
						$variableInstance->page_variable = false;
						if (isset($block['id']) && $block['id'])
						{
							$id = explode('_', $block['id']);
							$variableInstance->page_variable = $this->CI->page_variable_model->first(array(
								'page_id' => $this->page_id,
								'name' => $this->variable->name,
								'page_variable_id' => $id[0],
								'array_index' => $id[1]
							));
						}
						$variableInstance->save();
					}
				}
			}
		}
	}
	
}