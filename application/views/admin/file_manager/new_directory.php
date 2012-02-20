<?php $this->load->view('admin/_header'); ?>

<form action="<?=site_url('admin/file_manager/create_directory')?>" method="post">
	<h2 id="title">New Directory</h2>
	<div id="page_variables">
		<input type="hidden" name="directory[path]" value="<?=$path?>" />
		<fieldset>
			<legend>Directory</legend>
			<div class="field">
				<label for="directory_name">Name</label>
				<input type="text" name="directory[name]" value="" />
			</div>
		</fieldset>
	</div>
	<div class="actions">
		<input type="submit" value="Save" /> or <a href="<?php echo site_url('admin/file_manager?path='.$path); ?>">cancel</a>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>