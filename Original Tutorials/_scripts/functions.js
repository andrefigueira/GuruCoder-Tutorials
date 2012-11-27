//JavaScript functions file

$(document).ready(function(){

	$('.slider').slider({delay: 2000});

	$.fn.notify = function(options)
	{
	
		var defaults = {
			type: 'nuetral',
			message: 'Hello World This is a notification',
			delay: 1000
		}
		
		var options = jQuery.extend(defaults, options);
		
		var notification = '<div class="notify '+options.type+'">'+options.message+'</div>';
		
		if($('.notify').size() > 0)
		{
		
			$('.notify').remove();
		
		}
		
		$('#container').prepend(notification);
		$('.notify').delay(options.delay).fadeOut();
	
	}
	
	$('#notifyClick').click(function(){
	
		$(this).notify({type:'position', message:'Hey Guys this is a notification', delay:3200});
	
	});

});