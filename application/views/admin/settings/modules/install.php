<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings/modules')?>">

	<h2 id="title"><span class="section">Settings &raquo;</span> <span class="page">Install Module : Google Analytics</span></h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="page_variables">
		<h3>Basic Info</h3>
		<ul>
			<li><strong>Author:</strong> Starter</li>
			<li><strong>Version:</strong> 1.0</li>
		</ul>
		<h3>Description</h3>
		<p>The Google Analytics module provides a quick and easy way to install analytics on all your pages, but also to track your numbers for any page and for your site within <?=$this->config->item('starter_product_name')?>.</p>
		<h3>Google Analytics will install:</h3>
		<ul class="installables">
			<li>1 screen <span class="note">(Screens are added to the navigation of <?=$this->config->item('starter_product_name')?>)</span></li>
			<li>2 widgets <span class="note">(Widgets show up on the dashboard or in the page editor)</span></li>
		</ul>
		<a href="#" class="button green">Install Google Analytics</a>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>
