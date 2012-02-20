<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>
<?php if(flash('error')): ?><div class="error"><?php echo flash('error'); ?></div><?php endif; ?>

<div id="actions">
	<h2>File Manager<?php if($current): ?>: <?=ucwords($current)?><?php endif; ?></h2>
	<div id="action_buttons">
		<a href="<?php echo site_url('admin/file_manager/upload_file?path='.$path); ?>" class="button new page">Upload File</a>
		<a href="<?php echo site_url('admin/file_manager/new_directory?path='.$path); ?>" class="button new page">Create a New Directory</a>
	</div>
</div>
<div id="records" class="files">
	<?php if ($path): ?><a href="<?=site_url('admin/file_manager?path='.$parent)?>" class="button">Back to parent directory</a><?php endif; ?>
	<ul>
		<?php $odd = false; ?>
		<?php foreach($files as $file): ?>
		<li<?=($odd ? ' class="odd"' : '')?>>
			<div class="what"><?php if ($file->is_dir): ?><a href="<?=site_url('admin/file_manager?path='.$file->path)?>"><?=$file->pointer?></a><?php else: ?><?=$file->pointer?><?php endif; ?></div>
			<div class="actions">
				<?php if ($file->is_file): ?><a class="view" href="<?=$file->url?>">view</a><?php endif; ?>
				<a class="delete" href="<?=site_url('admin/file_manager/destroy'.($file->is_dir ? '_directory' : '').'?path='.$file->path)?>">delete</a>
			</div>
		</li>
		<?php $odd = !$odd; ?>
		<?php endforeach; ?>
	</ul>
</div>

<?php $this->load->view('admin/_footer'); ?>
