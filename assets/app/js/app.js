$(function () {
	$('.destroy').click('click', function() {
		var answer = confirm('Are you sure?');
		
		if ( answer == true )
		{
			location.href=$(this).attr('href');
		}
		
		return false;
	});
});