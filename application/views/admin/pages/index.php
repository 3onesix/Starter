<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<div id="actions">
	<h2>All Pages</h2>
	<a href="<?php echo site_url('admin/pages/new'); ?>" class="button new page">Create a New Page</a>
</div>
<div id="records" class="pages">
	<?php page_hierarchial_list($pages, FALSE); ?>
</div>

<?php $this->load->view('admin/_footer'); ?>
