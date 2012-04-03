<?php

class Application_Model_SiteModel
{
	public static $NEW_YORK_CITY_TAX	= 0.08875;//8.875%
	
	public static $CART_TYPE_REAL 		= "real";
	public static $CART_TYPE_WISHLIST 	= "wishlist";
	public static $CART_TYPE_POST 		= "post";

	public static $ROLE_TYPES	= array("administrator","customer", "accounting", "sales", "production");
	
	public static $ORDER_STATUS			= array('Incomplete Sale',
												'Order Received',
												'Accepted Payment',
												'Job Dispatched',
												'Close Order',
												'Payment Declined'
											);
	public static $CART_TYPES			= array('real','wishlist','preorder');
}

