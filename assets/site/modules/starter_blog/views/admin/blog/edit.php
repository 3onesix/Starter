<?php $title = 'Edit Article : '.$article->subject.' | Blog'; ?>
<?php $this->load->view('admin/_header', array('title' => $title)); ?>

<?php echo form_for($f, $article, site_url('admin/blog/update/'.$article->id)); ?>
	<h2 id="title"><span class="section">Article &raquo;</span> <span class="page"><?=$article->subject?></span></h2>
	<?php $this->load->view('admin/blog/_form', array('f'=>$f)); ?>
<?php echo form_end(); ?>

<?php $this->load->view('admin/_footer'); ?>