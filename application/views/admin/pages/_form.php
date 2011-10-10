<?php $this->load->view('admin/_errors', array('errors' => $page->errors()))?>
<div id="page_variables">
	<fieldset>
		<legend>Page Info</legend>
		<div class="field">
			<?php echo $f->label('name', 'Name:'); ?>
			<?php echo $f->text_field('name'); ?>				
		</div>
		<div class="field">
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
	<?php $variables = array(); ?>
	<?php if ($page->template_id && $page->template->template_variables->count()): ?>
		<fieldset>
			<legend>Page Variables</legend>
			<?php 
			
			function build_variable($variable, &$page, &$variables, $sub = false, $index = 0)
			{
				if (!$sub) $variables[] = $variable->name;
				else
				{
					if ($page_var = $page->variable($sub->name))
					{
						$page_var = unserialize($page_var);
					}
					else
					{
						$page_var = null;
					}
				}
				
				if ($variable->type != 'array')
				{
					$name  = 'variables'.($sub ? '['.$sub->name.']['.$index.']' : '').'['.$variable->name.']';
					$id    = 'variables_'.($sub ? $sub->name.'_'.$index.'_' : '').$variable->name.'_field';
					if ($sub)
					{
						$value = $page_var && isset($page_var[$index][$variable->name]) ? $page_var[$index][$variable->name] : $variable->value;
					}
					else
					{
						$value = $page->variable($variable->name) !== null ? $page->variable($variable->name) : $variable->value;
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
					
					if ($page_var = $page->variable($variable->name))
					{
						$page_var = unserialize($page_var);
						$count    = count($page_var);
					}
					else
					{
						$count = 1;
					}
					
					for ($i=0; $i<$count; $i++)
					{
						$html .= '<div class="repeatable_block" data-name="'.$variable->name.'"  data-index="'.$i.'">';
						$vars  = $variable->template_variables->all();
						foreach ($vars as $v)
						{
							$html .= build_variable($v, $page, $variables, $variable, $i);
						}
						$html .= '</div>';
					}
					
					$html .= '</fieldset>';
				}
				
				return $html;
			}
			
			?>
			<?php foreach ($page->template->template_variables->all(array('template_variable_id' => null)) as $variable): ?>
				<?=build_variable($variable, $page, $variables)?>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
	<?php 
		$not_used = array();
		foreach ($page->page_variables->all() as $variable) {
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
</div>
<div id="sidebar">
	<?php if ($page->template_id): ?>
		<h2>Modules</h2>
		<?php foreach ($this->module_model->all() as $module): ?>
			<div class="field checkbox"><input type="checkbox" name="modules[<?=$module->id?>]" id="moduled_<?=$module->id?>_field" value="1" <?=($page->template->requires_module($module->simple_name) ? 'checked="checked" disabled="disabled"' : ($page->page_modules->exists(array('module_id' => $module->id)) ? 'checked="checked"' : ''))?> /> <label for="moduled_<?=$module->id?>_field"<?=($page->template->requires_module($module->simple_name) ? ' class="disabled"' : '')?>><?=$module->name?></label></div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<div class="actions">
	<?php echo submit_tag(); ?> or <a href="<?php echo site_url('admin/pages'); ?>">cancel</a>
</div>