<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings/modules')?>">

	<h2 id="title"><span class="section">Settings &raquo;</span> <span class="page">Manage Modules</span></h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="page_variables">
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>