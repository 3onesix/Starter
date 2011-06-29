<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<div id="actions">
	<h2>Settings</h2>
</div>

<form method="post" action="<?=site_url('admin/settings/modules/'.$module->id)?>">
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="page_variables">
		<fieldset>
			<legend><?=$module->name?> Settings</legend>
			<?php foreach ($module->settings->all() as $setting): ?>
				<div class="field<?=($setting->type == 'checkbox' ? ' checkbox' : '')?>">
					<?php if ($setting->type == 'checkbox'): ?>
						<input type="hidden" name="setting[<?=$setting->id?>]" value="0" /><input type="checkbox" id="settings_<?=$setting->id?>_field" name="setting[<?=$setting->id?>]" value="1" <?=($setting->value == 1 ? 'checked="checked"' : '')?> />
					<?php endif; ?>
					<label for="settings_<?=$setting->id?>_field"><?=($setting->label ? $setting->label : $setting->key)?></label>
					<?php if (! in_array($setting->type, array('checkbox', 'list'))): ?>
						<input type="text" id="settings_<?=$setting->id?>_field" name="setting[<?=$setting->id?>]" value="<?=$setting->value?>" />
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</fieldset>
		<div class="actions">
			<?php echo submit_tag(); ?>
		</div>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>
