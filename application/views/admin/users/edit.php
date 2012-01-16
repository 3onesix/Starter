<?php $title = 'Edit User : '.$user->first_name.' '.$user->last_name.' | Settings'; ?>
<?php $this->load->view('admin/_header', array('title' => $title)); ?>

<?php $this->load->view('admin/_errors', array('errors' => $user->errors()))?>

<?php print form_for($f, $user, site_url('admin/users/update/'.$user->id)); ?>
	<h2 id="title"><span class="section">Settings</span> &raquo; Edit User</h2>
	<?php $this->load->view('admin/users/_form', array('f'=>$f)); ?>
<?php print form_end(); ?>

<?php $this->load->view('admin/_footer'); ?>
