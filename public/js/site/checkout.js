log("checkout js");

coController = {};

coController.copyAddress = function(){
	log("copy Address? "+ 	$('#billing1-bill_as_ship').val());
	
};
coController.addHandlers = function(){
	$('#billing1-bill_as_ship').click(coController.copyAddress);
};