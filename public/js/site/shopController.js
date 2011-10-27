shopController.init		= function (){
	log("shopController init");
	
	var opts			= {};
	opts.itemSelector	= ".product";
	opts.layoutMode		= "fitRows";
	
//	$('#shop_grid').isotope(opts);
	
}

shopController.change 	= function (){
	log("shopController change");
	$('section, #s_loader, #s_shop .section-content, #s_shop .right-img').hide();
	$('#s_shop').show('slow', function(){$('#s_shop .section-content').show('fast', function(){$('#s_shop .right-img').show();});});
}//end change function