/**
 * @author Owen Corso
 */

// =================================================
// ================ Initialize
// =================================================
campaign.init = function (){

	campaign.slides = $("#lookbook_container img");
	log("campaign init. total pages: "+campaign.slides.length);
};


// =================================================
// ================ Callable
// =================================================
campaign.change = function (){
	
	//oc: set curPage using query string
	campaign.curPage 	= $.address.parameter('page') ?$.address.parameter('page') : 1;
	log("campaign change. curPage: "+campaign.curPage);
	
	//show div if necessary
	if( $('#s_campaign').css('display') == "block"){
		campaign.animation.slide();
	}else{
		campaign.animation.show();
	} 
};
// =================================================
// ================ Workers
// =================================================
campaign.addListeners = function(){
	$('.campaign-arrow').unbind();
	
	//config next.
	log("addListeners, max: "+campaign.slides.length);
	if (campaign.curPage >= campaign.slides.length){
		$('#next_arrow').addClass('inactive');
	}else{
		$('#next_arrow').removeClass('inactive').bind('click', campaign.nextHandler);
	}

	//config prev.
	if (campaign.curPage == 1){
		$('#prev_arrow').addClass('inactive');
	}else{
		$('#prev_arrow').removeClass('inactive').bind('click', campaign.prevHandler);
	}

	//oc: TODO make scroller handle swipe touch event.
	$('#campaign_scroller').bind('mousedown', campaign.scroller.onMouseDown);
};

campaign.removeListeners = function(){
	log("campaign removeListeners")
	$('#next_arrow, #prev_arrow').unbind();
};

campaign.getOffset = function(){
	
	var multiplier 		= campaign.curPage-1;
	campaign.leftOffset =  multiplier * -789;
	log("offset: "+campaign.leftOffset );
	
};
// =================================================
// ================ Handlers
// =================================================
campaign.nextHandler = function($e){
	log ("nextClick");
	
	//make sure they don't keep clicking
	campaign.removeListeners();
	campaign.curPage++;
	$.address.parameter('page', campaign.curPage);
	
};//end next handler
campaign.prevHandler = function($e){
	log ("prevClick");
	
	//make sure they don't keep clicking
	campaign.removeListeners();
	//find new offset
	campaign.curPage--;
	$.address.parameter('page', campaign.curPage);
	
};//end prev handler

campaign.scroller.onMouseDown	= function ($e){
	log("mouse down");
	$('#campaign_scroller').bind('mousemove', campaign.scroller.onMouseMove);
	$('#campaign_scroller').bind('mouseup', campaign.scroller.onMouseUp);
	return false;
};
campaign.scroller.onMouseMove	= function ($e){
	$(this).css('left', $e.pageX);
	return false;
};
campaign.scroller.onMouseUp	= function ($e){
	log("mouse up");
	$(this).unbind().bind('mousedown', campaign.scroller.onMouseDown);
	return false;
};
        
// =================================================
// ================ Animation
// =================================================
campaign.animation.show			= function (){
	log("campaign show");
	
	$('#s_loader, #s_campaign .section-content, section, .section').hide();
	if (campaign.curPage == 1) 	$('#s_campaign').show('slow', campaign.addListeners);
	else 						$('#s_campaign').show('slow', campaign.animation.slide);
};

campaign.animation.slide 		= function ($e){
	log("campaign slide");
	
	//calc how far to move
	campaign.getOffset();
	//go
	$('#lookbook_container').animate({'left':campaign.leftOffset}, 1500, "easeInOutQuint",campaign.addListeners);
};