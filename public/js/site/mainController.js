//init global vars
var mainController 				= {};//object to hold all deeplink data
mainController.which_content 	= "";//overlay to show
mainController.dlArr			= [];//array of deeplinks

//*****************************************************
//oc: Address Change Handler Function
//*****************************************************
mainController.init 	= function (){
	log("main init");
			    
			
			mainController.config();
			mainController.change();

}//end init

mainController.config = function (){
	
	log("config site");
	
	$.address.init(function(){})
	.change(mainController.change)//end address change function
	.internalChange(mainController.inChange)
	.externalChange(mainController.exChange);
	
}//end function config

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
			*	"shipping"		= mainController.mapHandler()
			*	"video"		= mainController.videoHandler()
			*
			//*****************************************************/           
            
            switch(mainController.dlArr[0]){
            
            	case "/":
            	case "" : 			$('#l-0').addClass('current-section').focus(); mainController.homeHandler(); break;//if we wrote new vid, we're not at orig home
            	case "learn":		$('#l-1').addClass('current-section').focus(); mainController.learnHandler(); break;//located in mapManager.js
               	case "shop": 		$('#l-2').addClass('current-section').focus(); newsManager.change(); break;      	
				case "campaign": 	$('#l-4').addClass('current-section').focus(); photosManager.change(); break;
				case "contact": 	$('#l-3').addClass('current-section').focus(); mapManager.change(mainController.dlArr[0]); mainController.defaultHandler(); break;
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
//oc: Default Handling for Main Nav ie: about, news, schedule
//********************************************************************
mainController.learnHandler = function(){
	log("learn bang");
	
	$('section').hide();
	//show main overlay
	mainController.showOverlay();
	
	//$('#s_learn').show('slow');
	
}//end function defaultHandler



//*****************************************************
//oc: Utility
//*****************************************************
mainController._writeNewVideo = function ($v){
log("name of vid: "+ $v);

	$('#movie,.ghinda-video-controls').remove();
	$('#video-extras').append("<div class=\"ghinda-video-controls\">" +
											"<a class=\"ghinda-video-play\" title=\"Play/Pause\"></a>" +
											"<div class=\"ghinda-video-seek\"></div>" +
											"<div class=\"ghinda-video-timer\">00:00</div>" +
											"<div class=\"ghinda-volume-box\">" +
												"<div class=\"ghinda-volume-slider\"></div>" +
													"<a class=\"ghinda-volume-button\" title=\"Mute/Unmute\"></a>" +
												"</div>" +
											"</div>");
	$('.ghinda-video-player').prepend("<video id=\"movie\" class=\"change\" poster='images/video-posters/"+$v+"-poster.jpg' preload controls >" +
													"<source src=\""+ vidManager.cdnPrefix + $v + ".mp4\" />" + 
													"<source src=\""+ vidManager.cdnPrefix + $v + ".webm\" />" + 
													"<source src=\""+ vidManager.cdnPrefix + $v + ".ogv\" />" + 
												"</video>");
	
	//set newly created vid to our global var
	vidManager.video = document.getElementsByTagName('video')[0];
	
	//re-init video
	$('#movie').gVideo();
	
	//resize now that we manipulated the DOM
	windowSize();
	
}//end function writeNewVideo

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

//
//this function removes the home page presentation layer attributes
//
mainController.disableHome = function ($e){

	$('#home_overlay, #home_poster').hide(); 
	$('.ghinda-video-player').addClass('controls-hideable');
	vidManager.isPlaying = true;
	
	//play vid if poster_image was clicked
	if ($(this).attr('id') == "home_poster") 
		jw ? jwplayer('jw').play() : vidManager.video.play();
	
	//ored: hide controls and carousel on play.
	if (isiPad){
		$('#video-extras, #gallery-strip').hide();
	}
	//change home deeplink to video
	if (mainController.dlArr[0] == "home") $.address.value("/video/"+vidManager.name)
	
	
	
}//end function disableHome

mainController.enableHome = function ($e){

	log("enable home");
	
	//pause the vid.
	jw ? jwplayer('jw').pause(true) : vidManager.video.pause(); 
	vidManager.isPlaying = false;
	mainController.homeHandler();

}//end function enableHome


function updateShare(){

		var url_location = $.address.baseURL() + $.address.path();
		
		$('footer a').attr("target","_blank");
		
		//twitter
		$('#l-s-a').attr("href",'http://twitter.com/home?status=My%20Decision' + url_location +'&t=My%20Decision')

		// fb
		$('#l-s-b').attr("href",'http://www.facebook.com/sharer.php?u=' + url_location +'&t=My%20Decision');

		// delicious
		$('#l-s-c').attr("href",'http://del.icio.us/post?url=' + url_location + '&title=My%20Decision');

}