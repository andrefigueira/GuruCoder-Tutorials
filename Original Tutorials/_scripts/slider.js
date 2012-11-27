$(document).ready(function(){

	$.fn.slider = function(options){
	
		var defaults = {
			delay: 500
		}
		
		var options = jQuery.extend(defaults, options);
	
		$('img').each(function(index){
			
			//Set an active attribute and set to false
			$(this).attr('active', 'false');
			
			//Give current img iteration an attribute to identify with
			$(this).attr('slide', index);
			
			if(index == 0)
			{
			
				//This is the first slide set an atribute and set to true
				$(this).attr('active', 'true');
				
				//This is the first slide, Show the first image.
				$(this).show();
			
			}
			
		});
		
		function slideLoop()
		{
			
			//Wait and fade the current active image
			$('img[active="true"]').delay(options.delay).fadeOut(function(){
			
				//Check if the next item exists
				if($(this).next().size() == 0)
				{
				
					//Fade in the first image
					$('img[slide="0"]').delay(options.delay).next().fadeIn();
					
					//Set the first image as the active attribute
					$('img[slide="0"]').attr('active', 'true');
				
				}
				else
				{
				
					//Fade in the next image
					$(this).delay(options.delay).next().fadeIn();
					
					//Set the active attribute for the next image to true
					$(this).next().attr('active', 'true');
				
				}
					
				//Set the current image attribute to false
				$(this).attr('active', 'false');
				
				slideLoop();
			
			});
			
		}
		
		slideLoop();
	
	}

});