<?php $this->load->view('admin/_errors', array('errors' => $article->errors()))?>
<div id="page_variables">
	<fieldset>
		<?php if (count($blogs) > 1): ?>
			<div class="field">
				<?php print $f->label('blog_id', 'Blog:'); ?>
				<?php print $f->select('blog_id', $blogs); ?>
			</div>
		<?php else: ?>
			<input type="hidden" name="starter_article[blog_id]" value="<?=current(array_keys($blogs))?>" />
		<?php endif; ?>
		<div class="field">
			<?php echo $f->label('subject', 'Subject:'); ?>
			<?php echo $f->text_field('subject'); ?>				
		</div>
		<?php if ($this->module->setting('include_short')): ?>
			<div class="field" data-help="If a summary is provided, this will be displayed on list pages.">
				<?php echo $f->label('short', 'Short Summary:'); ?>
				<?php echo $f->text_field('short'); ?>				
			</div>
		<?php endif; ?>
		<div class="field">
			<?php echo $f->label('body', 'Body:'); ?>
			<?php echo $f->text_area('body'); ?>				
		</div>
		<div class="field checkbox">
			<?php echo $f->check_box('is_published'); ?>
			<?php echo $f->label('is_published', 'Published'); ?>
		</div>
	</fieldset>
</div>
<div id="sidebar">
</div>
<div class="actions">
	<?php echo submit_tag(); ?> or <a href="<?php echo site_url('admin/blog'); ?>">cancel</a>
</div>