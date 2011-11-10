//init global vars
var mainController 				= {};//object to hold all deeplink data
mainController.which_content 	= "";//overlay to show
mainController.dlArr			= [];//array of deeplinks
mainController.cart				= {};//cart object contains all stuff related to the cart :)
mainController.cart.isCartOpen	= false;
mainController.cart.defaultCSS	= {	width: "155px", 
									height:"23px"
								};
var shopController				= {};
var campaign					= {};

//*****************************************************
//oc: Address Change Handler Functions
//*****************************************************
mainController.init 	= function (){
	
	log("init site");
	
	//enable deeplinking
	$.address.init(function(){})
	.change(mainController.change);//end address change function
	//.internalChange(mainController.inChange)
	//.externalChange(mainController.exChange);
	
	//init sections
	shopController.init();
	campaign.init();
	
	//browser resize
	$(window).resize(mainController.handleResize);
	
}//end init

mainController.inChange 	= function ($e){
	log("internal change");
	
}//end function internal change

mainController.exChange 	= function ($e){
	log("external change");
	
}//end function external change

mainController.change 	= function ($e){
	log("change proper");
	
	    //determine main nav
		mainController.dlArr 		= $.address.pathNames()[0] ? $.address.pathNames() : ["/"];//set deeplink if you can
		$('nav ul li a').removeClass('current-section');
		
   			
    		/*****************************************************
			* oc: EXPECTED PATHS FOR MAIN NAV:
			* $.address.pathNames()[0];
			*
			*	"/" OR "" 	= mainController.homeHandler()
			* 	"learn"		= mainController.defaultHandler()
			*	"campaign"	= campaign.change()
			*	"contact"	= mainController.contactHandler()	
			*	"shipping"	= mainController.defaultHandler()
			*	"returns"	= mainController.defaultHandler()
			*	"returns"	= mainController.defaultHandler()
			*
			//*****************************************************/           
            
            switch(mainController.dlArr[0]){
            
            	case "/":
            	case "" : 			$('#l-0').addClass('current-section').focus(); mainController.homeHandler(); break;//if we wrote new vid, we're not at orig home
            	case "learn":		$('#l-1').addClass('current-section').focus(); mainController.learnHandler(); break;//located in mapManager.js
               	case "shop": 		$('#l-2').addClass('current-section').focus(); shopController.change(); break;      	
				case "campaign": 	$('#l-3').addClass('current-section').focus(); campaign.change(); break;
				case "contact": 	$('#l-4').addClass('current-section').focus(); mainController.contactHandler(); break;
				case "shipping": 
				case "returns":
				case "sitemap": mainController.defaultHandler(mainController.dlArr[0]); break;
            	default : log("deeplink unexpected path...");//add greater than 1 level depth handling here...;

            }//end switch
    		
            //$('nav ul li a:not(.current-section)').unbind().hover(function(){$(this).addClass('current-section');},function(){$(this).removeClass('current-section');});

	
}//end address change function



//*****************************************************
//oc: Handler for the Homepage initial display
//*****************************************************
mainController.homeHandler = function(){
	log("we're home");
	
	$('#s_loader, section').hide();
	//hide main overlay
	$('#overlay').hide();

	//oc: resume previous state of the homepage
	$('#s_home').fadeIn("slow");//show home overlay


}//end function homeHandler

//********************************************************************
//oc: Learn Handler
//********************************************************************
mainController.learnHandler = function(){

	//hide stuff
	$('#s_loader, #s_learn .section-content, section').hide();
	//show learn elements the way i want.
	$('#s_learn').show('slow', function(){$('#s_learn .section-content').fadeIn('fast');});
	
	
}//end function defaultHandler
//********************************************************************
//oc: Contact Handler
//********************************************************************
mainController.contactHandler = function(){
	log("contact bang");
	
	$('#s_loader, #s_contact .section-content, section').hide();
	$('#s_contact').show('slow', function(){$('#s_contact .section-content').fadeIn('fast');});
	
}//end function contactHandler

//********************************************************************
//oc: Default Handler
//********************************************************************
mainController.defaultHandler 	= function ($whichSection){
	
	var section = "#s_" + $whichSection;
	log("defaultHandler: "+section);
	
	$('#s_loader, section, '+ section+' .section-content').hide();
	$(section).show('slow', function(){$("#s_"+mainController.dlArr[0] +' .section-content').fadeIn('fast');});
	
}//end function

//*****************************************************
//oc: Shopping Cart JS
//*****************************************************
mainController.cart.open 		= function ($e){
	log("open");
	var newHeight = parseInt($('.cart-contents').css('height').replace("px","")) + 50;
	var aniObj = {	height:newHeight+"px",
					width:"226px"
				};
	$('#cart_pulldown').animate(aniObj);
	$('#open_close').css('background-position','-10px 0');
	mainController.cart.isOpen = true;
}
mainController.cart.close 		= function ($e){
	log("close");
	$('#cart_pulldown').animate(mainController.cart.defaultCSS);
	$('#open_close').css('background-position','0 0');
	mainController.cart.isOpen = false;
}

mainController.onAddToCartAJAXComplete	= function ($data){
	
	//todo: update cart with current stuff and then open it.
	
}
//*****************************************************
//oc: Utility
//*****************************************************
mainController.handleResize 	= function ($e){
	var w		= window.innerWidth;
	log('resize. window width: '+w);
	if (w > 1024 + 96* 2){
//		$('#prev_arrow').animate({left: "-96px"});
//		$('#next_arrow').animate({right: "-96px"});
	}

}	

