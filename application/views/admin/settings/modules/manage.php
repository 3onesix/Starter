<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings/modules')?>">

	<h2 id="title"><span class="section">Settings &raquo;</span> <span class="page">Manage Modules</span></h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="records">
		<h3>Installed Modules</h3>
		<ul>
			<?php foreach ($modules as $module): ?>
				<li><div class="what"><?=$module->name?></div> <div class="actions"><?php if($module->settings->count()): ?><a href="<?=site_url('admin/settings/modules/'.$module->simple_name)?>" class="settings">settings</a> <?php endif; ?><a href="#" class="delete">delete</a></div></li>
			<?php endforeach; ?>
		</ul>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>