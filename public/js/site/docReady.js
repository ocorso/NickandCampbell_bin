/* Author: Owen Corso

*/
//*******************************************************************************
// 			*** DOC Ready ***
//*******************************************************************************

jQuery(function($) {
    
	var addSiteHandlers = function(){
		log("addHandlers");
		
		$("#logo").hover(
				function () {
					    $("#logo_on").fadeIn('fast');
					  }, 
				function () {
					    $("#logo_on").fadeOut('fast');
					  }
		);//end hover
	
	};//end function addSitehandlers
	
	log("doc is ready yo");
	mainController.init();
	addSiteHandlers();
});//end doc ready






