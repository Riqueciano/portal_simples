$(document).ready(function() {
	//Tooltips
        $(".tip_trigger").live('mouseover mouseout',function(event){
            if (event.type === 'mouseover') {
                tip = $(this).find('.tip');
		tip.show(); //Show tooltip
            }
            else if (event.type === 'mouseout') {
                tip = $(this).find('.tip');
                tip.hide(); //Hide tooltip
            }
        }).mousemove(function(e) {
		var mousex = e.pageX + 20; //Get X coodrinates
		var mousey = e.pageY + 20; //Get Y coordinates
//		var tipWidth = tip.width(); //Find width of tooltip
//		var tipHeight = tip.height(); //Find height of tooltip
		
		//Distance of element from the right edge of viewport
		var tipVisX = $(window).width() - (mousex);
		//Distance of element from the bottom of viewport
		var tipVisY = $(window).height() - (mousey);
		  
		if ( tipVisX < 20 ) { //If tooltip exceeds the X coordinate of viewport
			mousex = e.pageX - 20;
		} if ( tipVisY < 20 ) { //If tooltip exceeds the Y coordinate of viewport
			mousey = e.pageY - 20;
		} 
		tip.css({  top: mousey, left: mousex });
	});
});