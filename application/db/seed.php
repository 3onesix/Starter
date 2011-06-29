<?php

$this->user_model->create(array(
	'first_name' => 'Tom',
	'last_name' => 'Krush',
	'username' => 'tomkrush',
	'password' => 'beta',
	'confirm_password' => 'beta'
));

$this->user_model->create(array(
	'first_name' => 'James',
	'last_name' => 'Finley',
	'username' => 'jamesfinley',
	'password' => 'beta',
	'confirm_password' => 'beta'
));

$home = $this->page_model->create(array('name'=>'Home', 'slug'=>'index'));
$about = $this->page_model->create(array('name'=>'About'));
$blog = $this->page_model->create(array('name'=>'Blog'));
$news = $this->page_model->create(array('name'=>'News'));
$archive = $this->page_model->create(array('name'=>'Archive'));
$tutorials = $this->page_model->create(array('name'=>'Tutorials'));
$news = $this->page_model->create(array('name'=>'News'));
$faq = $this->page_model->create(array('name'=>'Faq'));
$contact = $this->page_model->create(array('name'=>'Contact'));
$services = $this->page_model->create(array('name'=>'Services'));
$store = $this->page_model->create(array('name'=>'Store'));
$account = $this->page_model->create(array('name'=>'Account'));
$login = $this->page_model->create(array('name'=>'Login'));
$tickets = $this->page_model->create(array('name'=>'Tickets'));
$credit = $this->page_model->create(array('name'=>'Credit'));
$history = $this->page_model->create(array('name'=>'History'));

$blog->pages = array($news, $archive, $tutorials, $about);
$about->pages = array($faq, $services, $account, $contact);
$account->pages = array($login);
$login->pages = array($tickets);
$tickets->pages = array($credit, $history);

// modules
$blog = $this->module_model->create(array('name' => 'Blog', 'simple_name' => 'blog'));
$blog->module_screens = array(
	$this->module_screen_model->create(array(
		'name' => 'Blog',
		'url' => 'blog')
	)
);
$this->setting_model->create(array(
	'module_id' => $blog->id,
	'type' => 'checkbox',
	'label' => 'Include Short Body Field',
	'key' => 'include_short',
	'value' => '0',
));
$googleanalytics = $this->module_model->create(array('name' => 'Google Analytics', 'simple_name' => 'googleanalytics'));
$this->setting_model->create(array(
	'module_id' => $googleanalytics->id,
	'type' => 'text',
	'label' => 'Key',
	'key' => 'key',
	'value' => '',
));