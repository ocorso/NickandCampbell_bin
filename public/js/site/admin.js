/**
 * @Author - Owen Corso
 * 
 */
var adminController = {};
adminController.orders = {};
adminController.nCloneTh = document.createElement( 'th' );
adminController.nCloneTh.className = "ui-state-default";

adminController.nCloneTd = document.createElement( 'td' );
adminController.nCloneTd.innerHTML = '<img class="expand-btn" src="../css/admin-theme/images/details_open.png">';
adminController.nCloneTd.className = "center";

/* Formating function for row details */
adminController.fnFormatDetails = function (nTr )
{
    var aData = adminController.oTable.fnGetData( nTr );
    log(aData);
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
    sOut += '<tr><td>Name:</td><td>'+aData.customer.name+'</td></tr>';
    sOut += "<tr><td>Shipping Address:</td><td><a href='#' class='shipping-btn' title='Shipping Address'>Shipping Address</a></td></tr>";
    sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
    sOut += '</table>';
     
    return sOut;
};

adminController.onShippingClick	= function ($e){
	log("shipping on " + $(this));
};
adminController.onAJAXComplete = function ($e, $d){
	
	log("orders ajax complete");
	if ($e) log($e);
	if ($d) adminController.orders = $d;
	
	//add expand
    $('#orders_grid tbody tr').each( function () {
        this.insertBefore(  adminController.nCloneTd.cloneNode( true ), this.childNodes[0] );
    } );
    /*
     * Insert a 'details' column to the table
     */
    
    $('#orders_grid thead tr, #orders_grid tfoot tr').each( function () {
    	//	log("hi adding head and footer");
    	   this.insertBefore( adminController.nCloneTh.cloneNode( true ), this.childNodes[0] );
    } );
	
	$('.shipping-btn').bind('click', adminController.onShippingClick)
	
	/* Add event listener for opening and closing details
	 * Note that the indicator for showing which row is open is not controlled by DataTables,
	 * rather it is done here
	 */
	$('.expand-btn').bind('click', function () {
		log("click");
		var nTr = this.parentNode.parentNode;
		if ( this.src.match('details_close') )
		{
			/* This row is already open - close it */
			this.src = "../css/admin-theme/images/details_open.png";
			adminController.oTable.fnClose( nTr );
		}
		else
		{
			/* Open this row */
			this.src = "../css/admin-theme/images/details_close.png";
			adminController.oTable.fnOpen( nTr, adminController.fnFormatDetails(nTr), 'order-details' );
		}
	} );
};

adminController.init = function() {
	log('admin init');	
	
	$.address.init(function(){}).change(adminController.change);
	
	$("#tabs").tabs( {
		"show": function(event, ui) {
			var oTable = $('div.dataTables_scrollBody>table.display', ui.panel).dataTable();
			if ( oTable.length > 0 ) {
				oTable.fnAdjustColumnSizing();
			}
		}
	} );
     
    /*
     * Initialse DataTables, with no sorting on the 'details' column
     */
    
    adminController.oTable = $('#orders_grid').dataTable( {
        "aoColumnDefs": [
//                         { "bSortable": false, "aTargets": [ 0 ] },
                         { "sClass":"center", "aTargets":["_all"]}
                       
                     ],	
        "aaSorting": [[1, 'asc']],	
    	"bProcessing": true,
    	"bJQueryUI": true,
    	"fnInitComplete": adminController.onAJAXComplete,
    	"sAjaxDataProp": "orders",
    	"sAjaxSource": "/order",
    	"aoColumns": [
    	              { "mDataProp": "oid" },
    	              { "mDataProp": "total_price" },
    	              { "mDataProp": "customer.name" },
    	              { "mDataProp": "customer.email" },
    	              { "mDataProp": "customer.phone" },
    	              { "mDataProp": "status"}
    	              ]
    } );
    
    //products
	$('#products_grid.display').dataTable( {
		"sScrollY": "200px",
		"bScrollCollapse": true,
		"bPaginate": false,
		"bJQueryUI": true,
		"aoColumnDefs": [
			{ "sWidth": "10%", "aTargets": [ -1 ] }
		]
	} );
};
adminController.change 	= function ($e){
	

		log('change admin')
		switch ($.address.value()){
			case "/" : log("we're at admin base");
				//mainController.cart.open();
				break;
			case "/edit-product" : log("checkout complete");
				break;
			default: 
				var url = $.address.baseURL().replace('/admin', "") +$.address.value();
				window.location = url;
		}//endswitch
};
