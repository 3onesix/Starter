<?php
class Remove_Polymorphic_From_Images
{
	function up()
	{
		drop_column('images', 'imageable_id');
		drop_column('images', 'imageable_type');
	}
}