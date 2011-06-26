<?php $this->load->view('admin/_header'); ?>

<?php if(flash('notice')): ?><div class="notice"><?php echo flash('notice'); ?></div><?php endif; ?>

<div id="actions">
	<h2>All Pages</h2>
	<a href="<?php echo site_url('admin/pages/new'); ?>" class="button new page">Create a New Page</a>
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

<div id="records" class="pages">
	<ul>
		<li class="odd"><div class="what">Homepage <span class="slug">(index)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
		<li><div class="what">Profile <span class="slug">(profile)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
		<ul>
			<li class="odd"><div class="what">Management &amp; Staff <span class="slug">(profile/management_and_staff)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
			<li><div class="what">Safety Record <span class="slug">(profile/safety_record)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
			<li class="odd"><div class="what">Financial Strength <span class="slug">(profile/financial_strength)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
			<li><div class="what">Honor &amp; Awards <span class="slug">(profile/awards)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
			<li class="odd"><div class="what">Contact <span class="slug">(profile/contact)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
		</ul>
		<li><div class="what">Services <span class="slug">(services)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
		<ul>
			<li class="odd"><div class="what">Pre-construction Services <span class="slug">(services/pre_construction)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
			<ul>
				<li><div class="what">Pre-construction Services <span class="slug">(services/pre_construction/pre_construction)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
				<ul>
					<li class="odd"><div class="what">Pre-construction Services <span class="slug">(services/pre_construction/pre_construction/pre_construction)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
					<ul>
						<li><div class="what">Pre-construction Services <span class="slug">(services/pre_construction/pre_construction/pre_construction/pre_construction)</span></div> <div class="actions"><a href="#" class="view">view</a> <a href="#" class="edit">edit</a> <a href="#" class="delete">delete</a></div></li>
					</ul>
				</ul>
			</ul>
		</ul>
	</ul>
</div>

<?php $this->load->view('admin/_footer'); ?>
