<?php $title = 'New User | Settings'; ?>
<?php $this->load->view('admin/_header', array('title' => $title)); ?>

<?php $this->load->view('admin/_errors', array('errors' => $user->errors()))?>

<?php print form_for($f, $user, site_url('admin/users/create')); ?>
	<h2 id="title"><span class="section">Settings</span> &raquo; New User</h2>
	<?php $this->load->view('admin/users/_form', array('f'=>$f)); ?>
<?php print form_end(); ?>

<?php $this->load->view('admin/_footer'); ?>
