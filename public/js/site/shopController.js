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
		//	$('#s_shop .section-content').animate({height: $('#shop_grid').height()});
		
		}else{
			$('.section-content-wrapper').css('left',"-786px");
			$('#s_shop .section-content').css('height', "580px");
			//$('#s_shop, #s_shop .section-content').fadeIn();
		
		}
		
	}else {
		log("shop root");
		//were we just at a product and are we offset to see product?
		//if yes, slide back
		//if no, this is the first time we're seeing this, reset back to original
		if( $('#s_shop').css('display') == "block" && $('.section-content-wrapper').css('left') == "-786px" ){
			
			$('.section-content-wrapper').animate({left:"0"});
			$('#s_shop .section-content').animate({height: $('#shop_grid').height()});
		}else{
			$('.section-content-wrapper').css('left',"0");
			$('section, #s_loader, #s_shop .section-content, #s_shop .right-img, .section').hide();
			$('#s_shop').show('slow', function(){$('#s_shop .section-content:not(#product_detail)').show('fast', function(){$('#s_shop .right-img').show();});});
		}
	}//endif
}//end change function

shopController.onProductAJAXComplete	= function ($data) {
	
	//oc: convert to xml and just populate markup with data values of the product
	$('#s_loader').fadeOut('fast', function($e){$('#s_shop, #s_shop .section-content').fadeIn(); });
	$('#product_detail').html($data);
	
	//set initial values in data
	shopController.setId();
	shopController.setQuantity();
	$("#sidenav_"+mainController.dlArr[3]).addClass('active');
	
	//addHandlers
	$('#size').change(shopController.setId);
	$('#quantity').change(shopController.setQuantity);
	
	$('#add_to_cart_btn').click(function($e){
		
		$('#product_data').data('size', $('#size option').eq($('#size').val()).attr('label'));
		var url			= "shopping-cart/add";
		var data		= {itemToAdd: $('#product_data').data()};
		var success 	= function ($d){ mainController.cart.onAJAXComplete($d);};
		var datatype	= "json";
			
		$.post(url, data, success, datatype);
		
		return false;
		
	});

};

shopController.setId			= function($e){
	
	var data 	= $('#product_data').data();
	var pid		= data[$('#size option').eq($('#size').val()).attr('label')];
	log("product id: "+pid);
	$('#product_data').data('id', pid);
	
};
shopController.setQuantity			= function($e){
	
	$('#product_data').data('quantity', parseInt($('#quantity').val()));
	
};