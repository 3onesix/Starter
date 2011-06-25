<?php $this->load->view('admin/_header'); ?>

<?php print form_for($f, $page, site_url('admin/pages/create')); ?>
	<?php $this->load->view('admin/_errors', array('errors' => $page->errors()))?>
	<h2 id="title">New Page</h2>
	<div id="page_variables">
		<fieldset>
			<legend>Page Info</legend>
			<div class="field">
				<?php print $f->label('name', 'Name:'); ?>
				<?php print $f->text_field('name'); ?>				
			</div>
			<div class="field">
				<?php print $f->label('slug', 'Slug:'); ?>
				<?php print $f->text_field('slug'); ?>				
			</div>
		</fieldset>
	</div>
	<?php $this->load->view('admin/pages/_sidebar'); ?>
	<div class="actions">
		<?php print submit_tag(); ?> or <a href="<?php print site_url('admin/pages'); ?>">cancel</a>
	</div>
<?php print form_end(); ?>

<?php $this->load->view('admin/_footer'); ?>