shopController.change = function (){
	log("shopController change");
	$('section, #s_loader, #s_shop .section-content').hide();
	$('#s_shop').show('slow', function(){$('#s_shop .section-content').fadeIn('fast');});
}//end change function