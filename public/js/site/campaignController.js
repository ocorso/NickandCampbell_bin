campaign.change = function (){
	log("campaign change");
	$('#s_loader, #s_campaign .section-content, section, .section').hide();
	
	//embed flash 
	var flashvars 	= {baseUrl:$.address.baseURL()};
	var params 		= {};
	params.menu 	= "false";
	params.quality 	= "high";
	params.wmode	= "transparent";
	var attributes 	= {class:"section"};
	swfobject.embedSWF("/swf/ncCampaign.swf",
	"s_campaign", "1024", "619",
	"9.0.0", false, flashvars, params, attributes);
	
	//show div
	$('#s_campaign').show('slow', campaign.addListeners);
}

campaign.init = function (){
	//todo: create a horizontal viewing system.
	campaign.curPage 	= mainController.dlArr[1];
	campaign.leftOffset	=  parseInt($('#lookbook_container').css('left'));
	log("campaign init, left offset: "+campaign.leftOffset);
}

campaign.addListeners = function(){
	log("addListeners");
	
//	$('#lookbook_container, .arrow').hover(
//			function(){$('.arrow').fadeIn();},
//			function(){$('.arrow').fadeOut();}
//	);
	
	$('#next_arrow').bind('click', campaign.nextHandler);
	$('#prev_arrow').bind('click', campaign.prevHandler);
}

campaign.removeListeners = function(){
	$('#next_arrow, #prev_arrow').unbind();
}

campaign.nextHandler = function($e){
	log ("nextClick");
	
	//make sure they don't keep clicking
	campaign.removeListeners();
	
	//find new offset
	campaign.leftOffset -= 1024;
	log("offset: "+campaign.leftOffset );
	
	//go
	$('#lookbook_container').animate({'left':campaign.leftOffset}, campaign.addListeners);
}//end next handler
campaign.prevHandler = function($e){
	log ("prevClick");
	
	//make sure they don't keep clicking
	campaign.removeListeners();
	//find new offset
	campaign.leftOffset += 1024;
	log("offset: "+campaign.leftOffset );
	
	//go
	$('#lookbook_container').animate({'left':campaign.leftOffset}, campaign.addListeners);
}//end prev handler
