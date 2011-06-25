<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<div id="actions">
	<h3>All Pages</h3>
	<a href="<?php echo site_url('admin/pages/new'); ?>" class="button new page">new page</a>
</div>
<div id="records" class="pages">
	<ul>
		<?php foreach($pages as $page): ?>
			<li>
				<div class="what"><a href="<?php echo site_url('admin/pages/edit/'.$page->id); ?>"><?php echo $page->name; ?></a></div>
				<div class="actions"><a href="<?php echo site_url('admin/pages/destroy/'.$page->id); ?>" class="destroy">destroy</a></div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?=$this->pagination->create_links(); ?>
</div>

<?php $this->load->view('admin/_footer'); ?>
