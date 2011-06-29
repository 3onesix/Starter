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
		<div class="field">
			<?php print $f->label('template_id', 'Template:'); ?>
			<?php print $f->select('template_id', $templates); ?>
		</div>
	</fieldset>
	<?php if ($page->template_id && $page->template->template_variables->count()): ?>
		<fieldset>
			<legend>Page Variables</legend>
			<?php foreach ($page->template->template_variables->all() as $variable): ?>
				<div class="field">
					<label><?=$variable->label?>:</label>
					<?php if ($variable->type == 'string'): ?>
						<input type="text" name="variables[<?=$variable->name?>]" value="<?=$page->variable($variable->name)?>" />
					<?php elseif ($variable->type == 'binary'): ?>
						<textarea type="text" name="variables[<?=$variable->name?>]"><?=$page->variable($variable->name)?></textarea>
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