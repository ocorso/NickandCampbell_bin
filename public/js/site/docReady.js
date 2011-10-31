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
	
		$('.product a').click(function($e){
			$e.preventDefault();
			$('#product_detail').show();
			return false;
		});
		
		
	};//end function addSitehandlers
	
	log("doc is ready yo");
	mainController.init();
	addSiteHandlers();
});//end doc ready






