campaign.change = function (){
	log("campaign change");
	$('section, #s_loader').hide();
	$('#s_campaign').show('slow', campaign.onAnimateIn);
}

campaign.init = function (){
	//todo: create a horizontal viewing system.
	campaign.curPage = mainController.dlArr[1];
}

campaign.onAnimateIn = function(){
	log("onAnimateIn");
	
	$('#lookbook_container, .arrow').hover(
			function(){$('.arrow').fadeIn();},
			function(){$('.arrow').fadeOut();}
	);
	
	$('#next_arrow').bind('click', campaign.nextHandler);
}

campaign.removeListeners = function(){
	$('#next_arrow').unbind();
}

campaign.nextHandler = function($e){
	log ("nextClick");
	
	//make sure they don't keep clicking
	campaign.removeListeners();
	//find new offset
	var offset = parseInt($('#lookbook_container').css('left')) - 1024;
	log("offset: "+offset );
	
	//go
	$('#lookbook_container').animate({'left':offset});
}//end next handler