/* Author: Owen Corso

*/
//*******************************************************************************
// 			*** DOC Ready ***
//*******************************************************************************

jQuery(function($) {
    
	var addSiteHandlers = function(){
		log("addHandlers");
	//	if (coController) coController.addHandlers();
		
		//main logo fade to red.
		$("#logo").hover(
				function () {
					    $("#logo_on").fadeIn('fast');
					  }, 
				function () {
					    $("#logo_on").fadeOut('fast');
					  }
		);//end hover
		
		//flip toggle cart handle
		$("#open_close").hover(
				function () {
					var attr = mainController.cart.isOpen ? "-10px -9px": "0 -9px";
					$("#cart_pulldown span.cart-arrow").css('background-position', attr);
				}, 
				function () {
					var attr = mainController.cart.isOpen ? "-10px 0px": "0 0px";
					$("#cart_pulldown span.cart-arrow").css('background-position', attr);
				}
		);//end hover
		
		$("#open_close").click(function ($e){
			mainController.cart.isOpen ? mainController.cart.close($e) : mainController.cart.open($e);	
			$e.preventDefault();
//			return false;
		});
		
		//cart handlers
		mainController.cart.addHandlers();
		
	};//end function addSitehandlers
	
	log("doc is ready yo");
	addSiteHandlers();
	mainController.init();
});//end doc ready






