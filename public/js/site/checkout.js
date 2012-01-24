coController = {};
coController.isBillSame	= false;


coController.states	 	= [{	'name':'shipping1',
								'id':'#fieldset-shipping1',
								'leftOffset':0
							},
                   	 	   {	'name':'shipping2',
								'id':'#fieldset-shipping2',
								'leftOffset':-620
                   	 	   	},
                   	 	   {	'name':'billing1',
                   	 	   		'id':'#fieldset-billing1',
               	 	   			'leftOffset':-1240
                   	 			   
                   	 	   	},
                   	 	   {	'name':'billing2',
                   	 	   		'id':'#fieldset-billing1',
	       	 			    	'leftOffset':-1860
                   	 	   	},
                   	 	   {'name':'confirm',
               	 	   		'id':'#fieldset-confirm'
                   	 		
                   	 	   }
];
coController.stateIndex	= 0;
coController.curState	= coController.states[0].name;
coController.animation	= {};
coController.focus		= {};
coController.disabledArrowCSS= {'opacity': .2, 	'cursor': 'default'};
coController.enabledArrowCSS= {	'opacity': 1, 	'cursor': 'pointer'};
//=================================================
//================ Callable
//=================================================
coController.addHandlers = function(){
	
	switch (coController.curState){
	 
		case coController.states[0].name:

			log("next is good to go, prev isn't");
			$('#co_next').bind("click", coController.onNextClick).css(coController.enabledArrowCSS);
			coController.disableArrow("#co_prev");
			break;
		case coController.states[4].name:
			
			log("prev is good to go, next isn't");
			coController.disableArrow("#co_next");
			$('#co_prev').bind("click", coController.onPrevClick).css(coController.enabledArrowCSS);
			break;
		default:

			$('#co_prev').bind("click", coController.onPrevClick).css(coController.enabledArrowCSS);
			$('#co_next').bind("click", coController.onNextClick).css(coController.enabledArrowCSS);
	
	}//endswitch
	
	
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
	$($arrow).unbind('click').css(coController.disabledArrowCSS);
}; 

//=================================================
//================ Handlers
//=================================================
coController.onPrevClick = function($e){
	log('Prev Click, left off: '+$('#checkout_form .zend_form').css("left"));
	
	//update current postiion
	if(coController.stateIndex >0 ) coController.stateIndex -=1;
	coController.curState	= coController.states[coController.stateIndex].name;
	//don't double click. 
	coController.removeHandlers();
	
	//todo: validate current state and then move on.
	coController.animation.moveStates("right"); 
	coController.animation.moveArrows();
};
coController.onNextClick = function($e){
	log('Next Click  left off: '+$('#checkout_form .zend_form').css("left"))
	
	if(coController.stateIndex < 4 ) coController.stateIndex +=1;
	coController.curState	= coController.states[coController.stateIndex].name;
	//don't double click. 
	coController.removeHandlers();
	
	//todo: validate current state and then move on.
	//todo: resize element containers on cart construction and state change
	coController.animation.moveStates("left"); 
	coController.animation.moveArrows();
};

coController.onShippingTypeClick = function ($e){
	log("shipping type: "+$(this).attr('id'));
	
};

coController.focus.onShipping2	= function($e){
	log("focus");
	
};
//=================================================
//================ Animation
//=================================================
coController.animation.moveStates = function ($direction){
	var offset = "do something";
	switch($direction){
	case "left":
		$('#checkout_form .zend_form').animate({"left": "-=620"}, coController.addHandlers);
		break;
	case "right":
		$('#checkout_form .zend_form').animate({"left": "+=620"}, coController.addHandlers);
		break;
		default : log("XXXERRORXXXXX: unknown direction to move the states carousel");
	}//endswitch
};

coController.animation.moveArrows = function (){
	log('move arrows. curFieldset height of '+coController.states[coController.stateIndex].id+': '+ $(coController.states[coController.stateIndex].id).height());
	var marginTop 	= $(coController.states[coController.stateIndex].id).height();
	marginTop		= (marginTop - $('.co-arrow').height())/2 +20;
	var opts 		= {'margin-top': marginTop};
	$('.co-arrow').animate(opts);
};

//=================================================
//================ Utility
//=================================================
coController.populateFakeData = function () {
	$('#shipping1-cust_first_name').val("Owen");
	$('#shipping1-cust_last_name').val("Corso");
	$('#shipping1-cust_email').val("owen@ored.net");
	$('#shipping1-cust_phone').val("2016020069");
	$('#shipping1-sh_addr1').val("281 Stewart Lane");
	$('#shipping1-sh_city').val("Franklin Lakes");
	$('#shipping1-sh_zip').val("07417");
	$('#shipping1-sh_state').val("NJ");
	
	$('#billing1-bill_addr1').val("281 Stewart Lane");
	$('#billing1-bill_addr2').val("");
	$('#billing1-bill_city').val("Franklin Lakes");
	$('#billing1-bill_state').val("NJ");
	$('#billing1-bill_zip').val("07417");
	
	$('#billing2-name_on_card').val("Owen M Corso");
	$('#billing2-card_type').val(1);
	$('#billing2-card_num').val(6011000000000012);
	$('#billing2-ccv').val(123);
	$('#billing2-exp_date').val("04/2015");
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
    	 
    	 $('.co-arrow, #indicator_list').fadeIn('slow', coController.animation.moveArrows);
    	 $('#checkout_form').css(coFormCSS);
    	 $('#checkout_form .zend_form').css(coSlidingDivCSS).fadeIn();
    	 
    	 //todo: add next trigger on appropriate focus change.
    	 $('#co_carousel').fadeIn();
     };
     
//=================================================
//================ Initialize
//=================================================
     coController.init = function (){
    	 
    	 log('init');
    	 
    	 //speed things up for debugging.
    	 $('.debug-radio').click(coController.populateFakeData);
    	 
    	 //shipping types?
    	 $(".co-shipping-type").click(coController.onShippingTypeClick);
    	 $("#shipping2-sh_type1").focus(function($e){ $('#co_next').trigger('click');});
    	 
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
//================ Doc Ready
//=================================================

jQuery(function($) {
	log("checkout doc ready");
	coController.init();
	coController.addHandlers();
	
});