<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?=$this->config->item('starter_product_name')?>: User Account</title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->

		<link rel="stylesheet" href="<?=base_url()?>assets/app/css/setup.css" type="" />
	</head>
	<body>
		<section class="large">
			<h1 class="image" style="background-image: url(<?=site_url($this->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$this->config->item('starter_product_name')?></a></h1>			
			<?php foreach($user->errors() as $error): ?>
				<div class="error"><?=$error?></div>
			<?php endforeach; ?>
			<?php print form_for($f, $user, site_url('')); ?>
				<div class="field">
					<?=$f->label('email'); ?>
					<?=$f->text_field('email'); ?>
				</div>
				<div class="field">
					<?=$f->label('first_name'); ?>
					<?=$f->text_field('first_name'); ?>
				</div>
				<div class="field">
					<?=$f->label('last_name'); ?>
					<?=$f->text_field('last_name'); ?>
				</div>
				<div class="field">
					<?=$f->label('username'); ?>
					<?=$f->text_field('username'); ?>
				</div>
				<div class="field">
					<?=$f->label('password'); ?>
					<?=$f->password_field('password'); ?>
				</div>
				<div class="field">
					<?=$f->label('confirm_password'); ?>
					<?=$f->password_field('confirm_password'); ?>
				</div>
				<div class="actions">
					<?=submit_tag('Create User'); ?>
				</div>
			<?php print form_end(); ?>
		</section>
	</body>
</html>