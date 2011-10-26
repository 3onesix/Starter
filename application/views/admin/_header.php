<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?=(isset($title) ? $title.' | ' : '')?><?=$this->config->item('starter_product_name')?></title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" media="all" href="<?=base_url()?>assets/app/css/app.css"/>
		<script type="text/javascript" src="<?=base_url()?>assets/app/js/ckeditor/ckeditor.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
		<?php 
		
		$module_screen = $this->module_screen_model->first_by_url($this->uri->segment(2));
		if ($module_screen)
		{
			$module = $this->module_model->first_by_id($module_screen->module_id);
			
			$stylesheets = $module->module_files->find(array('conditions' => array('type' => 'stylesheet'), 'limit' => 100));
			
			foreach ($stylesheets as $stylesheet)
			{
				echo '<link rel="stylesheet" media="all" href="'.base_url().'assets/site/modules/'.$module->simple_name.'/css/'.$stylesheet->name.'"/>';
			}
		}
		
		?>
	</head>
	<body>
		<header>
			<h1 class="image" style="background-image: url(<?=site_url($this->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$this->config->item('starter_product_name')?></a></h1>
			<?php $greetings = array(array('Welcome back', '!'), array('Hey there', '!'), array('Waaaaasup', '?!')); $key = array_rand($greetings); ?>
			<div class="global"><?=$greetings[$key][0]?>, <?=$this->current_user->first_name?><?=$greetings[$key][1]?> (<a href="<?=site_url('admin/settings')?>"<?=($this->uri->segment(2) == 'settings' ? ' class="selected"' : '')?>>Settings</a> &bull; <a href="<?=site_url('admin/signout')?>">Signout</a>)</div>
		</header>
		<div class="container">
			<ul id="navigation">
				<li><a href="<?=site_url('admin')?>"<?=($this->uri->segment(2) == '' ? ' class="selected"' : '')?>>Dashboard</a></li>
				<li><a href="<?=site_url('admin/pages')?>"<?=($this->uri->segment(2) == 'pages' ? ' class="selected"' : '')?>>Pages</a></li>
				
				<?php
					$modules = $this->module_model->all();
					foreach ($modules as $module) {
						if ($module->module_screens->count()) {
							foreach ($module->module_screens->all() as $screen) {
								echo '<li><a href="'.site_url('admin/'.$screen->url).'"'.($this->uri->segment(2) == $screen->url ? ' class="selected"' : '').'>'.$screen->name.'</a></li>';
							}
						}
					}
				?>
			</ul>