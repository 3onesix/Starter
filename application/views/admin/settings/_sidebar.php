<ul id="sidebar" class="left">
	<li class="header">General</li>
	<li><a href="<?=site_url('admin/settings')?>"<?=($this->uri->segment(3) == '' ? ' class="selected"' : '')?>>Meta Info</a></li>
	<li><a href="<?=site_url('admin/settings/users')?>"<?=($this->uri->segment(3) == 'users' ? ' class="selected"' : '')?>>Users</a></li>
	<li><a href="<?=site_url('admin/settings/modules')?>"<?=($this->uri->segment(3) == 'modules' && $this->uri->segment(4) == '' ? ' class="selected"' : '')?>>Manage Modules</a></li>
	<li class="header">Modules</li>
	<li><a href="<?=site_url('admin/settings/modules/starter_articles')?>"<?=($this->uri->segment(3) == 'modules' && $this->uri->segment(4) == 'starter_articles' ? ' class="selected"' : '')?>>Articles</a></li>
</ul>