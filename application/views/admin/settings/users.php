<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings')?>">
	<h2 id="title"><span class="section">Settings &raquo;</span> <span class="page">Manage Users</span></h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="records" class="users">
		<ul>
			<?php $is_odd = true; ?>
			<?php $installed = array(); ?>
			<?php foreach ($users as $user): ?>
				<li<?=($is_odd ? ' class="odd"' : '')?>><div class="what"><?=$user->last_name?>, <?=$user->first_name?> <span class="sub">(<?=$user->email?>)</span></div> <div class="actions"><a href="<?=site_url('admin/settings/users/'.$user->id)?>" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
				<?php $is_odd = !$is_odd; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>
