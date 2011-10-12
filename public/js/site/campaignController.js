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
	log("current left value: "+ $('#lookbook_container').css('left') );
	//find new offset
	var offset = $('#lookbook_container').css('left') -1024;
	
	//go
	$('#lookbook_container').animate({'left':offset}, campaign.onAnimateIn);
}//end next handler