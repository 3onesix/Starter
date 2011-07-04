<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<form method="post" action="<?=site_url('admin/settings/modules/install/'.$this->uri->segment(5))?>">

	<h2 id="title"><span class="section">Settings &raquo;</span> <span class="page">Install Module : <?=$module['name']?></span></h2>
	<?php $this->load->view('admin/settings/_sidebar.php'); ?>
	<div id="page_variables">
		<?php if (isset($module['author']) || isset($module['version'])): ?>
			<h3>Basic Info</h3>
			<ul>
				<?php if(isset($module['author'])): ?><li><strong>Author:</strong> <?=$module['author']?></li><?php endif; ?>
				<?php if(isset($module['version'])): ?><li><strong>Version:</strong> <?=$module['version']?></li><?php endif; ?>
			</ul>
		<?php endif; ?>
		<?php if (isset($module['description'])): ?>
			<h3>Description</h3>
			<p><?=str_replace('{product_name}', $this->config->item('starter_product_name'), $module['description'])?></p>
		<?php endif; ?>
		<?php if ((isset($module['screens']) && count($module['screens'])) || (isset($module['widgets']) && count($module['widgets']))): ?>
		<h3>Google Analytics will install:</h3>
		<ul class="installables">
			<?php if(isset($module['screens']) && count($module['screens'])): ?><li><?=count($module['screens'])?> screen <span class="note">(Screens are added to the navigation of <?=$this->config->item('starter_product_name')?>)</span></li><?php endif; ?>
			<?php if(isset($module['widgets']) && count($module['widgets'])): ?><li><?=count($module['widgets'])?> widget <span class="note">(Widgets show up on the dashboard or in the page editor)</span></li><?php endif; ?>
		</ul>
		<?php endif; ?>
		<a href="<?=site_url('admin/settings/modules/install/'.$this->uri->segment(5))?>?install=true" class="button green">Install Google Analytics</a>
	</div>
</form>

<?php $this->load->view('admin/_footer'); ?>
