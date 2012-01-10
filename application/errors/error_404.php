<?php 

if (file_exists('assets/site/templates/error_404.php'))
{
	include('assets/site/templates/error_404.php');
	return;
}

$CI =& get_instance();
$hour = date('G');
$CI->load->library('user_agent');

$referral = $CI->agent->is_referral() ? ' <a href="'.$CI->agent->referrer().'">Go Back</a>' : NULL;

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?=$CI->config->item('starter_product_name')?>: 404 (We're lost!)</title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
		
		<link rel="stylesheet" href="<?=base_url()?>assets/app/css/errors.css" type="" />
	</head>
	<body>
		<div id="content">
			<h1 class="image" style="background-image: url(<?=site_url($CI->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$CI->config->item('starter_product_name')?></a></h1>
			<p>The requested URL <span class="url">/<?=uri_string()?></span> was not found on this server.<?=$referral?></p>
		</div>
	</body>
</html>