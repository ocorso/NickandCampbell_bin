shopController.init		= function (){
	log("shopController init");
	
//	$('.product a').address(function($e){
//		return $(this).attr('href').replace(/^#/, '');
//	});
	
	
}

shopController.change 	= function (){
	
	if (mainController.dlArr[3]){
		
		//we are at a product
		log("product: "+ mainController.dlArr[3]);
		
		//get product info
		var ajaxObj = {
				url: 		$.address.baseURL() + $.address.path(),
				success: 	shopController.onProductAJAXComplete
			};
		$.ajax(ajaxObj);
		
		//were we already at shop?
		//if so, animate
		//if not, set css and fade in.
		if( $('#s_shop').css('display') == "block"){
			$('.section-content-wrapper').animate({left:"-786px"});
			$('#s_shop .section-content').animate({height: "580px"});
		
		}else{
			$('.section-content-wrapper').css('left',"-786px");
			$('#s_shop .section-content').css('height', "580px");
			$('#s_shop, #s_shop .section-content').fadeIn();
		
		}
		
	}else {
		log("shop root");
		//were we just at a product and are we offset to see product?
		//if yes, slide back
		//if no, this is the first time we're seeing this, reset back to original
		if( $('#s_shop').css('display') == "block" && $('.section-content-wrapper').css('left') == "-786px" ){
			
			$('.section-content-wrapper').animate({left:"0"});
			$('#s_shop .section-content').animate({height: "580px"});
		}else{
			$('.section-content-wrapper').css('left',"0");
			$('section, #s_loader, #s_shop .section-content, #s_shop .right-img').hide();
			$('#s_shop').show('slow', function(){$('#s_shop .section-content:not(#product_detail)').show('fast', function(){$('#s_shop .right-img').show();});});
		}
	}//endif
}//end change function

shopController.onProductAJAXComplete	= function ($data) {
	
	//todo: convert to xml and just populate markup with data values of the product
	$('#s_loader').fadeOut();
	$('#product_detail').html($data);

};