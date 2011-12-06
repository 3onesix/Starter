<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings/modules')?>">

	<h2 id="title"><span class="section">Settings &raquo;</span> <span class="page">Manage Modules</span></h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="records" class="install_modules">
		<h3>Installed Modules</h3>
		<ul>
			<?php $is_odd = true; ?>
			<?php $installed = array(); ?>
			<?php foreach ($modules as $module): ?>
				<li<?=($is_odd ? ' class="odd"' : '')?>><div class="what"><?=$module->name?><?=$module->has_update ? ' (<a href="'.site_url('admin/settings/modules/update/'.$module->simple_name).'">update module</a>)' : ''?></div> <div class="actions"><?php if($module->settings->count()): ?><a href="<?=site_url('admin/settings/modules/'.$module->simple_name)?>" class="settings">settings</a> <?php endif; ?><a href="#" class="delete">delete</a></div></li>
				<?php $is_odd = !$is_odd; ?>
				<?php $installed[] = $module->simple_name; ?>
			<?php endforeach; ?>
		</ul>
		<?php
			$awaiting = array();
			if ($handle = opendir('assets/site/modules'))
			{
				while (false !== ($file = readdir($handle)))
				{
				    if (is_dir('assets/site/modules/'.$file) && $file != '.' && $file != '..')
				    {
				    	if (!in_array($file, $installed))
				    	{
				    		$awaiting[] = $file;
				    	}
				    }
				}
			}
		?>
		<?php if (count($awaiting)): ?>
			<h3>Modules Awaiting Installation</h3>
			<ul>
				<?php $is_odd = true; ?>
				<?php foreach ($awaiting as $module): ?>
					<li<?=($is_odd ? ' class="odd"' : '')?>><div class="what"><?=$module?></div> <div class="actions"><a href="<?=site_url('admin/settings/modules/install/'.$module)?>" class="install">install</a></div></li>
					<?php $is_odd = !$is_odd; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>