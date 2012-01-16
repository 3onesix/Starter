<?php $this->load->view('admin/settings/_sidebar.php'); ?>
<div id="page_variables">
	<fieldset>
		<div class="field">	
			<?php print $f->label('first_name'); ?>
			<?php print $f->text_field('first_name'); ?>
		</div>
		<div class="field">
			<?php print $f->label('last_name'); ?>
			<?php print $f->text_field('last_name'); ?>
		</div>
		<div class="field">
			<?php print $f->label('username'); ?>
			<?php print $f->text_field('username'); ?>
		</div>
		<div class="field">
			<?php print $f->label('email'); ?>
			<?php print $f->text_field('email'); ?>
		</div>
	</fieldset>
	<?php if ($this->current_user->id == $user->id || ! $user->persisted()): ?>
	<fieldset>
		<legend>Reset Password</legend>
		<div class="field">
			<?php print $f->label('password', 'New Password'); ?>
			<?php print $f->password_field('password', array('value' => NULL)); ?>
		</div>
		<div class="field">
			<?php print $f->label('confirm_password'); ?>
			<?php print $f->password_field('confirm_password', array('value' => NULL)); ?>
		</div>
	</fieldset>
	<?php endif; ?>
	<div class="actions">
		<?php echo submit_tag(); ?> or <a href="<?=site_url('admin/users')?>">cancel</a>
	</div>
</div>