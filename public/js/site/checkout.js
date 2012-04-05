coController = {};
coController.isBillSame	= false;


coController.states	 	= [{	'name':'shipping1',
								'id':'#fieldset-shipping1',
								'leftOffset':0
							},
                   	 	   {	'name':'shipping2',
								'id':'#fieldset-shipping2',
								'leftOffset':-590
                   	 	   	},
                   	 	   {	'name':'billing1',
                   	 	   		'id':'#fieldset-billing1',
               	 	   			'leftOffset':-1280
                   	 			   
                   	 	   	},
                   	 	   {	'name':'billing2',
                   	 	   		'id':'#fieldset-billing1',
	       	 			    	'leftOffset':-1847
                   	 	   	},
                   	 	   {	'name':'confirm',
                   	 	   		'id':'#fieldset-confirm',
                   	 	   		'leftOffset':-2422
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
		$('#billing1-addr1').val($('#shipping1-addr1').val());
		$('#billing1-addr2').val($('#shipping1-addr2').val());
		$('#billing1-city').val($('#shipping1-city').val());
		$('#billing1-state').val($('#shipping1-state').val());
		$('#billing1-zip').val($('#shipping1-zip').val());
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
	coController.animation.moveIndicator();
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
	coController.animation.moveIndicator();
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
			$('#checkout_form .zend_form').animate({"left": coController.states[coController.stateIndex].leftOffset}, coController.addHandlers);
			break;
		case "right":
			$('#checkout_form .zend_form').animate({"left": coController.states[coController.stateIndex].leftOffset}, coController.addHandlers);
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

coController.animation.moveIndicator = function (){
	log('move indicator');
	var leftOffset = "21%";
	switch(coController.curState){
		
		case coController.states[0].name:
			break;
		case coController.states[1].name:
			break;
		case coController.states[2].name:
			leftOffset = '38%';
			break;
		case coController.states[3].name:
			leftOffset = '38%';
			break;
		case coController.states[4].name:
			leftOffset = '55%';
			break;
		default: log("unknown indicator location");
		
	}//end switch
	$('#co_indicator').animate({'left':leftOffset});
};//end function

//=================================================
//================ Utility
//=================================================
coController.populateFakeData = function () {
	$('#shipping1-cust_first_name').val("Javascript");
	$('#shipping1-cust_last_name').val("tester");
	$('#shipping1-cust_email').val("owen@ored.net");
	$('#shipping1-cust_phone').val("2016020069");
	$('#shipping1-addr1').val("69 Javascript Lane");
	$('#shipping1-addr2').val("Suite 2");
	$('#shipping1-city').val("Franklin Lakes");
	$('#shipping1-zip').val("07417");
	$('#shipping1-state').val("NJ");
	
	$('#billing1-addr1').val("69 Javascript Lane");
	$('#billing1-addr2').val("");
	$('#billing1-city').val("Franklin Lakes");
	$('#billing1-state').val("NJ");
	$('#billing1-zip').val("07417");
	
	$('#billing2-name_on_card').val("Java M Script");
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