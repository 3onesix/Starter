<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?=(isset($title) ? $title.' | ' : '')?><?=(setting('site_name') ? htmlspecialchars(setting('site_name')).' | ' : '').($this->config->item('starter_product_name'))?></title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" media="all" href="<?=base_url()?>assets/app/css/app.css"/>
		<script type="text/javascript" src="<?=base_url()?>assets/app/js/ckeditor/ckeditor.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
		
		<script type="text/javascript" src="<?=base_url()?>assets/shared/js/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/shared/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/shared/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/shared/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

		<script type="text/javascript" src="<?=base_url()?>assets/app/js/image_manager.js" />

		<script type="text/javascript">
			$(function () {
				$('#page_variables .field a').each(function () {
					if (($(this).attr('href') ? $(this).attr('href').indexOf('.jpg') : -1) > -1) {
						$(this).fancybox({'transitionIn': 'elastic', 'transitionOut': 'elastic'});
					}
					else if (($(this).attr('href') ? $(this).attr('href').indexOf('.jpeg') : -1) > -1) {
						$(this).fancybox({'transitionIn': 'elastic', 'transitionOut': 'elastic'});
					}
					else if (($(this).attr('href') ? $(this).attr('href').indexOf('.png') : -1) > -1) {
						$(this).fancybox({'transitionIn': 'elastic', 'transitionOut': 'elastic'});
					}
				});
			})
		</script>
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
			<?php 
				$greetings = array(array('Welcome back', '!'), array('Hey there', '!'), array('Waaaaasup', '?!'));
				if (date('H') < 11)
				{
					$greetings[] = array('Top o\' the mornin\' to ya', '!');
					$greetings[] = array('Morning', '!');
					$greetings[] = array('Good morning', '!');
				}
				elseif (date('H') >= 13 && date('H') < 17)
				{
					$greetings[] = array('Good afternoon', '!');
					$greetings[] = array('Afternoon', '!');
				}
				elseif (date('H') >= 17)
				{
					$greetings[] = array('Good evening', '!');
					$greetings[] = array('Evenin\'', '!');
				}
				$key = array_rand($greetings);
			?>
			<div class="global"><?=$greetings[$key][0]?>, <?=$this->current_user->first_name?><?=$greetings[$key][1]?> (<a href="<?=site_url('admin/settings')?>"<?=($this->uri->segment(2) == 'settings' ? ' class="selected"' : '')?>>Settings</a> &bull; <a href="<?=site_url('admin/signout')?>">Signout</a>)</div>
		</header>
		<div class="container">
			<ul id="navigation">
				<li><a href="<?=site_url('admin')?>"<?=($this->uri->segment(2) == '' ? ' class="selected"' : '')?>>Dashboard</a></li>
				<li><a href="<?=site_url('admin/pages')?>"<?=($this->uri->segment(2) == 'pages' ? ' class="selected"' : '')?>>Pages</a></li>
				<?php if ($this->config->item('starter_show_file_manager')): ?>
					<li><a href="<?=site_url('admin/file_manager')?>"<?=($this->uri->segment(2) == 'file_manager' ? ' class="selected"' : '')?>>Files</a></li>
				<?php endif; ?>
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