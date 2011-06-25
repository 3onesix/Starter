<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Starter</title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" media="all" href="/assets/app/css/app.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
	</head>
	<body>
		<div class="container">
			<ul id="navigation">
				<li><a href="<?=site_url('admin')?>">Dashboard</a></li>
				<li><a href="<?=site_url('admin/pages')?>">Pages</a></li>
				<li><a href="<?=site_url('admin/articles')?>">Articles</a></li>
			</ul>