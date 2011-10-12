//init global vars
var mainController 				= {};//object to hold all deeplink data
mainController.which_content 	= "";//overlay to show
mainController.dlArr			= [];//array of deeplinks

var shopController				= {};
var campaign					= {};

//*****************************************************
//oc: Address Change Handler Functions
//*****************************************************
mainController.init 	= function (){
	
	log("init site");
	
	$.address.init(function(){})
	.change(mainController.change);//end address change function
	//.internalChange(mainController.inChange)
	//.externalChange(mainController.exChange);
	
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
	//only do stuff when json is done parsing
	
	
	    //determine main nav
		mainController.dlArr 		= $.address.pathNames()[0] ? $.address.pathNames() : ["/"];//set deeplink if you can
		$('nav ul li a').removeClass('current-section');
		$('#s_loader').show();
   			
    		/*****************************************************
			* oc: EXPECTED PATHS FOR MAIN NAV:
			* $.address.pathNames()[0];
			*
			*	"/" OR "" 	= mainController.homeHandler()
			* 	"learn"		= mainController.defaultHandler()
			*	"campaign"	= newsManager.change()
			*	"contact"	= mainController.defaultHanlder()	
			*	"shipping"	= mainController.mapHandler()
			*	"returns"	= mainController.videoHandler()
			*
			//*****************************************************/           
            
            switch(mainController.dlArr[0]){
            
            	case "/":
            	case "" : 			$('#l-0').addClass('current-section').focus(); mainController.homeHandler(); break;//if we wrote new vid, we're not at orig home
            	case "learn":		$('#l-1').addClass('current-section').focus(); mainController.learnHandler(); break;//located in mapManager.js
               	case "shop": 		$('#l-2').addClass('current-section').focus(); shopController.change(); break;      	
				case "campaign": 	$('#l-4').addClass('current-section').focus(); campaign.change(); break;
				case "contact": 	$('#l-3').addClass('current-section').focus(); mainController.contactHandler(); break;
            	default : log("deeplink unexpected path...");//add greater than 1 level depth handling here...;

            }//end switch
	
	
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
	
}//end function defaultHandler



//*****************************************************
//oc: Utility
//*****************************************************

//
//this function shows the main content overlay and div 
//
mainController.showOverlay = function (){
	
	//hide home_overlay
	$('#home_overlay, #home_poster, #video-extras, #gallery-strip').hide();
	
	mainController.which_content 	= "#content-" + mainController.dlArr[0];

	if ($('#overlay').is(':hidden'))	$('#overlay').fadeIn();
	if ($(mainController.which_content).is(':hidden'))	{
		$('.section').hide();
		$(mainController.which_content).fadeIn(300,function(){
		
			//bring in maps now that their able to have focus
			mapManager.init();
		 	
		 	//oc: custom scrollbars
		 	$('.scroll-pane').jScrollPane({showArrows: true});//oc: autoReinitialise: true to do all the time  

			//oc: init gallery hoverscroll
			$('.photos').hoverscroll({
				width: '720',
				height: '60',
				debug:false//debug:true
			});

	});
	}//end show proper .section

}//end function show overlay
mainController.handleResize 	= function ($e){
	log('resize');
}	

