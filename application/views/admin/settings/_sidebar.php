<ul id="sidebar" class="left">
	<li class="header">General</li>
	<li><a href="<?=site_url('admin/settings')?>"<?=($section == 'meta' ? ' class="selected"' : '')?>>Meta Info</a></li>
	<li><a href="<?=site_url('admin/users')?>"<?=($section == 'users' ? ' class="selected"' : '')?>>Users</a></li>
	<li><a href="<?=site_url('admin/settings/modules')?>"<?=($this->uri->segment(3) == 'modules' && $this->uri->segment(4) == '' ? ' class="selected"' : '')?>>Manage Modules</a></li>
	
	<?php
		$this->db->order_by('name');
		$all = $this->module_model->all();
		$modules = array();
		foreach ($all as $m) if ($m->settings->count()) $modules[] = $m;
	?>
	<?php if (count($modules)): ?>
		<li class="header">Modules</li>
		<?php foreach ($modules as $module): ?>
			<li><a href="<?=site_url('admin/settings/modules/'.$module->simple_name)?>"<?=($this->uri->segment(3) == 'modules' && $this->uri->segment(4) == $module->simple_name ? ' class="selected"' : '')?>><?=$module->name?></a></li>
		<?php endforeach; ?>
	<?php endif; ?>
	
</ul>