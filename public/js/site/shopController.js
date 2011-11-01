shopController.init		= function (){
	log("shopController init");
	
	var opts			= {};
	opts.itemSelector	= ".product";
	opts.layoutMode		= "fitRows";
	
	$('.product a').click(function($e){
		$e.preventDefault();
		$('.section-content-wrapper').animate({left:"-786px"});
		$('#s_shop .section-content').animate({height: "580px"});
		return false;
	});
	
	
}

shopController.change 	= function (){
	log("shopController change");
	$('section, #s_loader, #s_shop .section-content, #s_shop .right-img').hide();
	$('#s_shop').show('slow', function(){$('#s_shop .section-content:not(#product_detail)').show('fast', function(){$('#s_shop .right-img').show();});});

}//end change function