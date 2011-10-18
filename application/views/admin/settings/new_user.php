<?php $title = 'New User | Settings'; ?>
<?php $this->load->view('admin/_header', array('title' => $title)); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings/users/new')?>">
	<h2 id="title"><span class="section">Settings</span> &raquo; New User</h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="page_variables">
		<fieldset>
			<div class="field">
				<label for="user_first_name_field">First Name</label>
				<input type="text" name="user[first_name]" id="user_first_name_field" />
			</div>
			<div class="field">
				<label for="user_last_name_field">Last Name</label>
				<input type="text" name="user[last_name]" id="user_last_name_field" />
			</div>
			<div class="field">
				<label for="user_username_field">Username</label>
				<input type="text" name="user[username]" id="user_username_field" />
			</div>
			<div class="field">
				<label for="user_email_field">Email</label>
				<input type="text" name="user[email]" id="user_email_field" />
			</div>
		</fieldset>
		<fieldset>
			<legend>Reset Password</legend>
			<div class="field">
				<label for="user_password_field">New Password</label>
				<input type="password" name="user[password]" id="user_password_field" value="" />
			</div>
			<div class="field">
				<label for="user_confirm_field">Confirm Password</label>
				<input type="password" name="user[confirm_password]" id="user_confirm_field" value="" />
			</div>
		</fieldset>
		<div class="actions">
			<?php echo submit_tag(); ?> or <a href="<?=site_url('admin/settings/users')?>">cancel</a>
		</div>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>
