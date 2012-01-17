coController = {};
coController.isBillSame	= false;
coController.stateArr = ['shipping1', 'shipping2','billing1, billing2'];



//=================================================
//================ Callable
//=================================================
coController.addHandlers = function(){
	
	$('#co_next').bind("click", coController.onNextClick);
	$('#co_prev').bind("click", coController.onPrevClick);
	
};

coController.removeHandlers = function(){
	
	$('#co_next').unbind("click", coController.onNextClick);
	$('#co_prev').unbind("click", coController.onPrevClick);
	
};  
//=================================================
//================ Workers
//=================================================
coController.copyAddress = function(){
	coController.isBillSame =	coController.isBillSame ? false : true;
	log("copy Address? "+ 	coController.isBillSame);
	
	if (coController.isBillSame){
		$('#billing1-bill_addr1').val($('#shipping1-sh_addr1').val());
		$('#billing1-bill_addr2').val($('#shipping1-sh_addr2').val());
		$('#billing1-bill_city').val($('#shipping1-sh_city').val());
		$('#billing1-bill_state').val($('#shipping1-sh_state').val());
		$('#billing1-bill_zip').val($('#shipping1-sh_zip').val());
	}else{
		$('#billing1-bill_addr1').val("");
		$('#billing1-bill_addr2').val("");
		$('#billing1-bill_city').val("");
		$('#billing1-bill_state').val("");
		$('#billing1-bill_zip').val("");
		
	}
	
};    
coController.disableArrow 	= function ($arrow){
	log("disable: "+$arrow);
	$($arrow).unbind('click').css({'opacity': .2, 'cursor': 'mouse'});
}; 
coController.enableArrow 	= function ($arrow){
	log("enable: "+$arrow);
	var a = $($arrow);
	switch($arrow){
		case "#co_prev": a.bind("click", coController.onPrevClick); break;
		case "#co_next": a.bind("click", coController.onNextClick); break;
		default : log("ERROR unknown arrow to enable");
	}
	a.css({'opacity': 1, 'cursor': 'pointer'});
}; 
//=================================================
//================ Handlers
//=================================================
coController.onPrevClick = function($e){
	log('Prev Click, left off: '+$('#checkout_form .zend_form').css("left"));
	
	//don't double click. 
	coController.removeHandlers();
	
	//todo: validate current state and then move on.
	$('#checkout_form .zend_form').animate({"left": "+=600"}, coController.addHandlers);
	
};
coController.onNextClick = function($e){
	log('Next Click  left off: '+$('#checkout_form .zend_form').css("left"))
	
	//don't double click. 
	coController.removeHandlers();
	
	//todo: validate current state and then move on.
	$('#checkout_form .zend_form').animate({"left": "-=600"}, coController.addHandlers);
};     
//=================================================
//================ Animation
//=================================================


//=================================================
//================ Getters / Setters
//=================================================
     
//=================================================
//================ Initialize
//=================================================
     coController.init = function (){
    	 
    	log('init');

    	//copy shipping address into billing.
    	$('#billing1-bill_as_ship').click(coController.copyAddress);
    	
    	//make checkout button in shopping cart disabled:
    	$('.checkout-btn').click(function($e){
    		$e.preventDefault();
    		$('#s_checkout h3').css({'color': "red"});
    		return false;
    	});
    	$('#checkout_form .zend_form').fadeOut('fast');
    	
    	$('#checkout_form').fadeOut("fast",  coController.createForm);
     };
//=================================================
//================ Core Handler
//=================================================
     coController.createForm = function (){
    	 var coFormCSS		= {	'width': 600,
    			 'height': 500,	
    			 'overflow': 'hidden',
    			 'position': 'relative'
    	 };
    	 
    	 var coSlidingDivCSS 	= {	'position':'absolute', 
    			 'width': 3000
    	 };
    	 $('.co-arrow, #indicator_list').fadeIn('slow');
    	 $('#checkout_form').css(coFormCSS).fadeIn();
    	 $('#checkout_form .zend_form').css(coSlidingDivCSS).fadeIn();
    	 
    	 //todo: add next trigger on appropriate focus change.
     };
//=================================================
//================ Overrides
//=================================================
     
//=================================================
//================ Doc Ready
//=================================================


//*****************************************************
//oc: checkout functions
//*****************************************************




//*****************************************************
//oc: checkout ready
//*****************************************************
jQuery(function($) {
	log("checkout doc ready");
	coController.init();
	coController.addHandlers();
	
});