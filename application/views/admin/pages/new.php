<?php $this->load->view('admin/_header'); ?>

<?php echo form_for($f, $page, site_url('admin/pages/create')); ?>
	<h2 id="title">New Page</h2>
	<?php $this->load->view('admin/pages/_form', array('f'=>$f)); ?>
<?php echo form_end(); ?>

<?php $this->load->view('admin/_footer'); ?>