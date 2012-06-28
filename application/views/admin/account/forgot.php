<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?=$this->config->item('starter_product_name')?>: Forgot Password</title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
		
		<link rel="stylesheet" href="<?=base_url()?>assets/app/css/signin.css" type="" />
	</head>
	<body>
		<form id="signin" method="post" action="<?=site_url('admin/forgot_password_process')?>">
			<h1 class="image" style="background-image: url(<?=site_url($this->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$this->config->item('starter_product_name')?></a></h1>
			<?php if ($notice): ?><div class="notice"><?=$notice?></div><?php endif; ?>
			<?php if ($error): ?><div class="error"><?=$error?></div><?php endif; ?>
			<div class="field">
				<label for="email_field">Email Address<label>
				<input type="text" name="email" id="email_field" />
			</div>
			<div class="actions">
				<input type="submit" name="commit" value="Help!">
			</div>
		</form>
	</body>
</html>