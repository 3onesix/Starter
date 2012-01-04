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
				foreach ((Array)($is_site_variables ? $this->template_variable_model->all(array('template_variable_id' => null, 'template_id' => 0)) : $page->template->template_variables->all(array('template_variable_id' => null))) as $variable)
				{
					$name = 'variables['.$variable->name.']';
					$variableInstance = getVariableObject($variable->type, $variable, $name, $is_site_variables ? 0 : $page->id);
					echo $variableInstance ? $variableInstance->render() : '';
				}
			?>
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
	<?php if (0 == 1 && count($not_used)): ?>
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
	
	if (isset($ga) && $ga && $page->persisted())
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