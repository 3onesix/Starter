<?php $this->load->view('admin/_header'); ?>

<?php echo form_for($f, $page, site_url('admin/pages/update/'.($is_site_variables ? 0 : $page->id))); ?>
	<?php if (!$is_site_variables): ?>
		<h2 id="title"><span class="section">Page &raquo;</span> <span class="page"><?=$page->name?></span></h2>
	<?php else: ?>
		<h2 id="title"><span class="section">Page &raquo;</span> <span class="page">Site Variables</span></h2>
	<?php endif; ?>
	<?php $this->load->view('admin/pages/_form', array('f'=>$f)); ?>
<?php echo form_end(); ?>

<?php $this->load->view('admin/_footer'); ?>