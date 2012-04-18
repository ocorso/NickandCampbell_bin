<?php

class Application_Model_SiteModel
{
	public static $NEW_YORK_CITY_TAX	= 0.08875;//8.875%
	public static $ORIGIN_STATE			= "NY";
	
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
	public static $ORDER_RESPONSE_CODES	= array(1=>"Approved",2=>"Declined",3 => "Error",4 => "Held for Review");										
	public static $CART_TYPES			= array('real','wishlist','preorder');
	public static $TEMP_CHECKOUT		= array(
				'subtotal'=> 35.00,
				'shipping1'=>array(	'cust_first_name'=>'Joe',
									'cust_last_name'=>'Temp',
									'cust_email'=>'temp@ored.net',
									'password'=>'hot0rnot',
									'cust_phone'=>'2016020069',
									'addr1'=>'410 E13th Street',
									'addr2'=>'Apt 1E',
									'city'=>'New York',
									'state'=>'NY',
									'zip'=>10003,
									'country'=>"United States"
					),
				'shipping2'=>array('sh_type'=>1	),
				'billing1'=>array(	'addr1'=>'410 E13th Street',
									'addr2'=>'Apt 1E',
									'city'=>'New York',
									'state'=>'NY',
									'zip'=>10003,
									'country'=>"United States"
					),
				'billing2'=>array(	'name_on_card'=>"Owen M Corso",
									'card_type'=>'visa',
									'card_num'=>'6011000000000012',
									'ccv'=>123,
									'exp_date'=>'04/15'
					)
			
			);
}

