<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<div id="actions">
	<h2>Settings</h2>
</div>

<form method="post" action="<?=site_url('admin/settings')?>">
	<div id="page_variables">
		<fieldset>
			<legend>Site Info</legend>
			<div class="field">
				<label for="settings_site_name_field">Name</label>
				<input type="text" name="settings[site_name]" id="settings_site_name_field" value="<?=setting('site_name')?>" />
			</div>
			<div class="field">
				<label for="settings_site_author_field">Author</label>
				<input type="text" name="settings[site_author]" id="settings_site_author_field" value="<?=setting('site_author')?>" />
			</div>
		</fieldset>
	</div>
	<div class="actions">
		<?php echo submit_tag(); ?>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>
