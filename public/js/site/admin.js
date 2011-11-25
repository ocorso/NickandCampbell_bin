/**
 * @Author - Owen Corso
 * 
 */
var adminController = {};

adminController.init = function() {
	log('admin');	
	var oTable = $('#orders_grid').dataTable( {
		"bProcessing": true,
		"bJQueryUI": true,
		"sAjaxSource": "/order",
		"aoColumns": [
			{ "mDataProp": "engine" },
			{ "mDataProp": "browser" },
			{ "mDataProp": "platform.inner" },
			{ "mDataProp": "platform.details.0" },
			{ "mDataProp": "platform.details.1" }
		]
	} );
};
