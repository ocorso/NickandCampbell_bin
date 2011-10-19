shopController.init		= function (){
	log("shopController init");
	
	var opts			= {};
	opts.itemSelector	= ".product";
	opts.layoutMode		= "fitRows";
	
	$('#shop_grid').isotope(opts);
	
}

shopController.change 	= function (){
	log("shopController change");
	$('section, #s_loader, #s_shop .section-content').hide();
	$('#s_shop').show('slow', function(){$('#s_shop .section-content').fadeIn('fast');});
}//end change function