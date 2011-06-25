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
	</fieldset>
</div>
<div id="sidebar">
	<h2>Modules</h2>
	<div class="field checkbox"><input type="checkbox" name="page_[modules][seo]" value="1" checked="checked" disabled="disabled" /> <label for="" class="disabled">SEO</label></div>
	<div class="field checkbox"><input type="checkbox" name="page_[modules][articles]" value="1" checked="checked" disabled="disabled" /> <label for="" class="disabled">Articles</label></div>
	<div class="field checkbox"><input type="checkbox" name="page_[modules][googleanalytics]" value="1" /> <label for="">Google Analytics</label></div>
</div>
<div class="actions">
	<?php echo submit_tag(); ?> or <a href="<?php echo site_url('admin/pages'); ?>">cancel</a>
</div>