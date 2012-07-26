<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?=$this->config->item('starter_product_name')?>: Reset Password</title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
		
		<link rel="stylesheet" href="<?=base_url()?>assets/app/css/signin.css" />
	</head>
	<body>
		<form id="signin" method="post" action="<?=site_url('admin/reset_password_process/'.$this->uri->segment(3))?>">
			<h1 class="image" style="background-image: url(<?=site_url($this->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$this->config->item('starter_product_name')?></a></h1>
			<?php if ($notice): ?><div class="notice"><?=$notice?></div><?php endif; ?>
			<?php if ($error): ?><div class="error"><?=$error?></div><?php endif; ?>
			<div class="field">
				<label for="password_field">New Password<label>
				<input type="password" name="password" id="password_field" />
			</div>
			<div class="field">
				<label for="confirm_field">Confirm Password<label>
				<input type="password" name="confirm" id="confirm_field" />
			</div>
			<div class="actions">
				<input type="submit" name="commit" value="Reset Password">
			</div>
		</form>
	</body>
</html>