<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<div id="actions">
	<h2>All Backups</h2>
	<a href="<?php echo site_url('admin/backup/backup'); ?>" class="button new backup">Backup Your Site Now</a>
</div>
<div id="records" class="backups">
	<ul>
		<?php foreach($files as $file): ?>
		<li>
			<div class="what">Backed up on <?=date('F d, Y \a\t h:i a', $file)?></div>
			<div class="actions">
				<a class="delete" href="<?=site_url('admin/backup/destroy/'.$file)?>">delete</a>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>

<?php $this->load->view('admin/_footer'); ?>