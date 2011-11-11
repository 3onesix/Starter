<?php $this->load->view('admin/_errors', array('errors' => $page->errors()))?>
<div id="page_variables">
	<?php if (!isset($is_site_variables) || $is_site_variables == false): ?>
		<fieldset>
			<legend>Page Info</legend>
			<div class="field" data-help="Many templates use this for the title bar in the browser. My suggestion, keep is short and simple.">
				<?php echo $f->label('name', 'Name:'); ?>
				<?php echo $f->text_field('name'); ?>				
			</div>
			<div class="field" data-help="The slug is a URL safe name for the page, which becomes it&rsquo;s web address. So a page with the slug of &ldquo;about&rdquo; is accessible at <?=site_url('about')?>">
				<?php echo $f->label('slug', 'Slug:'); ?>
				<?php echo $f->text_field('slug'); ?>				
			</div>
			<?php if ($page->page_id > 0): ?>
				<div class="field">
					<label>Parent Page:</label>
					<input type="text" disabled="true" value="<?=$page->page->name?>" />
				</div>
			<?php elseif($page->persisted() == FALSE): ?>
				<div class="field">
					<?php echo $f->label('page_id', 'Parent Page:'); ?>
					<?php echo $f->select('page_id', $parents); ?>
				</div>
			<?php endif; ?>
			<?php if($page->persisted() == FALSE): ?>
				<div class="field">
					<?php print $f->label('template_id', 'Template:'); ?>
					<?php print $f->select('template_id', $templates); ?>
				</div>
			<?php endif; ?>
		</fieldset>
	<?php endif; ?>
	<?php $variables = array(); ?>
	<?php if (($page->template_id && $page->template->template_variables->count()) || (isset($is_site_variables) && $is_site_variables)): ?>
		<fieldset>
			<legend><?=$is_site_variables ? 'Site' : 'Page'?> Variables</legend>
			<?php 
			
			function build_variable($variable, &$page, &$variables, $sub = false, $index = 0, $site_variables = null)
			{
				$CI =& get_instance();
				
				if (!$sub) $variables[] = $variable->name;
				else
				{
					if ($site_variables)
					{
						if ($page_var = $CI->page_model->variable($sub->name, null, 0))
						{
							$page_var = ($page_var);
						}
						else
						{
							$page_var = null;
						}
					}
					else 
					{
						if ($page_var = $page->variable($sub->name))
						{
							$page_var = ($page_var);
						}
						else
						{
							$page_var = null;
						}
					}
				}
				
				if ($variable->type != 'array')
				{
					$name  = 'variables'.($sub ? '['.$sub->name.']['.$index.']' : '').'['.$variable->name.']';
					$id    = 'variables_'.($sub ? $sub->name.'_'.$index.'_' : '').$variable->name.'_field';
					
					if ($site_variables)
					{
						
						if ($sub)
						{
							$page_variable = $CI->page_variable_model->first(array('name' => $sub->name, 'page_variable_id' => null, 'page_id' => 0));
							
							$value = $page_var && isset($page_var[$index][$variable->name]) ? $page_var[$index][$variable->name] : $variable->value;
							
							if ($variable->type == 'file' && $page_variable)
							{
								$file_variable = $CI->page_variable_model->first(array('page_id' => 0, 'name' => $variable->name, 'page_variable_id' => $page_variable->id, 'array_index' => $index));
							}
						}
						else
						{
							$value = $CI->page_variable_model->first(array('name' => $variable->name, 'page_id' => 0)) ? $CI->page_variable_model->first(array('name' => $variable->name, 'page_id' => 0))->value : $variable->value;
							
							if ($variable->type == 'file')
							{
								$file_variable = $CI->page_variable_model->first(array('page_id' => 0, 'name' => $variable->name, 'page_variable_id' => null));
							}
						}
					}
					else 
					{
						if ($sub)
						{
							$page_variable = $CI->page_variable_model->first(array('name' => $sub->name, 'page_variable_id' => null, 'page_id' => $page->id));
							
							$value = $page_var && isset($page_var[$index][$variable->name]) ? $page_var[$index][$variable->name] : $variable->value;
							
							if ($variable->type == 'file' && $page_variable)
							{
								$file_variable = $CI->page_variable_model->first(array('page_id' => $page->id, 'name' => $variable->name, 'page_variable_id' => $page_variable->id, 'array_index' => $index));
							}
						}
						else
						{
							$value = $page->variable($variable->name) !== null ? $page->variable($variable->name) : $variable->value;
							
							if ($variable->type == 'file')
							{
								$file_variable = $CI->page_variable_model->first(array('page_id' => $page->id, 'name' => $variable->name, 'page_variable_id' => null));
							}
						}
					}
					
					$html  = '<div class="field">';
					$html .= '<label for="'.$id.'">'.$variable->label.':</label>';
					
					switch ($variable->type) {
						case 'string':
							if (!$variable->options)
							{
								$html .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" />';
							}
							else
							{
								$variable->options = is_array($variable->options) ? $variable->options : unserialize($variable->options);
								
								$html .= '<select name="'.$name.'" id="'.$id.'">';
								
								foreach ($variable->options as $option)
								{
									$html .= '<option value="'.$option.'"'.($value && $value == $option ? ' selected="selected"' : '').'>'.$option.'</option>';
								}
								
								$html .= '</select>';
							}
						break;
						case 'file':
							$html .= '<input type="hidden" name="'.$name.'" value="1"/>';
							$html .= '<input type="file" name="'.$name.'" id="'.$id.'" />';
														
							if ( $variable->type == 'file' && isset($file_variable) && $file_variable->file_file_name ) {
								$html .= '<a href="'.$file_variable->file->url().'" class="view_file">View File</a>';
							}
						break;
						case 'binary':
							$html .= '<textarea type="text" name="'.$name.'" id="'.$id.'">'.$value.'</textarea>';
						break;
						case 'html':
							$html .= '<textarea type="text" name="'.$name.'" id="'.$id.'" class="wysiwyg">'.$value.'</textarea>';
						break;
					}
					
					$html .= '</div>';
				}
				else
				{
					$html  = '<fieldset class="repeatable">';
					$html .= '<legend>'.$variable->name.'</legend>';
					
					if ($page_var = ($site_variables ? $page->variable($variable->name, null, 0) : $page->variable($variable->name)))
					{
						$page_var = ($page_var);
						$count    = count($page_var);
					}
					else
					{
						$count = 1;
					}
					$page_variable = $CI->page_variable_model->first(array('name' => $variable->name, 'page_variable_id' => null, 'page_id' => $site_variables ? 0 : $page->id));
					
					for ($i=0; $i<$count; $i++)
					{
						$html .= '<div class="repeatable_block" data-name="'.$variable->name.'"  data-index="'.$i.'">';
						$html .= '<input type="hidden" name="variables['.$variable->name.']['.$i.'][id]" value="'.($page_variable ? $page_variable->id.'_'.$i : $variable->id.'_'.$i).'" class="remove_on_clone" />';
						$vars  = $variable->template_variables->all();
						foreach ($vars as $v)
						{
							$html .= build_variable($v, $page, $variables, $variable, $i, $site_variables);
						}
						$html .= '</div>';
					}
					
					$html .= '</fieldset>';
				}
				
				return $html;
			}
			
			?>
			<?php foreach (($is_site_variables ? $this->template_variable_model->all(array('template_variable_id' => null, 'template_id' => 0)) : $page->template->template_variables->all(array('template_variable_id' => null))) as $variable): ?>
				<?=build_variable($variable, $page, $variables, false, 0, $is_site_variables ? $this->page_variable_model->all(array('page_id' => 0)) : null)?>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
	<?php 
		$not_used = array();
		foreach ($page->page_variables->all(array('page_variable_id' => null)) as $variable) {
			if (!in_array($variable->name, $variables)) {
				$not_used[] = $variable;
			}
		}
	?>
	<?php if (count($not_used)): ?>
		<fieldset>
			<legend>Unavailable Page Variables</legend>
			<?php foreach ($not_used as $variable): ?>
				<div class="field">
					<label><?=$variable->label?>:</label>
					<?php if ($variable->type == 'string'): ?>
						<input type="text" value="<?=$variable->value?>" />
					<?php elseif ($variable->type == 'binary'): ?>
						<textarea type="text"><?=$variable->value?></textarea>
					<?php elseif ($variable->type == 'html'): ?>
						<textarea type="text" class="ckeditor"><?=$variable->value?></textarea>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
	<?php 
	
	if ($ga && $page->persisted())
	{
		analytics_view('Visits to /'.$page->full_slug.' for the last week', 'page', array('range' => 'week', 'path' => '/'.($page->full_slug != 'index' ? $page->full_slug : '')));
	}
	
	?>
</div>
<div id="sidebar">
	<?php if ((!isset($is_site_variables) || !$is_site_variables) && $page->template_id): ?>
		<h2>Modules</h2>
		<?php foreach ($this->module_model->page_modules() as $module): ?>
			<div class="field checkbox"><input type="checkbox" name="modules[<?=$module->id?>]" id="moduled_<?=$module->id?>_field" value="1" <?=($page->template->requires_module($module->simple_name) ? 'checked="checked" disabled="disabled"' : ($page->page_modules->exists(array('module_id' => $module->id)) ? 'checked="checked"' : ''))?> /> <label for="moduled_<?=$module->id?>_field"<?=($page->template->requires_module($module->simple_name) ? ' class="disabled"' : '')?>><?=$module->name?></label></div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<div class="actions">
	<?php echo submit_tag(); ?> or <a href="<?php echo site_url('admin/pages'); ?>">cancel</a>
</div>