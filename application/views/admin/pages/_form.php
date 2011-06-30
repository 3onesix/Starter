<?php $this->load->view('admin/_errors', array('errors' => $page->errors()))?>
<div id="page_variables">
	<fieldset>
		<legend>Page Info</legend>
		<div class="field">
			<?php echo $f->label('name', 'Name:'); ?>
			<?php echo $f->text_field('name'); ?>				
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
			<?php foreach ($page->template->template_variables->all() as $variable): ?>
				<?php $variables[] = $variable->name; ?>
				<div class="field">
					<label><?=$variable->label?>:</label>
					<?php if ($variable->type == 'string'): ?>
						<input type="text" name="variables[<?=$variable->name?>]" value="<?=($page->variable($variable->name) !== null ? $page->variable($variable->name) : $variable->value)?>" />
					<?php elseif ($variable->type == 'binary'): ?>
						<textarea type="text" name="variables[<?=$variable->name?>]"><?=($page->variable($variable->name) !== null ? $page->variable($variable->name) : $variable->value)?></textarea>
					<?php endif; ?>
				</div>
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
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
</div>
<div id="sidebar">
	<h2>Modules</h2>
	<!--
	<div class="field checkbox"><input type="checkbox" name="page_[modules][seo]" value="1" checked="checked" disabled="disabled" /> <label for="" class="disabled">SEO</label></div>
	<div class="field checkbox"><input type="checkbox" name="page_[modules][articles]" value="1" checked="checked" disabled="disabled" /> <label for="" class="disabled">Articles</label></div>
	<div class="field checkbox"><input type="checkbox" name="page_[modules][googleanalytics]" value="1" /> <label for="">Google Analytics</label></div>
	//-->
	<?php foreach ($this->module_model->all() as $module): ?>
		<div class="field checkbox"><input type="checkbox" name="modules[<?=$module->id?>]" value="1" <?=($page->page_modules->exists(array('module_id' => $module->id)) ? 'checked="checked"' : '')?> /> <label for=""><?=$module->name?></label></div>
	<?php endforeach; ?>
</div>
<div class="actions">
	<?php echo submit_tag(); ?> or <a href="<?php echo site_url('admin/pages'); ?>">cancel</a>
</div>