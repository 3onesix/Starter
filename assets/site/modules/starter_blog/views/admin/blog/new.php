<?php $title = 'New Article | Blog'; ?>
<?php $this->load->view('admin/_header', array('title' => $title)); ?>

<?php echo form_for($f, $article, site_url('admin/blog/create')); ?>
	<h2 id="title">New Article</h2>
	<?php $this->load->view('admin/blog/_form', array('f'=>$f)); ?>
<?php echo form_end(); ?>

<?php $this->load->view('admin/_footer'); ?>