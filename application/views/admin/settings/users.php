<?php $title = 'Manage Users | Settings'; ?>
<?php $this->load->view('admin/_header', array('title' => $title)); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings')?>">
	<h2 id="title" style="position: relative;"><span class="section">Settings &raquo;</span> <span class="page">Manage Users</span> <a href="<?php echo site_url('admin/settings/users/new'); ?>" class="button new user" style="position: absolute; bottom: 5px; right: 0; font-size: 14px;">Add User</a></h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="records" class="users">
		<ul>
			<?php $is_odd = true; ?>
			<?php $installed = array(); ?>
			<?php foreach ($users as $user): ?>
				<li<?=($is_odd ? ' class="odd"' : '')?>>
					<div class="what"><?=$user->last_name?>, <?=$user->first_name?> <?php if($user->email): ?><span class="sub">(<?=$user->email?>)<?php endif; ?></span></div>
					<div class="actions">
						<a href="<?=site_url('admin/settings/users/'.$user->id)?>" class="edit">edit</a> 
						<a href="#" class="delete">delete</a>
					</div>
				</li>
				<?php $is_odd = !$is_odd; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>
