//init global vars
var mainController 				= {};//object to hold all deeplink data
mainController.which_content 	= "";//overlay to show
mainController.dlArr			= [];//array of deeplinks
mainController.cart				= {};//cart object contains all stuff related to the cart :)
mainController.cart.isOpen		= false;
mainController.cart.isEmpty		= true;
mainController.cart.defaultCSS	= {	width: "155px", 
									height:"23px"
								};
mainController.cart.emptytCSS	= {	width: "226px", 
									height:"131px"
								};
mainController.cart.emptyText	= "<h2>Your shopping cart is empty.</h2>";

var shopController				= {};
var campaign					= {};

//*****************************************************
//oc: Address Change Handler Functions
//*****************************************************
mainController.init 	= function (){
	
	log("init site: "+ $.address.value());
	
	$.address.init(function(){}).change(mainController.change).tracker(mainController.track);//end address change function
	//.internalChange(mainController.inChange)
	//.externalChange(mainController.exChange);
	
	//init sections
	shopController.init();
	campaign.init();
	
	//browser resize
	$(window).resize(mainController.handleResize);
	
	//determine if cart is empty
	mainController.cart.isEmpty = $('.cart-contents ul li').length == 0 ? true : false;
	
};//end init

mainController.inChange 	= function ($e){
	log("internal change");
	
};//end function internal change

mainController.exChange 	= function ($e){
	log("external change");
	
};//end function external change

mainController.change 	= function ($e){

	//enable deeplinking if we're not at checkout
	if ($.address.baseURL().contains("checkout")){
		log('checkout')
		switch ($.address.value()){
			case "/" : log("we're at checkout base");
				mainController.cart.open();
				break;
			case "/complete" : log("checkout complete");
				break;
			default: 
				var url = $.address.baseURL().replace('/checkout', "") +$.address.value();
				window.location = url;
		}//endswitch
	}else if ($.address.baseURL().contains("admin")){
		switch ($.address.value()){
			case "/" : log("we're at admin base");
				adminController.init();
				//mainController.cart.open();
				break;
			case "/edit-product" : log("checkout complete");
				break;
			default: 
				var url = $.address.baseURL().replace('/admin', "") +$.address.value();
				window.location = url;
		}//endswitch
	}else{
		
	log("change proper");
	
		mainController.cart.close();
		
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
	}//end if

	
}//end address change function



//*****************************************************
//oc: Handler for the Homepage initial display
//*****************************************************
mainController.homeHandler = function(){
	log("we're home");
	
	//todo: put flash on page if possible.
	$('#s_loader, section, .section').hide();
	var flashvars 	= {baseUrl:$.address.baseURL()};
	var params 		= {};
	params.menu 	= "false";
	params.quality 	= "high";
	params.wmode	= "transparent";
	var attributes 	= {class:"section"};
	swfobject.embedSWF("/swf/ncLoader.swf",
	"s_home", "1024", "619",
	"9.0.0", false, flashvars, params, attributes);
	

	//oc: resume previous state of the homepage
	$('#s_home').fadeIn("slow");//show home overlay


}//end function homeHandler

//********************************************************************
//oc: Learn Handler
//********************************************************************
mainController.learnHandler = function(){

	//hide stuff
	$('#s_loader, #s_learn .section-content, section, .section').hide();
	//show learn elements the way i want.
	$('#s_learn').show('slow', function(){$('#s_learn .section-content').fadeIn('fast');});
	
	
}//end function defaultHandler
//********************************************************************
//oc: Contact Handler
//********************************************************************
mainController.contactHandler = function(){
	log("contact bang");
	
	$('#s_loader, #s_contact .section-content, section, .section').hide();
	$('#s_contact').show('slow', function(){$('#s_contact .section-content').fadeIn('fast');});
	
}//end function contactHandler

//********************************************************************
//oc: Default Handler
//********************************************************************
mainController.defaultHandler 	= function ($whichSection){
	
	var section = "#s_" + $whichSection;
	log("defaultHandler: "+section);
	
	$('#s_loader, section, '+ section+' .section-content, .section').hide();
	$(section).show('slow', function(){$("#s_"+mainController.dlArr[0] +' .section-content').fadeIn('fast');});
	
}//end function

//*****************************************************
//oc: Shopping Cart JS
//*****************************************************
mainController.cart.open 		= function ($e){
	log("open, cart-contents height: "+$('.cart-contents').height());
	//if (!mainController.cart.isOpen){
		
		var newHeight = $('.cart-contents').height() + 95;//checkout button height plus whatever's in the cart.
		var aniObj	= 	mainController.cart.isEmpty ? mainController.cart.emptytCSS : {height:newHeight+"px",width:"226px"};
		
		$('#cart_pulldown').animate(aniObj, function(){ 
			$('.cart-contents, #cart_pulldown').fadeIn('fast'); 
			if(mainController.cart.isEmpty == false)	$('.checkout-btn').fadeIn('fast'); 
		});
		$('#open_close').css('background-position','-10px 0').attr('title', 'Close Cart');
		mainController.cart.isOpen = true;
	//}else{
		
		
}//end function
mainController.cart.close 		= function ($e){
	log("close");
	if (mainController.cart.isOpen){
		$('.cart-contents, #cart_pulldown .checkout-btn').fadeOut('fast');
		$('#cart_pulldown').animate(mainController.cart.defaultCSS);
		$('#open_close').css('background-position','0 0').attr('title', 'Open Cart');
		
		mainController.cart.isOpen = false;
	}//endif
	
}//end function

mainController.cart.onAJAXComplete	= function ($cart){
	
	var subTotal 	= $cart.subTotal;
	var items		= $cart.items;
	log(items);
	//put items in the cart if they exist, otherwise handle an empty cart
	if (items.length > 0){
		mainController.cart.isEmpty = false;
		var cartContent = "<ul>";
		for(var i=0; i< items.length; i++){	cartContent += mainController.cart.itemFactory(items[i]);}
		cartContent 	+= "<li class='subtotal'>subtotal: <span class='right'>$"+subTotal+"</li>";
		cartContent		+= "</ul>";
		$('.cart-contents').html(cartContent);
	}else{
		mainController.cart.isEmpty = true;
		$('.checkout-btn').fadeOut('fast');
		$('.cart-contents').html(mainController.cart.emptyText);
	}	
	
	//handlers on new cart
	mainController.cart.addHandlers();
	
	mainController.cart.open();
}
mainController.cart.itemFactory				= function ($i){
	//log($i);	
	var item 	= "<li class='item' data-Id='"+$i.id+"'>";
	item	   += "<p>"+$i.name+"</p><p>"+$i.size+" x"+$i.quantity+" <span class='remove-item'>Remove</span>";
	item	   += "<span class='right'>$"+$i.price+"</span>";
	item	   += "</p></li>";
	return item
}
mainController.cart.removeItem				= function ($e){
	var item = $(this).parents('li').data();
	log("remove: "+ item['id']);
	
	var url			= "shopping-cart/remove";
	var data		= {itemToRemove: item['id']};
	var success 	= function ($d){ mainController.cart.onAJAXComplete($d);};
	var datatype	= "json";
		
	$.post(url, data, success, datatype);
}
mainController.cart.addHandlers				= function(){
	
	$('.remove-item').bind('click', mainController.cart.removeItem);
//	$('.checkout-btn').bind('click', function($e){	});

}
//*****************************************************
//oc: Resize
//*****************************************************
mainController.handleResize 	= function ($e){
	var w		= window.innerWidth;
	log('resize. window width: '+w);
	if (w > 1024 + 96* 2){
//		$('#prev_arrow').animate({left: "-96px"});
//		$('#next_arrow').animate({right: "-96px"});
	}

}	

//*****************************************************
//oc: Tracker
//*****************************************************
mainController.track = function (){
	log("track: "+$.address.value());
//	_gaq.push(['_trackPageview', $.address.value()]);
}