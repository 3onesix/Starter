<?php

function install()
{
	mkdir('assets/site/backups');
}

install();

/*

So the idea here is that the update function would be called and given the current version anytime that the module is loaded. It would autoupdate tables, add items to the data, or whatever else needs to be done.

*/