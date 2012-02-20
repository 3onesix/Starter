<?php $this->load->view('admin/_header'); ?>

<form action="<?=site_url('admin/file_manager/do_upload')?>" method="post" enctype="multipart/form-data">
	<h2 id="title">Upload File to <?=$path?></h2>
	<div id="page_variables">
		<input type="hidden" name="path" value="<?=$path?>" />
		<fieldset>
			<legend>File Upload</legend>
			<div class="field">
				<label for="file">Select File</label>
				<input type="file" name="file" value="" />
			</div>
		</fieldset>
	</div>
	<div class="actions">
		<input type="submit" value="Save" /> or <a href="<?php echo site_url('admin/file_manager?path='.$path); ?>">cancel</a>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>